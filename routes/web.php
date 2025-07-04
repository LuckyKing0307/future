<?php

use App\Http\Controllers\BuyController;
use App\Http\Controllers\Pages\CompletedController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\RecieveController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('auth.login');
});

    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/recieve', [RecieveController::class, 'index'])->name('recieve');
    Route::get('/completed', [CompletedController::class, 'index'])->name('completed');
    Route::get('/me', [CompletedController::class, 'me'])->name('me');
    Route::post('/end', [CompletedController::class, 'end'])->name('end');
    Route::post('/task-take', [RecieveController::class, 'takeTask'])->name('take-task');

    Route::post('/withdrawal', [RecieveController::class, 'withdrawal'])->name('withdrawal.submit');

//    BUY
    Route::get('/tariffs', [BuyController::class, 'index'])->name('tariffs');
    Route::get('/tariff/{id}', [BuyController::class, 'show'])->name('tariff');
    Route::get('/buy/{asset}/{id}', [BuyController::class, 'buy'])->name('buy');

    Route::get('/withdrawal', [PagesController::class, 'withdrawal'])->name('withdrawal');
    Route::get('/invite', [PagesController::class, 'invite'])->name('invite');
    Route::get('/team', [PagesController::class, 'team'])->name('team');
    Route::get('/logout', [PagesController::class, 'logout'])->name('data.logout');

});
