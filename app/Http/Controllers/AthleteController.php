<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\User;

class AthleteController extends Controller
{
    public function show($id)
    {
        $athlete = User::findOrFail($id);

        if (!$athlete) {
            return response()->json(['error' => 'Athlete not found'], 404);
        }

        return response()->json($athlete);
    } 
}
