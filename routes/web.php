<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserLoginController;   
use App\Http\Controllers\TaskModulerController; 

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [UserLoginController::class, 'login']);
Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');



Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')

    ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('tasks', App\Http\Controllers\TaskModulerController::class);
Route::patch('tasks/{id}/status', [TaskModulerController::class, 'markAsCompleted'])->name('tasks.status'); 
