<?php

use Illuminate\Support\Facades\Route;
use Magentix\Cms\Http\Controllers\PageController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

    Route::controller(PageController::class)->prefix('pages')->group(function () {
        Route::get('', 'index')->name('admin.cms.pages.index');

        Route::get('create', 'create')->name('admin.cms.pages.create');

        Route::post('create', 'store')->name('admin.cms.pages.store');

        Route::get('edit/{id}', 'edit')->name('admin.cms.pages.edit');

        Route::put('edit/{id}', 'update')->name('admin.cms.pages.update');

        Route::delete('edit/{id}', 'destroy')->name('admin.cms.pages.delete');
    });

});
