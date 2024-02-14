<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Inertia\Response;

class LoginController extends Controller
{
    public function create(): Response
    {
        return inertia('Auth/Login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        return to_route('home');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();

        return to_route('login');
    }
}
