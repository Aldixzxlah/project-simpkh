<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForestController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    $totalForestArea = \App\Models\DataHutan::sum('luas_hektar');
    return view('welcome', compact('totalForestArea'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('forests', ForestController::class);
        Route::resource('reports', AdminReportController::class)->only(['index', 'show', 'update']);
    });

    // User Routes
    Route::resource('reports', ReportController::class);
    Route::put('password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
