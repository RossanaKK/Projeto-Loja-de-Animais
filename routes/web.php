<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $destaques = Product::inRandomOrder()->take(3)->get();
    return view('welcome', compact('destaques'));
})->name('home');

Route::view('/contacto', 'contact')->name('contact');

Route::post('/contacto', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    return back()->with('success', 'Mensagem enviada com sucesso! Entraremos em contacto em breve.');
})->name('contact.send');

Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/create', [ProductController::class, 'create'])->middleware('auth')->name('products.create');
Route::get('/produtos/edit/{product}', [ProductController::class, 'edit'])->middleware('auth')->name('products.edit');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/produtos/store', [ProductController::class, 'store'])->middleware('auth')->name('products.store');
Route::put('/produtos/update/{product}', [ProductController::class, 'update'])->middleware('auth')->name('products.update');
Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->middleware('auth')->name('products.destroy');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categorias/create', [CategoryController::class, 'create'])->middleware('auth')->name('categories.create');
Route::get('/categorias/edit/{category}', [CategoryController::class, 'edit'])->middleware('auth')->name('categories.edit');
Route::get('/categorias/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/categorias/store', [CategoryController::class, 'store'])->middleware('auth')->name('categories.store');
Route::put('/categorias/update/{category}', [CategoryController::class, 'update'])->middleware('auth')->name('categories.update');
Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->middleware('auth')->name('categories.destroy');
Route::get('/categorias/{id}/produtos', [ProductController::class, 'indexByCategory'])->name('categories.products');

Route::middleware('auth')->group(function () {
    Route::resource('pets', PetController::class);
    Route::resource('orders', OrderController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
