<?php



Route::get('/',['as' => '/', 'uses' => function (){
    return view('home');
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


