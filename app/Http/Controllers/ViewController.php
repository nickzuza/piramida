<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function categoryProducts(Request $request){
        $page = $request->input('page');
        $resp = [
            'products'=>[
                [
                    'img'=>'http://www.mebel-zvezda.ru/wp-content/uploads/2014/12/kuhni1-600x375.jpg',
                    'url'=>'#',
                    'title'=>'Баланс Смарт'
                ],
                [
                    'img'=>'http://altair-dv.com/wp-content/uploads/2014/12/89162.jpeg',
                    'url'=>'#',
                    'title'=>'Стол Альмера'
                ],
                [
                    'img'=>'http://www.domechti.ru/wp-content/uploads/2016/03/mebel-na-zakaz-plyusy-i-minusy-01.jpg',
                    'url'=>'#',
                    'title'=>'Стул не понятно как сюда попавший'
                ],
                [
                    'img'=>'http://www.mebellux.kz/wp-content/uploads/2015/06/001.jpg',
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое'
                ],
                [
                    'img'=>'http://altair-dv.com/wp-content/uploads/2014/12/89162.jpeg',
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое!'
                ]
            ],
            'page'=>'2',
            'currentPage'=>$page,
            'lastPage'=>'4'
        ];
        return $resp;
    }
    public function categoryListProducts(Request $request){
        $page = $request->input('page');
        $resp = [
            'products'=>[
                [
                    'img'=>'http://www.mebel-zvezda.ru/wp-content/uploads/2014/12/kuhni1-600x375.jpg',
                    'url'=>'#',
                    'title'=>'Баланс Смарт'
                ],
                [
                    'img'=>'http://altair-dv.com/wp-content/uploads/2014/12/89162.jpeg',
                    'url'=>'#',
                    'title'=>'Стол Альмера'
                ],
                [
                    'img'=>'http://www.domechti.ru/wp-content/uploads/2016/03/mebel-na-zakaz-plyusy-i-minusy-01.jpg',
                    'url'=>'#',
                    'title'=>'Стул не понятно как сюда попавший'
                ],
                [
                    'img'=>'http://www.mebellux.kz/wp-content/uploads/2015/06/001.jpg',
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое'
                ],
                [
                    'img'=>'http://altair-dv.com/wp-content/uploads/2014/12/89162.jpeg',
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое!'
                ]
            ],
            'page'=>'2',
            'currentPage'=>$page,
            'lastPage'=>'4'
        ];
        return $resp;
    }
    public function search(Request $request){
        $page = $request->input('page');
        $resp = [
            'resp'=>[
                [
                    'url'=>'#',
                    'title'=>'Баланс Смарт'
                ],
                [
                    'url'=>'#',
                    'title'=>'Стол Альмера'
                ],
                [
                    'url'=>'#',
                    'title'=>'Стул не понятно как сюда попавший'
                ],
                [
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое'
                ],
                [
                    'url'=>'#',
                    'title'=>'И еще что-то такое этакое!'
                ]
            ]
        ];
        return $resp;
    }
}
