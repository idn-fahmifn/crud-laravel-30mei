<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::paginate(10);
        return view('locations.index', [
            'location' => $locations
        ]);
    }
}
