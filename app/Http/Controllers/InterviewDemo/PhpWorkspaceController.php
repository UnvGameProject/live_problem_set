<?php

namespace App\Http\Controllers\InterviewDemo;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PhpWorkspaceController extends Controller
{
    /**
     * Display the PHP-only interview workspace.
     */
    public function show(): View
    {
        return view('php-workspace.show');
    }
}
