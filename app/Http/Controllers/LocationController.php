<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Location::class);
    }

    public function index()
    {
        $user = Auth::user();

        return Inertia::render('Locations', [
            'locations' => Location::where('user_id', $user->id)->get(),
            'users' => User::where('id', '!=', $user->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|nullable',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric'
        ]);

        $request->user()->locations()->create($validated);

        return redirect('/locations')->with('success', 'Location updated');
    }

    public function show(Location $location)
    {
        return Inertia::render('Location', [
            'location' => Location::find($location->id)
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $validated = $this->validate($request, [
            'title' => 'string|required',
            'description' => 'string|nullable',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric'
        ]);

        $location->update($validated);

        return redirect('/locations')->with('success', 'Location updated');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect('/locations')->with('success', 'Location deleted');
    }
}
