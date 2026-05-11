<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية: تحويل مباشر للوحة التحكم
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// مسارات محمية بالمصادقة
Route::middleware('auth')->group(function () {

    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // إدارة الملف الشخصي (من Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // إدارة السماسرة
    Route::resource('brokers', BrokerController::class);

    // إدارة الملاك
    Route::resource('owners', OwnerController::class);

    // إدارة العقارات
    Route::resource('properties', PropertyController::class);
});

// مسارات المصادقة (من Laravel Breeze)
require __DIR__.'/auth.php';
