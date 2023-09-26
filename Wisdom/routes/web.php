<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin-logout');
Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin-profile');
Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin-update-profile');

Route::controller(SliderController::class)->group(function(){
    Route::get('/slider/all', 'AllSlider')->name('all-slider');
    Route::get('/add/slider', 'AddSlider')->name('add-slider');
    Route::post('/store/slider', 'storeSlider')->name('store-slider');
});

Route::controller(CategoryController::class)->group(function(){
    // Route::get('/slider/all', 'AllSlider')->name('all-slider');
});


require __DIR__.'/auth.php';
