<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Response;

class LoginController extends Controller
{
    public function create(): Response
    {
        return inertia('Auth/Login');
    }
}
