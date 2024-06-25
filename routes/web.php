<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('users');
});

Route::resource('users',UserController::class);
Route::resource('group',GroupController::class);

Route::post('get-states', [Controller::class,'getStates']);
Route::post('get-cities', [Controller::class,'getCities']);
