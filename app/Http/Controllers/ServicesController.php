<?php

namespace App\Http\Controllers;

use App\Models\CategorySection;
use App\Models\CategoryService;
use App\Models\ServiceCategory;
use App\Models\Services;
use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class ServicesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
     static  $data_lang = ['ru','ro'];
     static  $limit__section_home = 3;

    public function ListSection(){
       $section = ServiceSection::orderBy('sort_order')->orderBy('id','desc')->paginate(15);
        return view('admin.services.ListSection',compact('section'));
    }
    public function FormSection($slug= null){
        if ($slug){
            $section = ServiceSection::find($slug);
        }
        $limit = self::$limit__section_home;
        $total = ServiceSection::where('home',1)->count();
        return view('admin.services.FormSection',compact('section','limit','total'));
    }
    public function addSection(Request $request){
        $input = $request->all();
        $rules = [
            'name_ru' => 'required|string|max:250',
            'name_ro' => 'required|string|max:250',
        ];

        $valid = Validator::make($input,$rules);

        if ($valid->fails()){
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (isset($input['id']) && !empty($input['id'])){
            $section = ServiceSection::find($input['id']);
        }else{
            $section = new ServiceSection();
        }

        $files = ['name_'];
        $langs = self::$data_lang;

        foreach ($langs as $lang){
            foreach ($files as $file){
                $obj = $file.$lang;
                $section->$obj = $input[$obj];
            }
        }
        $section->status = $input['status'];
        if ($input['sort_order'] && !empty($input['sort_order'])){
            $section->sort_order = $input['sort_order'];
        }else{
            $section->sort_order = ServiceSection::max('sort_order') +1 ;
        }

        if (isset($input['home']) && !empty($input['home'])){
            $section->home  = 1;
        }


        if ($request->hasFile('image')) {
            if (!empty($section->image)) {
                File::delete(public_path() . '/images/section/' . $section->image);
            }
                $origName = $input['image']->getClientOriginalExtension();
                $nameImg = str_random(10) . '.' . $origName;
                $image = \Image::make(\Input::file('image'));
                $path = public_path() . '/images/section/';
                    list($width, $height) = getimagesize(\Input::file('image'));
                if( $width > 507 ){
                    $image->resize(507, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $image->save($path.$nameImg);
                $section->image = $nameImg;
        }
            if ($section->save()){
                $section->slug_ro = str_slug($input['name_ro']) . '-' . $section->id;
                $section->slug_ru = str_slug($input['name_ru']) . '-' . $section->id;
            }
            return redirect()->route('admin_section')->with('success', trans('admin.data_added'));
    }
    public function deleteSection(Request $request){
        $input = $request->all();
        $rules = ['id' => 'required|exists:service_section,id'];
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withErrors($v);
        }
        $section = ServiceSection::find($input['id']);

//       $section_cat =  DB::table('service_category')->
//        join('category_section','service_category.id','=','category_section.category_id')
//            ->where('section_id',$input['id']);
//        $section_cat ->update(['.status'=>0]);
//        $categ = $section_cat ->get();
//        $categ = $this->toArray($categ,'category_id');
//        if(count($categ)){
//        DB::table('services')->
//            join('category_service','services.id','=','category_service.service_id')
//                -> whereIn('category_id',$categ)
//                -> update(['services.status'=>0]);
//        }

        CategorySection::where('section_id',$input['id'])->delete();
        if (!empty($section->image)) {
            if (file_exists(public_path() . '/images/section/' . $section->image)) {
                unlink(public_path() . '/images/section/' . $section->image);
            }
        }

        if ($section->delete()) {
            return back()->with('success', trans('admin.data_deleted'));
        } else {
            return back()->withErrors($section->delete());
        }
    }

    public function deleteService(Request $request){
        $input = $request->all();
        $rules = ['id' => 'required|exists:services,id'];
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withErrors($v);
        }
        $services = Services::find($input['id']);

        if ($services->delete()) {
            return back()->with('success', trans('admin.data_deleted'));
        } else {
            return back()->withErrors($services->delete());
        }
    }
    public function ListServCategory(){
        $cat = ServiceCategory::orderBy('sort_order')->orderBy('id','desc')->paginate(15);
        return view('admin.services.ListSerCategory',compact('cat'));
    }
    public function FormServCategory($slug= null){
        if ($slug){
            $section = ServiceCategory::find($slug);
            $result = CategorySection::where('category_id',$slug)->get();
            $active = $this->toArray($result,'section_id');
        }
        return view('admin.services.FormServCategory',compact('section','active'));
    }
    public function AddServCategory(Request $request){
        $input = $request->all();

        $rules = [
            'name_ru' => 'required|string|max:250',
            'name_ro' => 'required|string|max:250',
        ];

        $valid = Validator::make($input,$rules);

        if ($valid->fails()){
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if (isset($input['id']) && !empty($input['id'])){
            $section = ServiceCategory::find($input['id']);
        }else{
            $section = new ServiceCategory();
        }

        $files = ['name_'];
        $langs = self::$data_lang;

        foreach ($langs as $lang){
            foreach ($files as $file){
                $obj = $file.$lang;
                $section->$obj = $input[$obj];
            }
        }
        $section->status = $input['status'];
        if ($input['sort_order'] && !empty($input['sort_order'])){
            $section->sort_order = $input['sort_order'];
        }else{
            $section->sort_order = ServiceCategory::max('sort_order') +1 ;
        }
            $section->save();

        CategorySection::where('category_id',$section->id)->delete();
        if (isset($input['section']) && count($input['section'])){
            foreach ($input['section'] as $item){
                $cat = new CategorySection();
                $cat->section_id = $item;
                $cat->category_id = $section->id;
                $cat->save();
            }
        }

        return redirect()->route('serv_category')->with('success', trans('admin.data_added'));
    }
    public function deleteServCategory(Request $request){
        $input = $request->all();
        $rules = ['id' => 'required|exists:service_category,id'];
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withErrors($v);
        }

        $section = ServiceCategory::find($input['id']);
         DB::table('services')->
         join('category_service','services.id','=','category_service.service_id')
             -> where('category_id',$input['id'])
             -> update(['services.status'=>0]);
         CategoryService::where('category_id',$input['id'])->delete();

        if ($section->delete()) {
            return back()->with('success', trans('admin.data_deleted'));
        } else {
            return back()->withErrors($section->delete());
        }
    }
    public function ListService(){
        $services = Services::orderBy('id','desc')->paginate(15);
        return view('admin.services.ListSerices',compact('services'));
    }
    public function FormService($slug = null){
        if($slug){
            $section = Services::find($slug);
            $result = CategoryService::where('category_id',$slug)->get();
            $active = $this->toArray($result,'service_id');
        }
        return view('admin.services.FormServices',compact('section','active'));
    }
    public function AddService(Request $request){
       $input= $request->all();
       $rules = [
           'name_ru' => 'required|string|max:250',
           'name_ro' => 'required|string|max:250',
           'meta_name_ro' => 'required|string|max:250',
           'meta_name_ru' => 'required|string|max:250',
       ];

       $valid = Validator::make($input,$rules);
       if($valid->fails()){
            return redirect()->back()->withErrors($valid)->withInput();
       }

       if (isset($input['id']) && !empty($input['id'])){
           $service = Services::find($input['id']);
       }else{
           $service = new Services();
       }


       $files =['name_','meta_name_','meta_description_','description_'];
       $langs= self::$data_lang;

       foreach ($langs as $lang){
           foreach ($files as $file){
               $obj = $file.$lang;
               $service->$obj = $input[$obj];
           }
       }

       if (isset($input['sort_order']) && !empty($input['sort_order'])){
           $service->sort_order = $input['sort_order'];
       }else{
           $service->sort_order = Services::max('sort_order') + 1;
       }
       $service->status = $input['status'];

       if ($service->save()){
           CategoryService::where('category_id',$service->id)->delete();
           if (isset($input['section']) && count($input['section'])){
               foreach ($input['section'] as $item){
                   $cat = new CategoryService();
                   $cat->service_id = $item;
                   $cat->category_id = $service->id;
                   $cat->save();
               }
           }

           return redirect()->route('admin_services')->with('success', trans('admin.data_added'));
       }
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
