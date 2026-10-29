<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminDashboardController,
    AuthController,
    FilmController,
    KritikController,
};

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', fn () => redirect()->route('home')->with('auth_form', 'login'))->name('login.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/comments', [KritikController::class, 'store'])
    ->middleware('auth')
    ->name('kritik.store');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');
