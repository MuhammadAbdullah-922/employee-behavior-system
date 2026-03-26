<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the welcome page or redirect logged-in users to dashboard.
     */
    public function index()
    {
        // If user is logged in, redirect to dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // Otherwise show welcome page
        return view('login');
    }
}