<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/guest-book', [GuestBookController::class, 'index'])->name('api.guest_book.retrieve');
Route::post('/guest-book', [GuestBookController::class, 'store'])->name('api.guest_book.store');
Route::get('/guest-book/{id}', [GuestBookController::class, 'show'])->name('api.guest_book.show');
Route::put('/guest-book/{id}', [GuestBookController::class, 'update'])->name('api.guest_book.update');
Route::delete('/guest-book/{id}', [GuestBookController::class, 'destroy'])->name('api.guest_book.destroy');
