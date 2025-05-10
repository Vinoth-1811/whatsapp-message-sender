<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('whatsapp', [WhatsAppController::class, 'index']);
Route::post('whatsapp', [WhatsAppController::class, 'store'])->name('whatsapp.post');
