<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PokemonsController;
use App\Http\Controllers\AdminsPokemonsController;

// Login route
Route::get('login', function () {
    return view('login');
});

//guest routes
Route::post('login', [LoginController::class, 'login']);
Route::get('/', [PokemonsController::class, 'index'])->name('index');
Route::get('/pokemons/{id}', [PokemonsController::class, 'show'])->name('pokemons.show');

Route::get('/admin/insert', [AdminsPokemonsController::class, 'showInsertForm']); // To display the form
Route::post('/admin/insert', [AdminsPokemonsController::class, 'insertPokemon']); // To handle form submission

Route::get('/admins/insert', [AdminsPokemonsController::class, 'insert'])->name('admin.insert');
Route::post('/admin/insert', [AdminsPokemonsController::class, 'store'])->name('admin.store');

Route::get('/admins/edit/{id}', [AdminsPokemonsController::class, 'edit'])->name('admins.edit');
Route::post('/admin/update/{id}', [AdminsPokemonsController::class, 'update'])->name('admins.update');



// Admin routes
Route::prefix('admin')->group(function () {
    
    Route::get('index', [AdminsPokemonsController::class, 'index'])->name('admins.index');
    Route::get('insert', [AdminsPokemonsController::class, 'create'])->name('admins.create');
    Route::post('insert', [AdminsPokemonsController::class, 'store'])->name('admin.store');
    Route::get('edit/{id}', [AdminsPokemonsController::class, 'edit'])->name('admins.edit');
    Route::post('edit/{id}', [AdminsPokemonsController::class, 'update'])->name('admins.update');
    Route::get('delete/{id}', [AdminsPokemonsController::class, 'destroy'])->name('admins.destroy');
    Route::get('pokemon/{id}', [AdminsPokemonsController::class, 'show'])->name('admins.pokemon.show');
});

// Logout route
Route::get('logout', function () {
    Session::forget('user');
    return redirect('/');
});
