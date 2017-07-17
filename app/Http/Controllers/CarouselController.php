<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\redirect;
use Illuminate\Support\Facades\File;
use Validator;
use Input;
use Image;

class CarouselController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    static $lang_data = ['ru','ro'];/*Array with languages*/

    function ListCarousel(){

        $carousel=Carousel::orderBy('id','desc')->get();

        return view('admin.carousel.ListCarousel',compact('carousel'));
    }
    function FormCarousel($id = null)
    {
        if(is_null($id)){
            return view('admin.carousel.FormCarousel');
        }else{
            $rules=['id'=>'required|exists:carousel,id'];
            $v=Validator::make(['id'=>$id],$rules);
            if($v->fails()){
                return  response()->view('404',404);
            }
            $carousel = Carousel::find($id);
            return view('admin.carousel.FormCarousel',compact('carousel'));
        }
    }
    function AddCarousel(Request $request)
    {
        $input = $request->all();
        if (!isset($input['id']))
        {
        $rules = [
                'image_ru' => 'required|mimes:jpg,jpeg,png,bmp|',
                'image_ro' => 'required|mimes:jpg,jpeg,png,bmp|',
//                'url_ru' => 'url',
//                'url_ro' => 'url',
//                'url_en' => 'url',
            ];
        }else
        {
            $rules = [
                'image_ru' => 'mimes:jpg,jpeg,png,bmp',
                'image_ro' => 'mimes:jpg,jpeg,png,bmp',
//                'url_ru' => 'url',
//                'url_ro' => 'url',
//                'url_en' => 'url',
            ];
        }

        $validator = Validator::make($input,$rules);
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        }

        if(isset($input['id'])){
            $carousel = Carousel::find($input['id']);
        }else {
            $carousel = new Carousel();
        }
        $langs = self::$lang_data;

        foreach ($langs as $lang)
        {
            $image = 'image_'.$lang;
            $url = 'url_'.$lang;
            if ($request->hasFile($image))
            {
                if (!empty($carousel->$image))
                {
                    File::delete(public_path() . '/images/carousel/' . $carousel->$image);
                }
                $origName = $input[$image]->getClientOriginalExtension();
                $nameImg = str_random(10) . '.' . $origName;
                $images = \Image::make(\Input::file($image));
                $path = public_path().'/images/carousel/';

                $images->resize(1140, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $images->save($path.$nameImg);
                $carousel->$image = $nameImg;
            }
            $carousel->$url = $input[$url];
        }

        if (isset($input['status'])) 
        {
        		$carousel->status = $input['status'];
        } else
        {
        	$carousel->status = 1;
        }	
        if (is_numeric($input['sort_order']))
        {
            $carousel->sort_order = $input['sort_order'];
        }else{
            $cars = Carousel::max('sort_order');
            $carousel->sort_order = ($cars)?$cars + 1:1;
        }
          $carousel->save();
          return  redirect()->route('admin_carousel')->with('success',trans('admin.data_added'));
    }
    function DeleteCarousel(Request $request)
    {
        $input=$request->all();

        $rules=[
            'id'    =>'required|exists:carousel,id'
        ];

        $v=Validator::make($input,$rules);

        if($v->fails()){
            return back()->withErrors($v);
        }
        $langs = static::$lang_data;
        $carousel =Carousel::find($input['id']);
        foreach ($langs as $lang){
            $image = 'image_'.$lang;
            if (!empty($carousel->$image)){
                if (file_exists(public_path() . '/images/carousel/' . $carousel->$image)){
                    unlink(public_path() . '/images/carousel/' . $carousel->$image);
                }

            }
        }
        if($carousel->delete()){
            return back()->with('success',trans('admin.data_deleted'));
        }else {
            return back()->withErrors($carousel->delete());
        }
    }
}

