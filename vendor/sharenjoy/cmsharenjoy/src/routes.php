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
    Route::group(['prefix' => $accessUrl], function() use ($accessUrl) {

        // content language
        Route::get('specify-content-language/{lang}', function($lang) use ($accessUrl) {
            session()->put('cmsharenjoy.language', $lang);
            return redirect($accessUrl);
        });

        Route::controller('filer'     , 'Sharenjoy\Cmsharenjoy\Filer\FilerController');
        Route::controller('user'      , 'Sharenjoy\Cmsharenjoy\User\UserController');
        Route::controller('setting'   , 'Sharenjoy\Cmsharenjoy\Setting\SettingController');
        Route::controller(''          , 'Sharenjoy\Cmsharenjoy\Http\Controllers\DashController');
    });

    Route::get('language/{lang}' , function ($lang) {
        if (array_key_exists($lang, config('cmsharenjoy.locales'))) {
            session()->put('sharenjoy.backEndLanguage', $lang);
            return redirect()->back();
        }
    });

});