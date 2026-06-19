<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketsController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// --- Authenticated only ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::patch('tickets/{tickets}/resolve', [TicketsController::class, 'resolve'])->name('tickets.resolve');
    Route::resource('tickets', TicketsController::class)->parameters(['tickets' => 'tickets']);
});

// --- jQuery + Laravel sanity-check demo ---
Route::get('/demo', function () {
    return view('demo');
});

// JSON endpoint hit via jQuery $.ajax
Route::post('/api/ping', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'message' => 'pong from Laravel',
        'you_sent' => $request->input('name', 'nobody'),
        'time' => now()->toDateTimeString(),
    ]);
});
