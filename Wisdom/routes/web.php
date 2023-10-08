<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\ProductController;
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
    Route::get('/edit/slider/{id}', 'EditSlider')->name('edit-slider');
    Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
    Route::get('/update/slider/{id}', 'DeleteSlider')->name('delete-slider');
});

Route::controller(CategoryController::class)->group(function(){
     Route::get('/cageogory/all', 'AllCategory')->name('all-category');
     Route::get('/cageogory/add', 'AddCategory')->name('add.category');
     Route::post('/cageogory/store', 'StoreCategory')->name('store.category');
     Route::get('/cageogory/store/{id}', 'EditCategory')->name('edit-category');
     Route::post('/cageogory/update', 'UpdateCategory')->name('update.category');
     Route::get('/cageogory/delete/{id}', 'DeleteCategory')->name('delete-category');
});

Route::controller(SubcategoryController::class)->group(function(){
    Route::get('/subcategory/all', 'AllSubcategory')->name('all-subcategory');
    Route::get('/subcategory/add', 'AddSubcategory')->name('add-subcategories');
    Route::post('/subcategory/store', 'StoreSubcategory')->name('store.subcategory');
    Route::get('/subcategory/edit/{id}', 'EditSubcategory')->name('edit.subcategory');
    Route::post('/subcategory/update', 'UpdateSubcategory')->name('update.subcategory');
    Route::get('/subcategory/delete/{id}', 'DeleteSubcategory')->name('delete.subcategory');
});

Route::controller(ProductController::class)->group(function(){
    // Route::get('/subcategory/all', 'AllSubcategory')->name('all-subcategory');
});

require __DIR__.'/auth.php';
