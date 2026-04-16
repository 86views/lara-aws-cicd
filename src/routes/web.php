<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Product Resource Routes
// Route::resource('products', ProductController::class)->except(['show']);
// Route::get('products/{product}', [ProductController::class, 'show']); // optional


// ✅ Static routes FIRST
Route::get('products/import', [ProductController::class, 'showImportForm'])->name('products.import.form');
Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
Route::get('products/export/csv', [ProductController::class, 'exportCsv'])->name('products.export.csv');
Route::get('products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
Route::get('products/template', [ProductController::class, 'downloadTemplate'])->name('products.template');

// ✅ Resource route AFTER
Route::resource('products', ProductController::class);

Route::resource('rules', RuleController::class)->except(['show']);
Route::post('rules/{rule}/apply', [RuleController::class, 'applyRule'])->name('rules.apply');

  Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.dashboard');
   Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
   Route::get('/analytics-test', [AnalyticsController::class, 'test']);