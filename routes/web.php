<?php


Route::get('/intro',['as' => '/', 'uses' => function (){
    return view('intro');
}]);
Route::get('/filial',['as' => '/', 'uses' => function (){
    return view('filial');
}]);
Route::get('/',['as' => '/', 'uses' => function (){
    return view('home');
}]);
Route::get('/product',['as' => '/', 'uses' => function (){
    return view('product');
}]);
Route::get('/cart',['as' => '/', 'uses' => function (){
    return view('cart');
}]);
Route::get('/firstCat',['as' => '/', 'uses' => function (){
    return view('firstCat');
}]);
Route::get('/secondCat',['as' => '/', 'uses' => function (){
    return view('secondCat');
}]);
Route::get('/404',['as' => '/', 'uses' => function (){
    return view('not_found');
}]);
Route::get('/userCab',['as' => '/', 'uses' => function (){
    return view('userCab');
}]);
Route::get('/contacts',['as' => '/', 'uses' => function (){
    return view('contacts');
}]);
Route::get('/catalog',['as' => 'catalog', 'uses' => function (){
    return view('catalog');
}]);

Route::get('/contacts',['as' => 'contacts', 'uses' => function (){
    return view('contacts');
}]);

Route::get('/service',['as' => 'service', 'uses' => function (){
    return view('service');
}]);

Route::get('/page',['as' => 'page', 'uses' => function (){
    return view('page');
}]);

Route::get('/news',['as' => 'news', 'uses' => function (){
    return view('news');
}]);

Route::post('/search',['as' => 'search', 'uses' => 'ViewController@search']);


