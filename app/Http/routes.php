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

Route::get('/', function () {
    return view('welcome');
});

/**
 * For the backend
 */
Route::group(['prefix' => 'admin'], function()
{
    Route::controller('post'      , 'App\Modules\Post\PostController');
    Route::controller('tag'       , 'App\Modules\Tag\TagController');
    Route::controller('category'  , 'App\Modules\Category\CategoryController');
    Route::controller('carousel'  , 'App\Modules\Carousel\CarouselController');
});
