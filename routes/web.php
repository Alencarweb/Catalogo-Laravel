<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AutomotiveSpecificationController;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\Admin\ConfigController;

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




// middleware group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('config', [ConfigController::class, 'index'])->name('config.index');
    Route::post('config', [ConfigController::class, 'save'])->name('config.save');
    Route::put('/products/{product}/properties/{property}', [\App\Http\Controllers\Admin\ProductController::class, 'updateProperty'])->name('admin.products.properties.update');

    // api
    Route::get('automotive-specifications/{product}', [AutomotiveSpecificationController::class, 'list'])->name('automotive-specifications.list');
    Route::post('automotive-specifications/toggle', [AutomotiveSpecificationController::class, 'toggle'])->name('automotive-specifications.toggle');

    Route::get('products/{product}/properties/{type}', [AdminProductController::class, 'listProperties']);
    Route::post('products/{product}/properties/{type}', [AdminProductController::class, 'storeProperty']);
    Route::delete('products/{product}/properties/{id}', [AdminProductController::class, 'deleteProperty']);


    Route::delete('products/delete-pdf/{product}', [AdminProductController::class, 'deletePdf'])
    ->name('products.deletePdf');

    Route::delete('products/{id}', [AdminProductController::class, 'apiDestroy']);
    Route::get('api/products', function () {
        return \App\Models\Product::all();
    });
});


Route::get('/catalogo/layout/{id}', [PublicCatalogController::class, 'show_layout'])->name('catalogo.produto'); 
Route::get('api/', [PublicCatalogController::class, 'index'])->name('catalogo.produto'); 


// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
