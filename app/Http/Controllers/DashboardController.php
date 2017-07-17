<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;
use Hash;
use URL;
use Auth;

class DashboardController extends Controller{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function dashboard(){
        $settings = Settings::first();
        $days = $settings->new . " days";
        $curentDate = date_create(date("Y/m/d"));
        date_sub($curentDate, date_interval_create_from_date_string($days));
        $data = date_format($curentDate, 'Y-m-d');
        $newProduct = Product::where(['status' => '1'])
            ->where('created_at', '>', $data)
            ->get();
        $new = $this->toArray($newProduct,'id');

        $order = Order::where('customer_id',Auth::guard('customer')->user()->id)->get();
        foreach ($order as $item){
            $item['product_order'] = OrderProduct::where('order_id',$item->id)->get();
        }
        return view('dashboard',compact('new','order'));
    }
    protected function EditDataUser(Request $request){
        $input = $request->all();
        $rules = [
            'name'     => 'max:250|string',
            'phone'    => 'max:250|string',
            'city'     => 'max:250|string',
            'street'   => 'max:250|string',
            'house'   => 'max:250|string',
            'entrance' => 'max:250|string',
            'floor'    => 'max:250|string',
            'apartment'=> 'max:250|string',
        ];
        $v=Validator::make($input,$rules);
        if($v->fails()){
            $data['error_changed'] = trans('register.error_changed');
            return json_encode($data);
        }
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $customer->name = $input['name'];
        $customer->phone = $input['phone'];
        $customer->city = $input['city'];
        $customer->street = $input['street'];
        $customer->house = $input['house'];
        $customer->entrance = $input['entrance'];
        $customer->floor = $input['floor'];
        $customer->apartment = $input['apartment'];
        $customer->save();
        $data['success'] = 1;

        return json_encode($data);
    }
    protected function ChangePassUser(Request $request){
        $input = $request->all();
        $rules = [
            'oldPas'=>'required|min:6|max:20',
            'newPas' => 'required|min:6|max:20',
            'PasRepeat' => 'required|same:newPas',
        ];
        $message = [
            'oldPas.required' =>  trans('v.required_old_password'),
            'oldPas.min'      =>  trans('v.min_old_password'),
            'oldPas.max'      =>  trans('v.max_old_password'),
            'newPas.required'    =>  trans('v.required_password'),
            'newPas.min'         =>  trans('v.min_password'),
            'newPas.max'         =>  trans('v.max_password'),
            'PasRepeat.same'   =>  trans('v.same_password'),
            'PasRepeat.required' =>trans('v.same_password'),
        ];
        $v = Validator::make($input, $rules, $message);

        if ($v->fails()) {
            return json_encode($v->messages());
        }
        $oldpassword = $input['oldPas'];
        $user= Customer::find(Auth::guard('customer')->user()->id);

        if (Auth::guard('customer')->attempt(['email' =>$user->email, 'password' => $oldpassword])) {
            $user->password =  bcrypt($input['newPas']);
            $user->save();
            $data_responce['success'] = trans('v.changePass-success');
        }else{
            $data_responce['message']= trans('v.error_old_password');
        }

        return json_encode($data_responce);

    }
    public function toArray($obj,$option){
        if(is_object($obj)){
            $curr = [];
            foreach ($obj as $item){
                array_push($curr,$item->$option);
            }
            return $curr;
        }else{
            dd($obj ." -> is not Object");
        }
    }
}
