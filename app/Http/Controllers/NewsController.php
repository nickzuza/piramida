<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\File;
use Validator;
use Input;
use Image;

class NewsController extends Controller
{
    static $data_lang = ['ru','ro'];
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ListNews()
    {
        $news = News::orderBy('id','desc')->paginate(15);
        return view('admin.news.ListNews', compact('news'));
    }

    public function FormNews($id = null)
    {
        if ($id) {
            $news = News::find($id);
        }
        return view('admin.news.FormNews', compact('news'));
    }

    function AddNews(Request $request)
    {
        $input = $request->all();
        $rules = ['name_ro' => 'required|max:255|string',
            'name_ru' => 'required|max:255|string',
            'meta_name_ro' => 'required|max:255|string',
            'meta_name_ru' => 'required|max:255|string',
            'meta_description_ro' => 'max:255|string',
            'meta_description_ru' => 'max:255|string',
            'mini_description_ro' => 'required|string|max:350',
            'mini_description_ru' => 'required|string|max:350',
            'description_ro' => 'string',
            'description_ru' => 'string',
            'id' => 'exists:news,id'];
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withInput()->withErrors($v);
        }
        if (isset($input['id'])) {
            $new = News::find($input['id']);
        } else {
            $new = new News();
        }
        $langs = self::$data_lang;
        $data = ['name_', 'meta_description_', 'description_', 'mini_description_', 'meta_name_'];
        foreach ($langs as $lang) {
            foreach ($data as $item) {
                $obj = $item . $lang;
                $new->$obj = $input[$obj];
            }
        }
        $new->status = $input['status'];
        if ($new->save()) {

            $new->slug_ro = str_slug($input['name_ro']) . '-' . $new->id;
            $new->slug_ru = str_slug($input['name_ru']) . '-' . $new->id;

            if ($request->hasFile('image')) {
                if (!empty($new->image)) {
                    File::delete(public_path() . '/images/news/' . $new->image);
                }
                $origName = $input['image']->getClientOriginalExtension();
                $nameImg = str_random(10) . '.' . $origName;
                $image = \Image::make(\Input::file('image'));
                $path = public_path() . '/images/news/';
                $image->fit(300, 200);
                $new->image = $nameImg;
                $image->save($path . $nameImg);
            }

            $new->save();
            return redirect()->route('admin_news')->with('success', trans('admin.data_added'));
        }
    }

    public function DeleteNews(Request $request)
    {
        $input = $request->all();
        $rules = ['id' => 'required|exists:news,id'];
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return back()->withErrors($v);
        }
        $new = News::find($input['id']);
        if (!empty($new->image)) {
            if (file_exists(public_path() . '/images/news/' . $new->image)) {
                unlink(public_path() . '/images/news/' . $new->image);
            }
        }
        if ($new->delete()) {
            return back()->with('success', trans('admin.data_deleted'));
        } else {
            return back()->withErrors($new->delete());
        }
    }
}