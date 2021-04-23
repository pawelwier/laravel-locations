<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Recommendation;
use App\Models\User;
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
        $user = Auth::user();

        return Inertia::render('Dashboard', [
            'locations' => Location::where('user_id', $user->id)->get(),
            'allLocations' => Location::all(),
            'allUsers' => User::all(),
            'recommendedLocations' => Recommendation::where('target_user', $user->id)->get()
        ]);
    }
}
