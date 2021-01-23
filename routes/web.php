<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/chatroom', function () {
    return Inertia\Inertia::render('chatroom');
})->name('chatroom');

Route::get('/userlist',[MessageController::class,'index']);

Route::get('/usermessage/{id}',[MessageController::class,'user_message']);

Route::post('/sendmessage',[MessageController::class,'send_message']);

Route::get('/deletesinglemessage/{id}',[MessageController::class,'delete_single_message']);

Route::get('/deleteallmessage/{id}',[MessageController::class,'delete_all_message']);


