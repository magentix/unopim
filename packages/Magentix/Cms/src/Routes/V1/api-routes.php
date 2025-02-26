<?php

use Illuminate\Support\Facades\Route;
use Magentix\Cms\Http\Controllers\API\Cms\PageController;

Route::group([
    'middleware' => ['auth:api'],
], function () {
    Route::controller(PageController::class)->prefix('pages')->group(function () {
        Route::get('', 'getList')->name('api.cms.pages.index');
        Route::get('{code}', 'get')->name('api.cms.pages.get');
        Route::post('', 'store')->name('api.cms.pages.store');
        Route::put('{code}', 'update')->name('api.cms.pages.update');
    });
});
