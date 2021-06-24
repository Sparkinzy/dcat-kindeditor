<?php

use Sparkinzy\Dcat\Kindeditor\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

Route::group([
    'prefix'     => 'sparkinzy',
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->any('kindeditor/upload',
        Controllers\FileController::class . '@handle')
        ->name('sparkinzy.kindeditor.upload');
});


