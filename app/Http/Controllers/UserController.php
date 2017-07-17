<?php

namespace App\Http\Controllers;
use App\Models\MailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customer;
use App\Models\Settings;
use Validator;
use Auth;
use Hash;
use URL;
use Mail;

class UserController extends Controller
{
    protected function LoginUser(Request $request){
        $input = $request->all();
        $rules = [
            'login'     => 'required|email|max:150|email|min:3',
            'pass'  => 'required|min:6|max:50|string',
        ];
        $messages=[
            'email.required' => trans('v.email_required'),
            'password.required' => trans('v.password_required'),
            'email.email'          =>trans('v.email_email'),
            'email.min'          =>trans('v.email_min'),
            'password.min'              =>trans('v.password_min'),
            'password.max' =>trans('v.password_max'),
        ];

        $v=Validator::make($input,$rules,$messages);
        if($v->fails()){
            $data['error'] = trans('v.not_loged');
            return json_encode($data);
        }

        if(Auth::guard('customer')->attempt(['email' => $input['login'], 'password' => $input['pass']])){
            $wish =  new WishListController();
            $wish->LoginAddToWishList();
            $cart = new CartController();
            $cart->LoginAddToCart();
            $data['success'] = 1;
        }else{
            $data['error'] = trans('v.not_loged');
        }
        return json_encode($data);
    }
    protected function registration(Request $request){
        $input = $request->all();
        $rules = [
            'email'     => 'required|unique:customer,email|max:150|email|min:3',
            'pass'  => 'required|min:6|max:50|string',
            'confirmed' => 'required|min:6|max:50|same:pass',
            'name'      => 'required|min:3|string|max:50',
            'phone'     => 'required|min:3|string|max:30',
        ];
        $messages=[
            'email.required' => trans('v.email_required'),
            'password.required' => trans('v.password_required'),
            'name.required' => trans('v.name_required'),
            'phone.required' => trans('v.phone_required'),
            'adress.required' => trans('v.address_required'),
            'email.unique'          =>trans('v.email_unique'),
            'email.max'          =>trans('v.email_max'),
            'email.email'          =>trans('v.email_email'),
            'email.min'          =>trans('v.email_min'),
            'password.min'              =>trans('v.password_min'),
            'password.confirmed'        =>trans('v.password_confirmation'),
            'password.max' =>trans('v.password_max'),
            'password_confirmation.min' =>trans('v.password_confirmation_min'),
            'password_confirmation.max' =>trans('v.password_confirmation_max'),
            'name.min'                  =>trans('v.name_min'),
            'name.max'                  =>trans('v.name_max'),
            'phone.min'                  =>trans('v.phone_min'),
            'phone.max'                  =>trans('v.phone_max'),
        ];
        $v=Validator::make($input,$rules,$messages);
        if($v->fails()){
            return json_encode($v->messages());
        }
        $customer = new Customer();
        $customer->name=$input['name'];
        $customer->email=$input['email'];
        $customer->phone=$input['phone'];
        $customer->password=bcrypt($input['pass']);
        $customer->status=1;
        $customer->remember_token=str_random(32);
        $customer->save();

        if(Auth::guard('customer')->attempt(['email' => $input['email'], 'password' => $input['pass']])){
            $wish =  new WishListController();
            $wish->LoginAddToWishList();
            $cart = new CartController();
            $cart->LoginAddToCart();
            $data['success'] = 1;
        }else{
            $data['success'] = 2;
        }
        return json_encode($data);
    }
    protected function ResetPassword(Request $request){
        $input = $request->all();
        $rules = [
            'email'     => 'required|exists:customer,email|max:150|email|min:3',
        ];

        $messages=[
            'email.required' => trans('v.email_required'),
            'email.exists' => trans('v.email_exists'),
            'email.max'          =>trans('v.email_max'),
            'email.min'          =>trans('v.email_min'),
        ];

        $v=Validator::make($input,$rules,$messages);

        if($v->fails()){
            return json_encode($v->messages());
        }
        $random = str_random(30);
        $user = Customer::where('email', $input['email'])->first();
        $user->string = $random;
        $name = $user->name;
        $user->save();
        $set = Settings::first();
        $data['string'] = $random;
        $data['email'] = $input['email'];
        $data['url'] = URL::route('mail_reset',$random);
        $data['name'] = $name;
        $mail = MailModel::first();
        Mail::send('email.PassReset', $data, function ($message) use ($data ,$set,$mail) {
            $message->to($data['email'])->from($mail->from_address,$set->name_project)->subject($set->name_project."- восстановление пароля");
        });
        $success['success'] = trans('v.email_sended');
        return json_encode($success);
    }
    protected function ResetPasswordString($string = null){
      if (!$string){
          return  response()->view('errors.404',compact('page'), 404);
      }
      $customer = Customer::where('string',$string)->first();
      if (!count($customer)){
          return  response()->view('errors.404',compact('page'), 404);
      }
      return view('auth.reset');

    }
    protected  function ResetPasswordForm(Request $request, $string = null){
        if (!$string){
            return  response()->view('errors.404',compact('page'), 404);
        }
        $customer = Customer::where('string',$string)->first();
        if (!count($customer)){
            return  response()->view('errors.404',compact('page'), 404);
        }
        $input = $request->all();
        $rules = [
            'resetUserNewPas'     => 'required|max:150|min:3',
            'resetUserPasRepeat'  => 'required|min:6|max:50|string|same:resetUserNewPas',
        ];
        $v=Validator::make($input,$rules);
        if($v->fails()){
           return redirect()->back();
        }
        $customer->password = bcrypt($input['resetUserNewPas']);
        $customer->string = str_random(30);
        $customer->save();
        if(Auth::guard('customer')->attempt(['email' => $customer->email, 'password' => $input['resetUserNewPas']])){
            return redirect()->route('home');
        }
    }
    public function  LogoutCustomer(){
        Auth::guard('customer')->logout();
        return redirect()->back();
    }
}
