<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as UserProductController;
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




// Admin Dashboard protegido
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('config', [ConfigController::class, 'index'])->name('config.index');
    Route::post('config', [ConfigController::class, 'save'])->name('config.save');

    // api
    Route::get('automotive-specifications/{product}', [AutomotiveSpecificationController::class, 'list'])->name('automotive-specifications.list');
    Route::post('automotive-specifications/toggle', [AutomotiveSpecificationController::class, 'toggle'])->name('automotive-specifications.toggle');

    Route::get('products/{product}/properties/{type}', [AdminProductController::class, 'listProperties']);
    Route::post('products/{product}/properties/{type}', [AdminProductController::class, 'storeProperty']);
    Route::delete('products/{product}/properties/{id}', [AdminProductController::class, 'deleteProperty']);

});


// public routes
Route::get('/products', [UserProductController::class, 'index']);

// rota para exibir a ficha técnica do produto
Route::get('/catalogo/produto/{id}', [PublicCatalogController::class, 'show'])->name('catalogo.produto'); 
// rota para gerar o PDF
Route::get('/catalogo/produto/{id}/pdf', [App\Http\Controllers\PublicCatalogController::class, 'generatePdf'])->name('catalogo.produto.pdf');


Route::get('/', function () {
    return view('welcome');
});

// logins
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
