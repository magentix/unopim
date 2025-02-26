<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'v1/rest',
    'middleware' => ['auth:api', 'api.scope', 'accept.json', 'request.locale'],
], function () {
    require 'V1/api-routes.php';
});
