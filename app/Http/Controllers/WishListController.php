<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WishList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Cookie;
use Auth;
use DB;
class WishListController extends Controller{
    public function addToWishList(Request $request){
        $input = $request->all();
        if (!isset($input['prop'])){
            return false;
        }
        $rules = [
            'product_id' => 'required|numeric|exists:product,id,status,1',
        ];
        $valid = Validator::make(['product_id' => $input['prop'] ], $rules);
        if ($valid->fails()) {
           dd();
        }
            $cookie = $this->getCookie();

        if (isset($input['color'])){
            $color_id = $input['color'];
        }else{
            $color_id = 0;
        }

        if ($cookie){
            if (!$this->getIfProductInWish($input['prop'],$color_id)){
                $wish = new WishList();
                $wish->product_id = $input['prop'];
                $wish->string = $cookie;
                $wish->color_id = $color_id;
                if (Auth::guard('customer')->user()) {
                    $wish->user_id = Auth::guard('customer')->user()->id;
                } else {
                    $wish->user_id = 0;
                }
                $wish->save();
            }
        }else{
            $cookie = $this->setCookie();
            $wish = new WishList();
            $wish->product_id = $input['prop'];
            $wish->string = $cookie;
            $wish->color_id = $color_id;
            if (Auth::guard('customer')->user()){
                $wish->user_id = Auth::guard('customer')->user()->id;
            }else{
                $wish->user_id = 0;
            }
            $wish->save();
        }
        $data = [];
        $data['total'] = $this->getWishCount($cookie);
        return  json_encode($data);
    }
    public function setCookie(){
        $str_rand = str_random(30);
        Cookie::queue('wishlist', $str_rand, 40);
        return $str_rand;
    }
    public function getCookie(){
        return Cookie::get('wishlist');
    }
    public function getIfProductInWish($product_id,$color_id = 0){
        $string = $this->getCookie();
        if (Auth::guard('customer')->user()){
            return WishList::where('user_id',Auth::guard('customer')->user()->id)
                ->where('product_id', $product_id)
                ->where('color_id', $color_id)
                ->count();
        }
        return WishList::where('string', $string)->where('user_id',0)->
        where('product_id', $product_id)
        ->where('color_id', $color_id)
            ->count();
    }
    public function getWishCount($string = null){
        $cookie = $this->getCookie();
        if(Auth::guard('customer')->user()){
            return WishList::where('user_id',Auth::guard('customer')->user()->id)->count();
        }elseif($cookie){
            return WishList::where('string',$cookie)->where('user_id',0)->count();
        }else{
            return WishList::where('string',$string)->where('user_id',0)->count();
        }
    }
    public function LoginAddToWishList(){
        $string_code = $this->getCookie();
        $query = DB::table('wishlist')
            ->join('product', 'product.id', '=', 'wishlist.product_id')
            ->where('wishlist.string', $string_code)
            ->where('user_id',0)
            ->where('product.status', 1)
            ->select('product.id as id_product','product.*','wishlist.*')
            ->get();

        foreach($query as $item){
            if(!$this->getIfProductInWish($item->product_id,$item->color_id)){
                $obj=new WishList();
                $obj->user_id= Auth::guard('customer')->user()->id;
                $obj->product_id=$item->product_id;
                $obj->color_id=$item->color_id;
                $obj->string=$string_code;
                $obj->save();
            }
        }
    }
    public function getWishListProduct(){
        $string_code = $this->getCookie();
        if(Auth::guard('customer')->user()){
            $query = DB::table('wishlist')
                ->join('product', 'product.id', '=', 'wishlist.product_id')
                ->where('wishlist.user_id', Auth::guard('customer')->user()->id)
                ->where('product.status', 1)
                ->select('product.id as id_product','product.*','wishlist.*')
                ->orderBy('wishlist.id','desc')
                ->get();
        }elseif($string_code){
            $query = DB::table('wishlist')
                ->join('product', 'product.id', '=', 'wishlist.product_id')
                ->where('wishlist.string', $string_code)
                ->where('user_id',0)
                ->where('product.status', 1)
                ->select('product.id as id_product','product.*','wishlist.*')
                ->orderBy('wishlist.id','desc')
                ->get();
        }else{
           $query = [];
        }
        return $query;
    }
    public function RemoveToWishList(Request $request){
        $input = $request->all();
        $rules = [
            'product_id' => 'required|numeric|exists:wishlist,product_id',
        ];

        if ($input['color_id'])
        {
            $color_id = $input['color_id'];
        }else{
            $color_id = 0;
        }

        $valid = Validator::make(['product_id'=>$input['iden']],$rules);

        if ($valid->fails()){
            dd($valid->messages());
        }
        if (Auth::guard('customer')->user()){
            WishList::where('user_id',Auth::guard('customer')->user()->id)->where(['product_id'=>$input['iden'],'color_id'=>$color_id])->delete();
        }else{
            WishList::where('user_id',0)->where(['product_id'=>$input['iden'],'color_id'=>$color_id])->delete();
        }
        $data['total'] = $this->getWishCount();
        $data['success'] = 1;
        return json_encode($data);
    }
}
