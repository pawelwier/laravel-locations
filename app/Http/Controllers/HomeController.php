<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return Inertia::render('Index', [
            'info' => 'hey hey info'
        ]);
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
}
