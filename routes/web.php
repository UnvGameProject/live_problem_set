<?php

use App\Http\Controllers\InterviewDemo\PhpWorkspaceController;
use App\Http\Controllers\InterviewDemo\ServiceOrderDataController;
use App\Http\Controllers\InterviewDemo\ServiceOrderDemoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('landing');

Route::get('/service-order-demo', [ServiceOrderDemoController::class, 'show'])
    ->name('interview-demo.show');

Route::get('/php-workspace', [PhpWorkspaceController::class, 'show'])
    ->name('php-workspace.show');

Route::get('/api/interview-demo/service-orders', ServiceOrderDataController::class)
    ->name('interview-demo.service-orders.index');
