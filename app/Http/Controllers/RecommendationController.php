<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Models\Location;
use App\Models\User;

class RecommendationController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Recommendation::class);
    // }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
                'user_id' => 'required',
                'location_id' => 'required',
                'target_user' => 'required',
                'message' => 'string',
            ]);
            
        $request->user()->recommendations()->create($validated);

        return redirect('/locations')->with('success', 'Recommendation created');
    }

    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return redirect('/dashboard')->with('success', 'Recommendation deleted');
    }
}
