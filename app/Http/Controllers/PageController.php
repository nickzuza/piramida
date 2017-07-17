<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use App\Models\Pages;
use App\Models\PageSection;
use App\Models\Section;
use DB;
use Input;
use Image;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    static $data_lang = ['ru','ro'];
    public function ListPages()
    {
        $pages = Pages::orderBy('id', 'desc')->get();
        return view('admin.pages.ListPages', compact('pages'));
    }
    public function FormPages($id = null)
    {
        if (isset($id)) {
            $pages = Pages::find($id);
            $sectionPages = DB::table('pages')->leftJoin('page_section', 'pages.id', '=', 'page_section.page_id')->where('pages.id', $id)->get();
            $section_page = [];
            $good = Product::where('discount_price','>=',1)->get();
            $is_good  =Product::where('good',1)->get();
            $is_active = [];
            if (count($is_good)){
                foreach ($is_good as $item){
                    array_push($is_active,$item->id);
                }
            }

            foreach ($sectionPages as $item) {
                array_push($section_page, $item->section_id);
            }
        } else {
            $section_page = [];
        }


        $section = Section::get();
        $count_pages = PageSection::where('section_id', 1)->count();
        $count_menu = PageSection::where('section_id', 4)->count();


        return view('admin.pages.FormPages', compact('pages', 'section', 'count_pages', 'section_page', 'count_menu','good','is_active'));
    }
    public function AddPages(Request $request)
    {
        $input = $request->all();
        $rules = ['name_ru' => 'required',
                  'name_ro' => 'required',
                  'meta_name_ru' => 'required',
                  'meta_name_ro' => 'required',
        ];
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } elseif (isset($input['id']) && !empty($input['id'])) {
            $pages = Pages::find($input['id']);
        } else {
            $pages = new Pages();
        }

        $pages->name_ru = isset($input['name_ru']) ? $input['name_ru'] : '';
        $pages->name_ro = isset($input['name_ro']) ? $input['name_ro'] : '';
        $pages->meta_name_ru = isset($input['meta_name_ru']) ? $input['meta_name_ru'] : '';
        $pages->meta_name_ro = isset($input['meta_name_ro']) ? $input['meta_name_ro'] : '';
        $pages->meta_description_ru = isset($input['meta_description_ru']) ? $input['meta_description_ru'] : '';
        $pages->meta_description_ro = isset($input['meta_description_ro']) ? $input['meta_description_ro'] : '';
        $pages->description_ru = isset($input['description_ru']) ? $input['description_ru'] : '';
        $pages->description_ro = isset($input['description_ro']) ? $input['description_ro'] : '';
         if (isset($input['good_price'])){
                Product::where('good',1)->update(['good'=>0]);
            foreach ($input['good_price'] as $item){
                Product::where('id',$item)->update(['good'=>1]);
            }
        }
        if (isset($input['sort_order']) && !empty(trim($input['sort_order'])))
        {
            $pages->sort_order = $input['sort_order'];
        }else
            {
                $pages->sort_order = Pages::max('sort_order')+1;
            }
        if (isset($input['status'])){$pages->status = $input['status'];} else { $pages->status = 1; }
        if ($pages->save()) {
            $pages_id = $pages->id;
            if ($pages->id != 23 && $pages->id != 20 && $pages->id != 22 && $pages->id != 24) {
                $pages->slug_ro = $pages_id . '-' . str_slug($input['name_ro'], "-");
                $pages->slug_ru = $pages_id . '-' . str_slug($input['name_ru'], "-");
            }
            PageSection::where('page_id', $pages->id)->delete();
            if (isset($input['show_in']) && count($input['show_in'])) {
                foreach ($input['show_in'] as $item) {
                    $section = new PageSection();
                    $section->page_id = $pages->id;
                    $section->section_id = $item;
                    $section->save();
                }
            }
            $pages->save();
        }
        if ($pages->save()) {
            Session::put('success', trans('admin.data_save'));
            return redirect('admin/pages');
        } else {
            return Redirect::back()->withErrors(trans('admin.data_not_save'));
        }
    }
    public function deletePages(Request $request)
    {
        $pages = Pages::find($request->get('id'));
        PageSection::where('page_id', $pages->id)->delete();
        if ($pages->delete()) {
            Session::put('success', trans('admin.data_deleted'));
            return redirect('admin/pages');
        } else {
            return redirect('admin/pages')->withErrors(trans('admin.data_not_delete'));
        }
    }
    public function SectionPage($id)

    {

        $PageSection = PageSection::where('page_id', $id)
            ->select('section_id')
            ->get();

        $PageSection->toArray();

        $section_id = [];


        foreach ($PageSection->toArray() as $item) {

            array_push($section_id, $item);

        }

        $section = Section::whereIn('id', $section_id)
            ->select('name_ru', 'name_ro')
            ->get();


        return $section->toArray();

    }
}
