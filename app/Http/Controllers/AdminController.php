<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\User;
use DB;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Customer;
use App\Models\Address;
use App\Models\MailModel;
use Auth;
use Hash;
use Excel;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('admin.index');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function LisetUser()
    {
        if (Auth::user()->role != 2) {
            return redirect()->route('admin');
        }
        $user = User::orderBy('id', 'desc')->paginate(25);
        return view('admin.user.ListUser', compact('user'));
    }

    public function FormUser($id = null)
    {
        if (Auth::user()->role != 2) {
            return redirect()->route('admin');
        }
        if ($id) {
            $user = User::find($id);
        }
        return view('admin.user.FormUser', compact('user'));
    }

    public function AddUser(Request $request)
    {
        if (Auth::user()->role != 2) {
            return redirect()->route('admin');
        }
        $input = $request->all();
        if (isset($input['id'])) {
            $rules = [
                'name' => 'required',
                'password' => 'required|min:6',
                'email' => 'required|email',
                'repeat_password' => 'required|same:password|min:6',
            ];
        } else {
            $rules = ['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|min:6', 'repeat_password' => 'required|same:password|min:6',];
        }
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        } elseif (isset($input['id']) && !empty($input['id'])) {
            $user = User::find($input['id']);
        } else {
            $user = new User();
        }
        $user->email = $input['email'];
        $user->name = $input['name'];
        $user->password = Hash::make($input['password']);
        $user->status = 1;
        if ($user->save()) {
            Session::put('success', trans('admin.data_save'));
            return Redirect::route('list_admin');
        }
    }

    public function DeleteUser(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['id']);
        $user->delete();
        Session::put('success', trans('admin.data_save'));
        return Redirect::route('list_admin');
    }
    public function ListCustomer()
    {
        $user = Customer::orderBy('id', 'desc')->get();
        return view('admin.user.ListCustomer', compact('user'));
    }
    public function FormCustomer($id = null)
    {
        if ($id) {
            $customer = Customer::find($id);
        }
        return view('admin.user.FormCustomer', compact('customer'));
    }
    public function AddCustomer(Request $request)
    {
        $input = $request->all();
        if (isset($input['id'])) {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'password' => 'required|min:6',
                'email' => 'required|email',
                'repeat_password' => 'required|same:password|min:6',
            ];
        } else {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required',
                'repeat_password' => 'required|same:password|min:6',
            ];
        }

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        } elseif (isset($input['id']) && !empty($input['id'])) {
            $user = Customer::find($input['id']);
        } else {
            $user = new Customer();
        }
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        $user->street = $input['street'];
        $user->name = $input['name'];
        $user->password = Hash::make($input['password']);
        $user->status = 1;
        if ($user->save()) {
            Session::put('success', trans('admin.data_save'));
            return Redirect::route('list_customer');
        }
    }
    public function DeleteCustomer(Request $request){
        $input = $request->all();
        if ($input['id']) {
            $user = Customer::find($input['id']);
            $user->delete();
        }
        Session::put('success', trans('admin.data_deleted'));
        return Redirect::route('list_customer');

    }
    public function getOrders()
    {
        $orders = DB::table('order')
            ->orderBy('id', 'desc')
            ->paginate(20);
        $status = OrderStatus::get();
        return view('admin.order.ListOrder', compact('orders', 'status'));

    }

    public function showOrder($id)
    {
        $order = Order::where('id', $id)->first();
        if ($order->tip_delivery == 1) {
            $ship = Address::where('id', $order->place)->first();
        } else {
            $ship = "";
        }
        $productOrder = DB::table('product_order')->where('order_id', $id)->get();
        $status = OrderStatus::get();
        $settings = Settings::first();
        return view('admin.order.DetailOrder', compact('order', 'productOrder', 'status', 'ship', 'method_pay','settings'));

    }

    public function editOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $status = OrderStatus::get();
        return view('admin.order.EditOrderStatus', compact('order', 'status'));

    }

    public function changeStatus(Request $request){
        $input = $request->all();
        if (isset($input['order_id'])) {
            $order = Order::find($input['order_id']);
            $order->order_status_id = $input['status'];
            $order->text_order = $input['text_order'];
            $order->save();

            if ($input['status']) {
                $productOrder = DB::table('product_order')->where('order_id', $order->id)->get();
                Lang::putLocale($order->lang);
                foreach ($productOrder as $item) {
                    $prod = Product::where('id', $item->product_id)->first();
                    if ($input['status'] == 3) {
                        if (!empty($prod)) {
                            $prod->count_prod += 1;
                            $prod->save();
                        }
                    }
                }
                if (isset($input['send']) && $input['send'] == 1) {
                    if ($input['status'] == 1) {
                        $layouts = "email.mail_send_buy_step_1";
                        $subject = trans('cart.email_step1') . $input['order_id'] . " " . trans('cart.email_step2');
                    }
                    if ($input['status'] == 2) {
                        $layouts = "email.mail_send_buy_step_2";
                        $subject = trans('cart.email_step1') . $input['order_id'] . " " . trans('cart.email_step3');
                    }
                    if ($input['status'] == 3) {
                        $layouts = "email.mail_send_buy_step_3";
                        $subject = trans('cart.email_step1') . $input['order_id'] . " " . trans('cart.email_step4');
                    }
                    if ($input['status'] == 4) {
                        $layouts = "email.mail_send_buy_step_4";
                        $subject = trans('cart.email_step1') . $input['order_id'] . " " . trans('cart.email_step5');
                    }
                    if (isset($input['text_order'])) {
                        $text_order = $input['text_order'];
                    } else {
                        $text_order = "";
                    }
                    $data_mail = [
                        'time' => date("d-m-Y"),
                        'products_rs' => $productOrder,
                        'order' => $order,
                        'settings' => Settings::first(),
                        'subject' => $subject,
                        'layouts' => $layouts,
                        'text_order' => $text_order,
                    ];

                    $this->SendMailBuyProduct($data_mail);
                }
                Session::put('success', trans('admin.data_save'));
                return redirect()->route('admin_order');

            } else {
                return redirect()->route('admin_order')->with('success', trans('admin.data_not_save'));
            }
        }
    }

    public function deleteOrders(Request $request) {
        $input = $request->all();
        $order = Order::find($input['id']);
        OrderProduct::where('order_id', $order->id)->delete();
        $order->delete();
        Session::put('success', trans('admin.data_deleted'));
        return Redirect::route('admin_order');
    }

    public function SendMailBuyProduct($data) {
        $settings = Settings::first();
        Mail::send($data['layouts'], $data, function ($message) use ($data, $settings) {
            $message->to($data['order']->email)->from(MailModel::first()->from_name, $settings->name_project)->subject($data['subject']);
        });

    }

    function Email(){
        $mail = MailModel::first();
        return view('admin.email.mail', compact('mail'));
    }

    function EditEmail(Request $request){
        $input = $request->all();

        $rules = [
            'driver' => 'required|string|max:10|min:2',
            'host' => 'required|string|min:5|max:30',
            'port' => 'numeric|min:1|max:9999',
            'from_name' => 'required|string|min:3|max:50',
            'encryption' => 'required|string|min:2|max:10',
            'username' => 'required|string|min:5|max:50|email',
            'password' => 'required|string|min:5|max:50',
        ];

        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withInput()->withErrors($v);
        }
        $edit = MailModel::first();
        $edit->driver = $input['driver'];
        $edit->host = $input['host'];
        $edit->port = $input['port'];
        $edit->from_address = $input['username'];
        $edit->from_name = $input['from_name'];
        $edit->encryption = $input['encryption'];
        $edit->username = $input['username'];
        $edit->password = $input['password'];
        $edit->save();
        return back()->with('success', trans('data_save_success'));
    }

    public function getFilterOrder(Request $request) {
        $input = $request->all();
        $name = 'name_'.Lang::getLocale();
        $select = "SELECT * FROM `order` WHERE 1=1 ";
        if (isset($input['order_id']) && !empty($input['order_id'])) {
            $select .= " AND id = '" . $input['order_id'] . "' ";
        }
        if (isset($input['filter_date_min']) && !empty($input['filter_date_min'])) {
            $dt =  new \DateTime($input['filter_date_min']);
            $select .= "AND created_at >= '" .$dt->format('Y-m-d')."'";
        }
        if (isset($input['filter_date_max']) && !empty($input['filter_date_max'])) {
            $dt =  new \DateTime($input['filter_date_max']);
            $select .= " AND created_at <=  '".$dt->format('Y-m-d')."'";
        }
        if (is_numeric($input['filter_status'])) {
            $select .= " AND order_status_id = " . $input['filter_status'];
        }
        if (isset($input['name_customer']) && !empty($input['name_customer'])) {
            $select .= " AND name LIKE '%" . $input['name_customer'] . "%' ";
        }
        $select .= " ORDER BY id desc";
        $tot = DB::select($select);
        $data['total'] = count($tot);
        $per_page = 20;
        if (!empty($input['page'])) {
            $page = $input['page'];
            $active_page = $input['page'];
            $page--;
            if ($page) {
                $start = $page * $per_page;
                $end = $per_page;
                $select .= ' LIMIT ' . $start . ',' . $end;
            } else {
                $start = 0;
                $end = $per_page;
                $select .= ' LIMIT ' . $start . ',' . $end;
            }
        } else {
            $active_page = 1;
            $page = 1;
            $start = 0;
            $end = $per_page;
            $select .= ' LIMIT ' . $start . ',' . $end;
        }
        $products = DB::select($select);
        $data['page'] = $page;
        $data['active'] = $active_page;
        $html = "";
        foreach ($products as $product) {
            $html .= "<tr>";
            $html .= " <td>".$product->id."</td>";
            $html .= " <td>".$product->name."</td>";
            $html .= " <td>".$product->total."</td>";
            $dt =  new \DateTime($product->created_at);
            $html .= " <td>".$dt->format('m.d.Y')."</td>";
            $dt =  new \DateTime($product->updated_at);
            $html .= " <td>".$dt->format('m.d.Y')."</td>";
            $od = OrderStatus::find($product->order_status_id);
            $html .= " <td>".$od->$name."</td>";

            $html .= '<td class="text-center">
                    <a href="'.asset('admin/order/show/'.$product->id).'">
                    <button class="btn btn-xs btn-info" data-toggle="modal"><i class="fa fa-info-circle"></i></button>
                    </a>
                    <a href="'.asset('admin/order/edit/'.$product->id).'">
                    <div data-toggle="modal" data-target="#edit_'.$product->id.'" class="edit-pencil btn btn-primary btn-xs">
                         <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    </a>
                     <div data-toggle="modal" onclick="deleteProducts(\''.$product->id.'\',\''.$product->id.'\')" class="delete-trash btn btn-danger btn-xs">
                          <span class="glyphicon glyphicon-trash"></span>
                     </div>
                    </td>';
            $html .= "</tr>";
        }
        $data['html'] = $html;
        return response()->json($data);
    }
    public function ExportCustomer(){
        $data = Customer::get();
        Excel::create('Subscribe', function($excel) use($data) {
            $excel->sheet('Tab1', function ($sheet) use ($data){

                $i = 1;
                foreach ($data as $subs){
                    $sheet->row($i, array($subs->email));
                    $i++;
                }
            });
        })->export('csv');
        return redirect()->back();
    }
}
