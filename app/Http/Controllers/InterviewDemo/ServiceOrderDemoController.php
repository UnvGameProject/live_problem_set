<?php

namespace App\Http\Controllers\InterviewDemo;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ServiceOrderDemoController extends Controller
{
    /**
     * Display the interactive service order demo workspace.
     */
    public function show(): View
    {
        return view('interview-demo.show');
    }
}
