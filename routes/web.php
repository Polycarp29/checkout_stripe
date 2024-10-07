<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductsController::class, 'index'])->name('index');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('/checkout', [ProductsController::class, 'checkout'])->name('checkout');
Route::post('/products/{id}/update', [ProductsController::class, 'updateProducts'])->name('products.update');
// Redirect to Success and Cancel Pages
Route::get('/success', [ProductsController::class, 'success'])->name('checkout.success');
Route::get('/cancel', [ProductsController::class, 'cancel'])->name('checkout.cancel');
Route::get('/error', function () {
    return view('errors.general'); // A view named 'general.blade.php' inside the 'errors' directory
})->name('errorPage');
Route::post('/webhook', [ProductsController::class, 'webhook'])->name('checkout.webhook');
