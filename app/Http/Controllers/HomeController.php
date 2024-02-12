<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia('Home/Index', [
            'totalLinks' => fn () => $request->user()->links()->count(),
            'totalClicks' => fn () => $request->user()->clicks()->count(),
        ]);
    }
}
