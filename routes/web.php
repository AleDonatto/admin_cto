<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/*Route::get('/storage', function (){
    Artisan::call('storage::link');
});*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/categorias', [
    AdminController::class, 'viewCategorias'
])->name('categorias');

Route::middleware(['auth:sanctum', 'verified'])->get('/productos', [
    AdminController::class, 'viewProductos'
])->name('productos');

Route::middleware(['auth:sanctum', 'verified'])->post('/storeCategorias', [AdminController::class, 'StoreCategorias']);

Route::middleware(['auth:sanctum', 'verified'])->post('/storeProductos', [AdminController::class, 'StoreProductos']);

Route::middleware(['auth:sanctum', 'verified'])->post('/updateCategorias', [AdminController::class, 'updateCategorias']);

Route::middleware(['auth:sanctum', 'verified'])->post('/updateProductos', [AdminController::class, 'updateProductos']);

Route::middleware(['auth:sanctum', 'verified'])->delete('/deleteCategorias/{categorias}', [AdminController::class, 'deleteCategorias']);

Route::middleware(['auth:sanctum', 'verified'])->delete('/deleteProductos/{productos}', [AdminController::class, 'deleteProducto']);

Route::middleware(['auth:sanctum', 'verified'])->get('/pedidos', [
    AdminController::class, 'viewPedidos'
])->name('pedidos');

Route::middleware(['auth:sanctum', 'verified'])->get('/getCompraCliente/{idCompra}', [
    AdminController::class, 'getListaPedidoCliente'
]);

