<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//})->where('vue_capture', '[\/\w\.-]*');

Route::get('{any?}', function () {
    return view('welcome');
})->where('any', '.*');
