<?php

namespace App\Http\Controllers;
use App\Models\Caracteristic;
use App\Models\FilterProperties;
use App\Models\Units;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\ProductCaracteristic;
use App\Models\CaracteristicCategory;
use App\Models\ProductFilter;
use App\Models\Categories;
use App\Models\ProductImage;
use App\Models\CategoryFilter;
use App\Models\Product;
use App\Models\Filter;
use DB;
use Input;
use Image;
use Lang;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    static $data_lang = ['ru','ro'];
    static $level_category = 4;/* How many levels have the categories */
    public function ListProducts(){
        $products = Product::orderBy('id','desc')->paginate(20);
        return view('admin.products.ListProducts',compact('products','dellproducts'));
    }
    public function FormProduct($id = null){
        if (isset($id)) {
            $product = Product::find($id);
            $productImages = $product['images'] = ProductImage::where('product_id', $id)->get();
            $prod_caracteristic = ProductCaracteristic::where('product_id',$id)->get();
            $homeFilter = ProductFilter::where('product_id',$id)->where('home',1)->get();
            $home = [];

            foreach ($homeFilter as $item) {
                array_push($home,$item->filter_id);
            }
            $arr = [];
            foreach ($prod_caracteristic as $item) {
                array_push($arr,$item->caracteristic_id);
            }
        }
            $categories = Categories::where('parent_id', '0')->orderBy('sort_order')->orderBy('id', 'desc')->get();
            $level = self::$level_category;
            $obj = new CategoryController();
            $categories = $obj->LevelsCategory($categories,$level);
        return view('admin.products.FormProducts',compact('product','home','productImages','prod_caracteristic','caracteristic','arr','categories'));
    }

    public function addProduct(Request $request){
        $input = $request->all();
        $size = (int)($_SERVER['CONTENT_LENGTH'] / 1048576);
        if ($size >= 15){
            $messages = array( 'files' => trans('admin.big_post'));
            return redirect()->back()->withErrors($messages)->withInput();
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                if(File::size($file) >= 3145728){
                    $messages = array( 'files' => trans('admin.big_image') );
                    return redirect()->back()->withErrors($messages)->withInput();
                }
            }
        }

        if ( !isset( $input["id"] ) || empty($input["id"]) ){
            $rules= [
                'name_ru' => 'required',
                'name_ro' => 'required',
                'meta_name_ru'=>'required',
                'meta_name_ro'=>'required',
                'article'=>'required|unique:product,article',
                'price'=>'required',
                'id'=>'exists:product,id',
                'category_id'=>'required',
            ];
        }   else   {
            $identic = Product::find($input["id"]);
            if($identic->article == $input["article"])
            {
                $rules= [
                    'name_ru' => 'required',
                    'name_ro' => 'required',
                    'meta_name_ru'=>'required',
                    'meta_name_ro'=>'required',
                    'price'=>'required',
                    'id'=>'exists:product,id',
                    'category_id'=>'required',
                ];
            }  else   {
                $rules= [
                    'name_ru' => 'required',
                    'name_ro' => 'required',
                    'meta_name_ru'=>'required',
                    'meta_name_ro'=>'required',
                    'article'=>'required|unique:product,article',
                    'price'=>'required',
                    'id'=>'exists:product,id',
                    'category_id'=>'required',
                ];
            }
        }

        $validation = Validator::make($input, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if (!empty($input["id"])){
            $product = Product::find($input["id"]);
        } else{
            $product = new Product();
        }

        $langs = self::$data_lang;

        $fields = ['name_','meta_name_','description_','meta_description_'];
        foreach ($langs as $lang){
            foreach ($fields as $fill){
                $obj = $fill.$lang;
                $product->$obj  = $input[$obj];
            }
        }
        $product->price = $input['price'];
        $product->article = $input['article'];
        $product->status = $input['status'];
        $product->category_id = $input['category_id'];

        if (!empty($input['discount_price'])){
            $product->discount_price= $input['discount_price'];
        } else{
            $product->discount_price = null;
        }
        if ($product->save()){
            $default = 1;
            $product_id = $product->id;
            $product->slug_ro = $product_id . '-' . str_slug($input['name_ro'], "-");
            $product->slug_ru = $product_id . '-' . str_slug($input['name_ru'], "-");
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $f = new ProductImage();
                    $origName = $file->getClientOriginalExtension();
                    $og_name = $file->getClientOriginalName();
                    $nameImg = str_random(10) . '.' . $origName;
                    $image = \Image::make($file);
                    $path = public_path() . '/images/products/';
                    list($width, $height) = getimagesize($file);
                    if ($width > 900) {
                        $image->resize(900, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    if (isset($input['image_default']) && !empty($input['image_default'])) {
                        if ($og_name == $input['image_default']) {
                            $product->image = $nameImg;
                            ProductImage::where(['product_id' => $product_id, 'default' => 1])->update(['default' => 0]);
                            $f->default = 1;
                            $product->save();
                            $default = 0;
                        }
                    }

                    $image->save($path . $nameImg);
                    if ($width > 297) {
                        $image->resize(297, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    $image->save($path . 'thumb_' . $nameImg);
                    $f->image = $nameImg;
                    $f->product_id = $product_id;
                    $f->save();
                }
            }
            if (isset($input['img']) && !empty($input['img'])){
                $img = $pieces = explode(",", $input['img']);
                $del_img = ProductImage::whereIn('id',$img)->get();
                if (count($del_img)){
                    foreach ($del_img as $image) {
                        if ($image) {
                            if (file_exists(public_path() .'/assets/content/products/' . $image->image)) {
                                unlink(public_path() . '/assets/content/products/' . $image->image);
                            }

                            if (file_exists(public_path() .'/assets/content/products/thumb_' . $image->image)) {
                                unlink(public_path() . '/assets/content/products/thumb_' . $image->image);
                            }

                            $image->delete();
                        }
                    }
                }
            }
            if ($default) {
                if (isset($input['image_default']) && !empty($input['image_default'])) {
                    $resp = ProductImage::where(['product_id' => $product_id, 'image' => $input['image_default']])->update(['default' => 1]);
                    if ($resp) {
                        $product->image = $input['image_default'];
                        $product->save();
                        ProductImage::where(['product_id' => $product_id])->where('image', '!=', $input['image_default'])->update(['default' => 0]);
                    }
                }
            }
            /**Caracteristic**/
            ProductCaracteristic::where('product_id',$product->id)->delete();
            if( isset($input['value_ru']) ){
                $count = count($input['value_ru']);
                if ($count) {
                    foreach ($input['value_ru'] as $key => $car_val) {
                        if (isset($input['value_ru'][$key]) && !empty(trim($input['value_ru'][$key])) || isset($input['value_ro'][$key]) && !empty(trim($input['value_ro'][$key]))) {
                            $caracteriscti = new ProductCaracteristic();
                            $caracteriscti->caracterisitc_id = $key;
                            $caracteriscti->value_ru = $car_val;
                            $caracteriscti->value_ro = $input['value_ro'][$key];;
                            $caracteriscti->product_id = $product->id;

                            if (isset($input['unit_id'][$key])) {
                                $caracteriscti->unit_id = $input['unit_id'][$key];
                            } else {
                                $caracteriscti->unit_id = 0;
                            }

                            if (isset($input['check']) && count($input['check'])) {
                                if (in_array($key, $input['check'])) {
                                    $caracteriscti->home = 1;
                                }
                            }

                            $caracteriscti->save();
                        }
                    }
                }
            }
            /**Filter**/
            ProductFilter::where('product_id',$product->id)->delete();
            if (isset($input['filter'])){
                if (count($input['filter'])){
                    foreach ($input['filter']  as $key => $item){
                       foreach ($item as $item2){
                           $fil = new ProductFilter();
                           $fil->filter_id = $key;
                           $fil->type = 1;
                           $fil->value = $item2;
                           $fil->product_id =  $product->id;
                           if (isset($input['check_filter']) && count($input['check_filter'])){
                               if (in_array($key,$input['check_filter'])){
                                   $fil->home = 1;
                               }
                           }
                           $fil->save();
                       }

                    }
                }
            }
            if (isset($input['interval'])){
                if (count($input['interval'])){
                    foreach ($input['interval']  as $key => $item) {
                        if (!empty(trim($input['interval_val'][$key]))){
                                $fil = new ProductFilter();
                                $fil->filter_id = $key;
                                $fil->type = 2;
                                $fil->value = $item;
                                $fil->value2 = $input['interval_val'][$key];
                                $fil->product_id =  $product->id;
                                $fil->save();
                        }
                    }
                }
            }
            $product->save();
            Session::put('success',trans('admin.data_save'));
            return redirect()->route('admin_products');
        } else {
            return redirect('admin_products')->withInput()->withErrors($validation)->with('success', trans('admin.data_not_save'));
        }
    }
    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->get('id'));
        ProductCaracteristic::where('product_id',$request->get('id'))->delete();
        ProductFilter::where('product_id',$request->get('id'))->delete();
        $images = ProductImage::where('product_id',$request->get('id'))->get();
        foreach ($images as $image) {

            if ($image) {
                if (file_exists(public_path() .'/assets/content/products/' . $image->image)) {
                    unlink(public_path() . '/assets/content/products/' . $image->image);
                }

                if (file_exists(public_path() .'/assets/content/products/thumb_' . $image->image)) {
                    unlink(public_path() . '/assets/content/products/thumb_' . $image->image);
                }

                $image->delete();
            }
        }

        if (!empty($product->image)) {
            File::delete(public_path() . '/images/products/' . $product->image);
        }

        if (!empty($product->image)) {
            File::delete(public_path() . '/images/products/thumb_' . $product->image);
        }

        if ($product->delete()) {
            return Redirect::back()->with('success', trans('admin.data_deleted'));
        } else {
            return Redirect::back()->withErrors(trans('admin.data_not_delete'));

        }
    }
    public function deleteProductImage(Request $request)
    {
        $input = $request->all();
        $image = ProductImage::find($input['id']);
        if ($image) {

            if (file_exists(public_path() . '/images/products/' . $image->image)) {

                unlink(public_path() . '/images/products/' . $image->image);

            }

            if (file_exists(public_path() . '/images/products/thumb_' . $image->image)) {

                unlink(public_path() . '/images/products/thumb_' . $image->image);

            }

            $image->delete();

        }



        Session::put('success',trans('admin.data_deleted'));

        return Redirect::back();

    }
    public function ListCaracteristic()
    {
        $caracteristic = Caracteristic::orderBy('id', 'desc')->paginate(25);
        return view('admin.caracteristic.ListCaracteristic', compact('caracteristic'));
    }
    public function FormCaracteristic($id = null)
    {
        if ($id) {
            $caracteristic = Caracteristic::where('id', $id)->first();
            if ($caracteristic) {
                $caracteristic_category = CaracteristicCategory::where('caracterisitc_id', $caracteristic->id)->get();
                $category = [];
                foreach ($caracteristic_category as $item) {
                    array_push($category, $item->category_id);
                }
            }
        }

        $categories = Categories::where(['parent_id' => 0, 'status' => 1])->orderBy('sort_order')->get();
        foreach ($categories as $data) {
            $item = Categories::where(['parent_id' => $data->id, 'status' => 1])->orderBy('sort_order')->get();
            if (count($item)) {
                $data['level2'] = $item;
                foreach ($item as $data2) {
                    $item2 = Categories::where(['parent_id' => $data2->id, 'status' => 1])->orderBy('sort_order')->get();
                    if (count($item2)) {
                        $data2['level3'] = $item2;
                    }
                }
            }
        }
        return view('admin.caracteristic.FormCaracteristic', compact('caracteristic', 'categories', 'category'));
    }
    public function AddCaracteristic(Request $request)
    {
        $input = $request->all();
        $rules = ['name_ru' => 'required', 'name_ro' => 'required',];
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            if (isset($input['id'])) {
                $caracteristic = Caracteristic::find($input['id']);
                if (!$caracteristic) {
                    $caracteristic = new Caracteristic();
                }
            } else {
                $caracteristic = new Caracteristic();
            }
            $caracteristic->name_ru = $input['name_ru'];
            $caracteristic->name_ro = $input['name_ro'];
            if ($caracteristic->save()) {
                if (!empty($input['category'])) {
                    CaracteristicCategory::where('caracterisitc_id', $caracteristic->id)->delete();
                    $array_category = [];
                    $a = strip_tags($input['category']);
                    $array_category += explode(",", $a);
                    $array_category = array_filter($array_category);
                    foreach ($array_category as $item) {
                        $caracteristic_category = NEW CaracteristicCategory();
                        $caracteristic_category->category_id = $item;
                        $caracteristic_category->caracterisitc_id = $caracteristic->id;
                        $caracteristic_category->save();
                    }
                }
                Session::put('success', trans('admin.data_save'));
                return Redirect::route('admin_caracteristic');
            } else {
                return redirect()->back();
            }
        }
    }
    public function deleteCaracteristic(Request $request)
    {
        $input = $request->all();
        $caracteristic = Caracteristic::find($input['id']);
        if ($caracteristic) {
            ProductCaracteristic::where('caracterisitc_id', $caracteristic->id)->delete();
            CaracteristicCategory::where('caracterisitc_id', $caracteristic->id)->delete();
            $caracteristic->delete();
        }
        Session::put('success', trans('admin.data_deleted'));
        return Redirect::back();
    }
    public function ListFilter()
    {
        $filter = Filter::get();
        foreach ($filter as $data)
        {
            $item = FilterProperties::where(['filter_id' => $data->id])->orderBy('sort_order')->get();
            if (count($item)) {
                $data['prop'] = $item;
            }
        }
        return view('admin.filter.ListFilter',compact('filter'));
    }
    public function FormFilter($slug= null)
    {
        if($slug)
        {
            $filter = Filter::find($slug);
            $active = [];
            $ac = CategoryFilter::where('filter_id',$slug)->get();
            foreach ($ac as $item)
            {
                array_push($active,$item->category_id);
            }
        }

        $categories = Categories::where(['parent_id' => 0, 'status' => 1])->orderBy('sort_order')->get();
        foreach ($categories as $data) {
            $item = Categories::where(['parent_id' => $data->id, 'status' => 1])->orderBy('sort_order')->get();
            if (count($item)) {
                $data['level2'] = $item;
                foreach ($item as $data2) {
                    $item2 = Categories::where(['parent_id' => $data2->id, 'status' => 1])->orderBy('sort_order')->get();
                    if (count($item2)) {
                        $data2['level3'] = $item2;
                    }
                }
            }
        }

        return view('admin.filter.FormFilter',compact('filter','categories','active'));
    }
    public function AddFilter(Request $request)
    {
        $input = $request->all();

        $rules =
        [
            'name_ru'=> 'required|max:255|string',
            'name_ro'=> 'required|max:255|string',
            'iden'=> 'required',
            'filter_category'=>'required'
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            if (isset($input['id'])) {
                $filter = Filter::find($input['id']);
                if (!$filter) {
                    $filter = new Filter();
                }
            } else {
                $filter = new Filter();
            }
        }
            $filter->name_ru = $input['name_ru'];
            $filter->name_ro = $input['name_ro'];
            $filter->iden = $input['iden'];

            if (isset($input['type']))
            {
                $filter->type = $input['type'];
            }
            if (isset($input['units']))
            {
                $filter->units= $input['units'];
            }

            if (isset($input['sort_order']) && !empty($input['sort_order']))
            {
                $filter->sort_order = $input['sort_order'];
            }else
                {
                    $filter->sort_order = Filter::max('sort_order') + 1;
                }

            $filter->status = $input['status'];
            $filter->save();

        if (isset($input['filter_category']) && !empty($input['filter_category']))
        {
            foreach ($input['filter_category'] as $item)
            {
                $f = new CategoryFilter();
                $f->category_id = $item;
                $f->filter_id = $filter->id;
                $f->save();
            }
        }
        Session::put('success', trans('admin.data_save'));
        return Redirect::route('admin_filter');
    }
    public function FormFilterProp($slug = null)
    {
        return view('admin.filter.FormFilterPro',compact('slug'));
    }
    public function FormFilterPropEdit($slug = null)
    {
        $filter = FilterProperties::where('id',$slug)->first();
        return view('admin.filter.FormFilterPro',compact('filter','slug'));
    }
    public function FormFilterPropAdd(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name_ru' => 'required',
            'name_ro' => 'required',
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }
            $group = new FilterProperties();

            $group->name_ru = $input['name_ru'];
            $group->name_ro = $input['name_ro'];

            if (isset($input['sort_order']) && !empty($input['sort_order']))
            {
                $group->sort_order = $input['sort_order'];
            }else
            {
                $group->sort_order = FilterProperties::max('sort_order') + 1;
            }
            $group->status = $input['status'];
            $group->filter_id = $input['filter_id'];
            if ($group->save()) {
                Session::put('success', trans('admin.data_save'));
                return Redirect::route('admin_filter');
            } else {
                return redirect()->back();
            }

    }
    public function AddProp(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name_ru' => 'required',
            'name_ro' => 'required',
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {

                $group = FilterProperties::find($input['filter_id']);

            $group->name_ru = $input['name_ru'];
            $group->name_ro = $input['name_ro'];

            if (isset($input['sort_order']) && !empty($input['sort_order']))
            {
                $group->sort_order = $input['sort_order'];
            }else
            {
                $group->sort_order = FilterProperties::max('sort_order') + 1;
            }
            $group->status = $input['status'];
            if ($group->save()) {
                Session::put('success', trans('admin.data_save'));
                return Redirect::route('admin_filter');
            } else {
                return redirect()->back();
            }
        }
    }
    public function getCaracteristic(Request $request) {
        $input = $request->all();
        $rules =  [
            'category' => 'required|exists:category,id'
        ];
        $name = 'name_'.Lang::getLocale();
        $validation = Validator::make($input, $rules);
        if(!$validation->fails()) {
            $carecteristic = DB::table('caracteristic')
                ->join('caracteristic_category', 'caracteristic.id', '=', 'caracteristic_category.caracterisitc_id')
                ->where('caracteristic_category.category_id',$input['category'])
                ->orderBy('caracteristic.id','desc')
                ->get();
            if ($carecteristic){
                $html = "";
                foreach ($carecteristic as $item){
                    $html .= '<option value="'.$item->caracterisitc_id.'">'.$item->$name.'</option>';
                }
            } else {
                $html = trans('admin.no_caracteristic');
            }
            return $html;
        }
    }
    public function getFilter(Request $request)
    {
        $input = $request->all();
        $rules =
            [
                'category' => 'required|exists:category,id'
            ];
        $validation = Validator::make($input, $rules);
        if(!$validation->fails()) {

            $filters = DB::table('filter')
                ->join('category_filter', 'filter.id', '=', 'category_filter.filter_id')
                ->where('category_filter.category_id', $input['category'])
                ->orderBy('filter.id', 'desc')
                ->groupBy('filter.id')
                ->get();

            $array = [];
            $ff = "";
            $name = 'name_'.Lang::getLocale();
            foreach ($filters as $filter)
            {
                $prop = FilterProperties::where('filter_id',$filter->filter_id)->get();
                $ff .= "<div class='filter col-md-9'>";
                $ff .= "<h3>".$filter->$name."</h3>";
                $i = 0;
                foreach ($prop as $item){
                    if ($filter->type == 2){
                        $i++;
                        $cout = count($prop);
                        if ($i == 1)
                        {
                            $ff .= "<input type='radio' checked name='interval[".$filter->filter_id."]' value='0'>".trans('admin.no-select')."<br>";
                        }

                        $ff .= "<input type='radio' name='interval[".$filter->filter_id."]' value='".$item->id."'>".$item->$name."<br>";

                        if ($cout <= $i)
                        {
                            $ff .= "<input type='number' name='interval_val[".$filter->filter_id."]'><br>";
                        }
                    }
                        else
                    {
                            $ff .= "<input type='checkbox' name='filter[".$filter->filter_id."][]' value='".$item->id."'>".$item->$name."<br>";
                    }
                }
               $ff .= "</div>";
               $ff .= "<div class='filter col-md-3'>";
               $ff .= "<h4>".trans('admin.priority')."<h4>";
               $ff .= "<input name='check_filter[]' class='check' value='".$filter->filter_id."' type='checkbox'>";
               $ff .= "</div>";
            }
            $ff .= "</div><div class='clearfix'></div>";
            return $ff;

            if ($carecteristic){
                $units = Units::get();
                $unit = "<td style='max-width: 100px'>";
                $unit .= "<select class='form-control' name='unit[]' value='' style='margin: 0px 10px 0 10px'>";
                $unit .= "<option value='0'>-</option>";
                foreach ($units as $item) {
                    $unit .= "<option value='" . $item->id . "'>";
                    $unit .= $item->name_ru;
                    $unit .= "</option>";
                }
                $unit .= "</select>";
                $unit .= "</td>";
                $html = "";
                $html .= "<table class='table table-bordered table-hover'>";
                $html .= "<tr>";
                $html .= "<th>".trans('admin.name_caracteristic')."</th>";
                $html .= "<th>".trans('admin.value_caracteristic')."</th>";
                $html .= "<th>".trans('admin.unit_caracteristic')."</th>";

                $html .= "";

                $html .= "</tr>";

                foreach ($carecteristic as $item) {
                    $html .= "<tr>";
                    $html .= "<td style='max-width: 100px'>";
                    $html .= $item->name_ru;
                    $html .= "</td>";
                    $html .= "<td>";
                    $html .= "<input type='hidden' class='form-control' name='car_id[]' value='" . $item->id."'>";
                    $html .= "<div class='col-md-12'>";
                    $html .= "<div class='col-md-1'>";
                    $html .= "RO";
                    $html .= "</div>";
                    $html .= "<div class='col-md-11'>";
                    $html .= "<input type='text' class='form-control'  name='value_ro[]' style='margin-bottom:3px;'>";
                    $html .= "</div>";
                    $html .= "<div class='col-md-1'>";
                    $html .= "RU";
                    $html .= "</div>";
                    $html .= "<div class='col-md-11'>";
                    $html .= "<input type='text' class='form-control'  name='value_ru[]' style='margin-bottom:3px;'>";
                    $html .= "</div>";
                    $html .= "</div>";
                    $html .= "</td>";
                    $html .= $unit;
                    $html .= "</tr>";
                }
                $html .= "</table>";
                return $html;
            }

            else
            {
                $html = trans('admin.no_caracteristic');
                return $html;
            }
        }
    }
    public function ListUnits()
    {
        $units = Units::orderBy('id', 'desc')->paginate(25);
        return view('admin.units.ListUnits', compact('units'));
    }
    public function FormUnits($id = null)
    {
        if ($id) {
            $units = Units::where('id', $id)->first();
        }
        return view('admin.units.FormUnits', compact('units'));
    }
    public function AddUnits(Request $request)
    {
        $input = $request->all();
        $rules = ['name_ru' => 'required', 'name_ro' => 'required',];
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            if (isset($input['id'])) {
                $units = Units::find($input['id']);
                if (!$units) {
                    $units = new Units();
                }
            } else {
                $units = new Units();
            }
            $units->name_ru = $input['name_ru'];
            $units->name_ro = $input['name_ro'];
            if ($units->save()) {
                Session::put('success', trans('admin.data_save'));
                return Redirect::route('admin_units');
            } else {
                return redirect()->back();
            }
        }
    }
    public function deleteUnits(Request $request)
    {
        $input = $request->all();
        ProductCaracteristic::where('unit_id',$input['id'])->update(['unit_id' => 0]);
        Units::find($input['id'])->delete();
        Session::put('success', trans('admin.data_deleted'));
        return Redirect::back();
    }
    public function ListComment()
    {
        $comment = Comment::orderby('id','desc')->paginate(20);
        return view('admin.comment.ListComment',compact('comment'));
    }
    public function FormComment($slug = null)
    {
        if($slug)
        {
            $comment = Comment::where('id',$slug)->first();
        }else
            {
                return redirect()->back();
            }

        return view('admin.comment.FormComment',compact('comment'));
    }
    public function addComment(Request $request)
    {
        $input=$request->all();
        $rules =
            [
            'name'=>'required',
            'comment'=>'required',
        ];

        $valid = Validator::make($input,$rules);
        if ($valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $comment = Comment::find($input['id']);
        $comment->name = $input['name'];
        $comment->comment = $input['comment'];
        if(isset($input['note']))
        {
            $comment->note = $input['note'];
        }

        $comment->status = $input['status'];
        $comment->save();

        Session::put('success',trans('admin.data_save'));

        return redirect()->route('admin_comment');
    }
    public function deleteComment(Request $request)
    {
       Comment::find($request->get('id'))->delete();
            return Redirect::back()->with('success', trans('admin.data_deleted'));
    }
    public function getProductsFilter(Request $request){
        $input =  $request->all();
        $name = "name_".$input['lang'];
        $select = "SELECT * FROM product WHERE 1=1 ";
        if (isset($input['filter_model']) && !empty($input['filter_model'])){
            $select .= " AND article = '". $input['filter_model']."' ";
        }
        if (isset($input['filter_price_min']) && !empty($input['filter_price_min'])){
            $select .= " AND COALESCE( discount_price, price) >= ".$input['filter_price_min'];
        }
        if (isset($input['filter_price_max']) && !empty($input['filter_price_max'])){
            $select .= " AND COALESCE( discount_price, price) <= ".$input['filter_price_max'];
        }
        if(is_numeric($input['filter_status'])){
            $select .= " AND status = " . $input['filter_status'];
        }
        if (isset($input['filter_name']) && !empty($input['filter_name']) ){
            $select .= " AND " . $name . " LIKE '%".$input['filter_name']."%' ";
        }
        $select .=" ORDER BY id desc";
        $tot = DB::select($select);
        $data['total'] = count($tot);
        $per_page = 35;
        /**Paginator*/
        if (!empty($input['page'])) {
            $page = $input['page'];
            $active_page = $input['page'];
            $page--;
            if ($page) {
                $start =  $page * $per_page;
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
        /**Paginator*/
        $products = DB::select($select);
        $data['page'] = $page;
        $data['active'] = $active_page;
        $prod = "";
        foreach ($products as  $product){
            $prod .='<tr>';
            $id = $product->id;
            $prod .='<td>'.$product->$name.'</td>';
            if (file_exists(public_path() . '/images/products/thumb_' . $product->image))
           {
                $prod .='<td class="image_product"><img src=' . asset("images/products/thumb_$product->image").'></td>';
            }else
            {
                $prod .='<td class="image_product"><img src=' . asset("assets/nope.png").'></td>';
            }
            $prod .='<td>'.$product->article.'</td>';
            $prod .='<td>';
            if($product->discount_price)
            {
                $prod .='<span style="text-decoration: line-through;">'.$product->price." " . trans("admin.mdl").'</span><br>';
                $prod .=' <div class="text-danger">'.$product->discount_price." " .trans("admin.mdl").'</div>';
            }else
            {
                $prod .='<div>'.$product->price." " .trans("admin.mdl").'</div>';
            }
            $prod .='</td>';
            $prod .= '<td class="text-center">
                    <a href="'.asset('admin/product/edit/'.$product->id).'">
                    <div data-toggle="modal" data-target="#edit_'.$product->id.'" class="edit-pencil btn btn-primary btn-xs">
                         <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    </a>
                     <div data-toggle="modal" onclick="deleteProducts(\''.$product->id.'\',\''.$product->$name.'\')" class="delete-trash btn btn-danger btn-xs">
                          <span class="glyphicon glyphicon-trash"></span>
                     </div>
                    </td>';
            $prod .= '<td class="text-center">';
            if($product->status == 0){
                $prod .='<span class="status-no-active "></span>';
            }else{
                $prod .='<span class="status-active"></span>';
            }
            $prod .= '</td>';
            $prod .='</tr>';
        }
        $data['prod'] = $prod;
        return response()->json($data);
    }
    public  function deleteFilter(Request $request){
        $input = $request->all();
        if (isset($input['type']) && $input['type'])
        {
            if ($input['type'] == 1){
                $filter = Filter::find($input['id']);
                FilterProperties::where('filter_id',$filter->id)->delete();
                CategoryFilter::where('filter_id',$filter->id)->delete();
                ProductFilter::where('filter_id',$filter->id)->delete();
                $filter->delete();
            }elseif($input['type'] == 2){
                $filter = FilterProperties::find($input['id']);
                ProductFilter::where('value',$filter->id)->delete();
                $filter->delete();
            }
        }
        return Redirect::back()->with('success', trans('admin.data_deleted'));
    }
}
