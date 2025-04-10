<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\User;

class AthleteController extends Controller
{
    public function show($id)
    {
        $user = User::with('documentUploads')->find($id);

        if (!$user) {
            return response()->json(['error' => 'Athlete not found'], 404);
        }

        return response()->json([
            'firstname'      => $user->firstname,
            'lastname'       => $user->lastname,
            'email'          => $user->email,
            'nationality'          => $user->nationality,
            'dob'          => $user->dob,
            'biography'          => $user->biography,
            'height'         => $user->height,
            'weight'         => $user->weight,
            'sport_type'     => $user->sport_type,
            'specialization' => $user->specialization,

            // Related document upload field
            'speed' => optional($user->documentUploads)->speed,
            'strength' => optional($user->documentUploads)->strength,
            'agility' => optional($user->documentUploads)->agility,
            'endurance' => optional($user->documentUploads)->endurance,
            'flexibility' => optional($user->documentUploads)->flexibility, 
            'document_path' => optional($user->documentUploads)->document_path, 
        ]);
    }
 
}
