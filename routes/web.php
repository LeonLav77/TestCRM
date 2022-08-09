<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

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
// BASE ROUTES
Route::get('/', function () {
	return view('welcome');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// TEST ROUTES
Route::get('/teacher/test', function () {
	return auth()->user();
})->middleware('role:App\Models\Teacher');

Route::get('/student/test', function () {
	return auth()->user();
})->middleware('role:App\Models\Student');

Route::get('/admin/test', function () {
	return auth()->user();
})->middleware('role:App\Models\Admin');

// AUTH ROUTES
Auth::routes(['register' => false, 'logout' => false]);
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');


// PAGES ROUTES
Route::group(['middleware' => 'auth','prefix' => 'pages.'], function () {
		Route::get('icons', [PageController::class, 'icons'])->name('pages.icons');
		Route::get('maps', [PageController::class, 'maps'])->name('pages.maps');
		Route::get('notifications', [PageController::class, 'notifications'])->name('pages.notifications');
		Route::get('tables', [PageController::class, 'tables'])->name('pages.tables');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('users', 'App\Http\Controllers\UserController');
	Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});



