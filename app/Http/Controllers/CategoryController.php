<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\CaracteristicCategory;
use App\Models\CategoryFilter;
use App\Models\Product;
use Image;
use Input;
use DB;

class CategoryController extends Controller {
    static $lang_data = ['ru','ro'];/*Array with languages*/
    static $level_category = 4;/* How many levels have the categories */
    public function __construct(){
        $this->middleware('auth');
    }
    public function ListCategories(){
        $categories = Categories::where('parent_id', '0')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        $level = self::$level_category;
        $categories = $this->LevelsCategory($categories,$level);
        return view('admin.categories.ListCategory', compact('level','categories'));
    }

    function LevelsCategory($categories,$level){
        foreach ($categories as $data) {
            if ($level >= 2) {
                $item = Categories::where(['parent_id' => $data->id, 'status' => 1])->orderBy('sort_order')->get();
                if (count($item)) {
                    $data['level2'] = $item;
                    if ($level >= 3) {
                        foreach ($item as $data2) {
                            $item2 = Categories::where(['parent_id' => $data2->id, 'status' => 1])->orderBy('sort_order')->get();
                            if (count($item2)) {
                                $data2['level3'] = $item2;
                                if ($level >= 4) {
                                    foreach ($item2 as $data3) {
                                        $item3 = Categories::where(['parent_id' => $data3->id, 'status' => 1])->orderBy('sort_order')->get();
                                        if (count($item3)) {
                                            $data3['level4'] = $item3;
                                            if ($level >= 5) {
                                                foreach ($item3 as $data4) {
                                                    $item3 = Categories::where(['parent_id' => $data3->id, 'status' => 1])->orderBy('sort_order')->get();
                                                    if (count($item3)) {
                                                        $data4 ['level5'] = $item3;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $categories;
    }
    public function FormCategories($id = null)
    {
        if (isset($id)) {
            $category = Categories::find($id);
        }
        return view('admin.categories.FormCategory', compact('categories', 'category'));
    }
    public function FormSubcategory($id = null)
    {
        if (isset($id)) {
            $cat = Categories::find($id);
        }
        return view('admin.categories.FormSubcategory', compact('cat'));
    }
    public function AddCategories(Request $request){
        $input = $request->all();
        $rules =
            [
                'name_ru'      => 'required|max:200|string',
                'name_ro'      => 'required|max:200|string',
                'meta_name_ro' => 'required|max:255|string',
                'meta_name_ru' => 'required|max:255|string',
            ];
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } elseif (isset($input['id']) && !empty($input['id'])) {
            $categories = Categories::find($input['id']);
        } else {
            $categories = new Categories;
        }
        $filds = [
            'name_',
            'meta_name_',
            'meta_description_',
            'seo_description_',
        ];
        $langs = self::$lang_data;
        foreach ($langs as $lang){
            foreach ($filds as $fild){
                $obj = $fild.$lang;
                $categories->$obj = $input[$obj];
            }
        }
        if ($request->hasFile('image')){
            if (!empty($categories->image)){
                File::delete(public_path() . '/images/categories/' . $categories->image);
            }

            $origName = $input['image']->getClientOriginalExtension();
            $nameImg = str_random(10) . '.' . $origName;
            $image = \Image::make(\Input::file('image'));
            $path = public_path().'/images/categories/';
            list($width, $height) = getimagesize(\Input::file('image'));
            if( $width > 900 )
            {
                $image->resize(900, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $image->save($path.$nameImg);
//            $image->fit(206, 200);

            $image->resize(206, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $categories->image = $nameImg;
            $image->save($path.'thumb_'.$nameImg);
        }

        if (!isset($input['parent_id']) || empty($input['parent_id'])){
            $categories->parent_id = 0;
            $sort_order =  Categories::where('parent_id',0)->max('sort_order') + 1;
        }elseif(isset($input['parent_id'])){
            $sort_order =  Categories::where('parent_id',$input['parent_id'])->max('sort_order') + 1;
            $categories->parent_id = !empty($input['parent_id']) ? $input['parent_id'] : 0;
        }


        $categories->sort_order = !empty($input['sort_order']) ? $input['sort_order'] : $sort_order;
        $categories->status = !empty($input['status']) ? $input['status'] : 0;
        if ($categories->save()) {
            $categories->slug_ro = $categories->id . '-' . str_slug($input['name_ro'], "-");
            $categories->slug_ru = $categories->id . '-' . str_slug($input['name_ru'], "-");
            $categories->save();
            Session::put('success', trans('admin.data_save'));
            return redirect()->route('categories');
        } else {
            return redirect()->route('categories')->withErrors(trans('admin.data_not_save'));
        }
    }
    public function deleteCategories(Request $request)
    {
        $input = $request->all();
        $categories = Categories::find($input['id']);

        if ($categories) {
            if (!empty($categories->image)) {
                if (file_exists(public_path() . '/images/categories/' . $categories->image)) {
                    unlink(public_path() . '/images/categories/' . $categories->image);
                }
                if (file_exists(public_path() . '/images/categories/thumb_' . $categories->image)) {
                    unlink(public_path() . '/images/categories/thumb_' . $categories->image);
                }
            }
            CaracteristicCategory::where('category_id', $categories->id)->delete();
            CategoryFilter::where('category_id',$categories->id)->delete();
            Product::where('category_id',$categories->id)->update(['status' => 0, 'category_id' => '0']);
            Categories::where('parent_id', $categories->id)->update(['status' => 0, 'parent_id' => '0']);
            $categories->delete();
        }
        Session::put('success', trans('admin.data_deleted'));
        return Redirect::back();
    }
}
