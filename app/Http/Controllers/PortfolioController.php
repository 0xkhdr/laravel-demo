<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'name' => 'DEV.NAME',
            'title' => 'Software Engineer',
            'statement' => 'I build reliable systems and share what I learn.',
        ]);
    }
}
