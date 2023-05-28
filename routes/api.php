<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('healthy', [UserController::class, 'healthy']);
Route::get('show_contact', [ContactController::class, 'show_contact']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::prefix('dashboard')->group(function ()
        {
            Route::post('create_contact', [ContactController::class, 'create_contact']);
            Route::get('show_contact', [ContactController::class, 'show_contact']);
            Route::put('update_contact', [ContactController::class, 'update_contact']);
            Route::post('delete_contact', [ContactController::class, 'delete_contact']);
        }
    );
});
