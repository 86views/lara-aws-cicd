<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Product Resource Routes
// Route::resource('products', ProductController::class)->except(['show']);
// Route::get('products/{product}', [ProductController::class, 'show']); // optional

Route::resource('products', ProductController::class);

// Rule Resource Routes
Route::resource('rules', RuleController::class)->except(['show']);
Route::post('rules/{rule}/apply', [RuleController::class, 'applyRule'])->name('rules.apply');