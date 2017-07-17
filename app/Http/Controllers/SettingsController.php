<?php

namespace App\Http\Controllers;
use App\Models\Subscribe;
use App\TableSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Socials;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Address;
use App\Models\CarSettings;
use Auth;
use Image;
use Input;
use DB;

class SettingsController extends Controller
{
    static $lang_data = ['ru','ro'];
    public function __construct()
    {
        $this->middleware('auth');
    }
    function ListSocials(){

        $social=Socials::orderBy('id','desc')->get();

        return view('admin.settings.ListSocial',compact('social'));
    }
    public function settings()
    {
        $settings = Settings::first();
        return view('admin.settings.FormSettings', compact('settings'));
    }
    public function TableSize(){
        $table = TableSize::first();
        return view('admin.table.FormTable',compact('table'));
    }
    public function TableSizeAdd(Request $request){
        $input = $request->all();
        $rules = [
            'description_ro' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
        ];

        $valid = Validator::make($input,$rules);
        if ($valid->fails()){
            return redirect()->back()->withError($valid)->withInput();
        }
        $table  = TableSize::find(1);
        $table->description_ru = $input['description_ru'];
        $table->description_en = $input['description_en'];
        $table->description_ro = $input['description_ro'];

        if ($table->save()) {
            Session::put('success', trans('admin.data_save'));
            return redirect()->back();
        }
    }

    public function editSettings(Request $request)
    {
            $input = $request->all();
            $settings = Settings::find(1);
//            $settings->email = isset($input['email']) ? $input['email'] : '';
            $settings->email_sales = isset($input['email_sales']) ? $input['email_sales'] : '';
            $settings->default_email = isset($input['default_email']) ? $input['default_email'] : '';
            $settings->email_notification = isset($input['email_notification']) ? $input['email_notification'] : '';
            $settings->prefix_phone = isset($input['prefix_phone']) ? $input['prefix_phone'] : '';
            $settings->prefix_phone2 = isset($input['prefix_phone2']) ? $input['prefix_phone2'] : '';
            $settings->new = isset($input['new']) ? $input['new'] : 0;
            $settings->phone = isset($input['phone']) ? $input['phone'] : 0;
            $settings->phone2 = isset($input['phone2']) ? $input['phone2'] : 0;
            $settings->name_project = isset($input['name_project']) ? $input['name_project'] : 0;

            $fill = ['address_','graffic_'];
            $langs = self::$lang_data;
            foreach ($langs as $lang){
                foreach ($fill as $item){
                    $obj=$item.$lang;
                    $settings->$obj = $input[$obj];
                }
            }

            $settings->map_x= isset($input['map_x']) ? $input['map_x'] : 0;
            $settings->map_y = isset($input['map_y']) ? $input['map_y'] : 0;

            if ($settings->save()) {
                Session::put('success', trans('admin.data_save'));
                return redirect()->back();
            } else {
                return Redirect::back()->withErrors(trans('admin.data_not_save'));
            }
    }
    function FormSocials($id = null)
    {
        if(is_null($id)){
            return view('admin.settings.FormSocial');
        }else{
            $rules=['id'=>'required|exists:socials,id'];
            $v=Validator::make(['id'=>$id],$rules);
            if($v->fails()){
                return  response()->view('404',404);
            }
            $social = Socials::find($id);
            return view('admin.settings.FormSocial',compact('social'));
        }
    }
    function AddSocials(Request $request)
    {
        $input = $request->all();
        if (!isset($input['id']))
        {
            $rules = [
                'image' => 'required|mimes:jpg,jpeg,png,bmp',
                'url' => 'required|url',
            ];
        }else
        {
            $rules = [
                'image' => 'mimes:jpg,jpeg,png,bmp',
                'url' => 'required|url',
            ];
        }

        $validator = Validator::make($input,$rules);
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        if(isset($input['id'])){
            $social = Socials::find($input['id']);
        }else {
            $social = new Socials();
        }
            if ($request->hasFile('image'))
            {
                if (!empty($social->image))
                {
                    File::delete(public_path() . '/images/social/' . $social->image);
                }
                $origName = $input['image']->getClientOriginalExtension();
                $nameImg = str_random(10) . '.' . $origName;
                $images = \Image::make(\Input::file('image'));
                $path = public_path().'/images/social/';
                $images->fit(40,40);
                $images->save($path.$nameImg);
                $social->image= $nameImg;
            }

            $social->url = $input['url'];


        if (isset($input['status']))
        {
            $social->status = $input['status'];
        } else
        {
            $social->status = 1;
        }


        if (is_numeric($input['sort_order']))
        {
            $social->sort_order = $input['sort_order'];
        }
        else
        {
            $social->sort_order = Socials::max('sort_order') + 1 ;
        }

        $social->save();
        return  redirect()->route('socials')->with('success',trans('admin.data_added'));
    }
    function DeleteSocials(Request $request)
    {
        $input=$request->all();

        $rules=[
            'id'    =>'required|exists:socials,id'
        ];

        $v=Validator::make($input,$rules);

        if($v->fails()){
            return back()->withErrors($v);
        }

        $social =Socials::find($input['id']);

            if (!empty($social->image))
            {
                if (file_exists(public_path() . '/images/social/' . $social->image))
                {
                    unlink(public_path() . '/images/social/' . $social->image);
                }

            }

        if($social->delete()){
            return back()->with('success',trans('admin.data_deleted'));
        }else {
            return back()->withErrors($social->delete());
        }
    }


    public function ListAddress()
    {
        $address = Address::orderBy('id','desc')->get();
        return view('admin.address.ListAddress',compact('address'));
    }
    public function FormAddress($id = null){
        if($id){
            $address= Address::where('id',$id)->first();
        }
        return view('admin.address.FormAddress',compact('address'));
    }
    public function AddAddress(Request $request){
        $input = $request->all();
        $rules = [
            'name_ru' => 'required|max:255',
            'name_ro' => 'required|max:255',
            'name_en' => 'required|max:255',
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{

            if( isset( $input['id'] ) )
            {
                $address = Address::find($input['id']);
                if(!$address){
                    $address= new Address();
                }
            }
            else{
                $address= new Address();
            }

            $address->name_ru  = $input['name_ru'];
            $address->name_ro  = $input['name_ro'];
            $address->name_en  = $input['name_en'];
            if( $address->save() )
            {

                Session::put('success',trans('admin.data_save'));
                return Redirect::route('admin_location');
            }
            else
            {
                return redirect()->back();
            }
        }

    }
    public function deleteAddress(Request $request){
        $input = $request->all();
        Address::find($input['id'])->delete();
        Session::put('success',trans('admin.data_deleted'));
        return Redirect::back();
    }


}
