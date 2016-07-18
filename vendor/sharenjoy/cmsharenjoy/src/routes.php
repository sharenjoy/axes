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
Route::group(['middleware' => ['web']], function () use ($accessUrl) {
    
    // Backend
    Route::group(['prefix' => $accessUrl], function() {
        Route::controller('post'      , 'Sharenjoy\Cmsharenjoy\Modules\Post\PostController');
        Route::controller('tag'       , 'Sharenjoy\Cmsharenjoy\Modules\Tag\TagController');
        Route::controller('category'  , 'Sharenjoy\Cmsharenjoy\Modules\Category\CategoryController');
        Route::controller('filer'     , 'Sharenjoy\Cmsharenjoy\Filer\FilerController');
        Route::controller('user'      , 'Sharenjoy\Cmsharenjoy\User\UserController');
        Route::controller('setting'   , 'Sharenjoy\Cmsharenjoy\Setting\SettingController');
        Route::controller(''          , 'Sharenjoy\Cmsharenjoy\Http\Controllers\DashController');
    });

    Route::get($accessUrl.'/language/{lang}' , function ($lang) {
        if (array_key_exists($lang, config('cmsharenjoy.locales'))) {
            Session::put('sharenjoy.backEndLanguage', $lang);
            return redirect()->back();
        }
    });

});