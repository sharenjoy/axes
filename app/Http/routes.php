<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',             'App\Http\Controllers\HomeController@index');
Route::get('/about',        'App\Http\Controllers\HomeController@about');
Route::get('/news',         'App\Http\Controllers\HomeController@news');
Route::get('/news/{id}',    'App\Http\Controllers\HomeController@newsDetail');
Route::get('/product',      'App\Http\Controllers\HomeController@product');
Route::get('/product/{id}', 'App\Http\Controllers\HomeController@productDetail');
Route::get('/wheretobuy',   'App\Http\Controllers\HomeController@whereToBuy');
Route::post('/contactus',   'App\Http\Controllers\HomeController@contactUs');
Route::post('/search',      'App\Http\Controllers\HomeController@search');
Route::get('/downloadfile/{filename}', 'App\Http\Controllers\HomeController@downloadFile');

/**
 * For the backend
 */
Route::group(['prefix' => 'admin'], function()
{
    Route::controller('post'      , 'App\Modules\Post\PostController');
    Route::controller('tag'       , 'App\Modules\Tag\TagController');
    Route::controller('category'  , 'App\Modules\Category\CategoryController');
    Route::controller('carousel'  , 'App\Modules\Carousel\CarouselController');
    Route::controller('product'   , 'App\Modules\Product\ProductController');
});
