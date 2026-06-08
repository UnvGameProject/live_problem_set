<?php

use App\Http\Controllers\InterviewDemo\ServiceOrderDemoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('landing');

Route::get('/service-order-demo', [ServiceOrderDemoController::class, 'show'])
    ->name('interview-demo.show');
