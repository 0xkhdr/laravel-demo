<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('welcome', [
            'portfolio' => config('portfolio'),
        ]);
    }
}
