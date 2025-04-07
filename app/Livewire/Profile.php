<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Clubs;
use App\Models\User;
use App\Models\DocumentUpload;

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public $userId, $firstname, $lastname, $email, $password, $password_confirmation;
    public $sport_type, $specialization, $height, $weight, $about, $club_id, $image, $status;
    public $speed, $strength, $agility, $endurance, $flexibility, $document_path;
    public $clubs, $menu, $breadcrumb, $activeMenu, $userRole;

    public function mount()
    {
        $this->menu = "Profile";
        $this->breadcrumb = [['route' => 'profile', 'title' => 'Profile']];
        $this->activeMenu = 'Edit';

        $this->clubs = Clubs::where('status', 1)->get(['id', 'name']);
        $this->userRole = Auth::user()?->role;

        $profile = Auth::user();

        if ($profile) {
            $this->userId = $profile->id;
            $this->firstname = $profile->firstname;
            $this->lastname = $profile->lastname;
            $this->email = $profile->email;
            $this->sport_type = $profile->sport_type;
            $this->specialization = $profile->specialization;
            $this->height = $profile->height;
            $this->weight = $profile->weight;
            $this->club_id = $profile->club_id;
            $this->status = $profile->status;

            // Load document data if exists
            $document = DocumentUpload::where('user_id', $profile->id)->first();
            if ($document) {
                $this->speed = $document->speed;
                $this->strength = $document->strength;
                $this->agility = $document->agility;
                $this->endurance = $document->endurance;
                $this->flexibility = $document->flexibility;
            }
        }
    }

    public function render()
    {
        $this->user = Auth::user();
        return view('livewire.profile')->extends('layouts.app');
    }

    public function updateProfile()
    {
        $commonRules = [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6',
        ];

        $athleteExtraRules = [
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'sport_type' => 'required|string',
            'specialization' => 'nullable|string',
            'club_id' => 'nullable|exists:clubs,id',
            'status' => 'boolean',
        ];

        $documentRules = [
            'speed' => 'required|integer|min:0|max:100',
            'strength' => 'required|integer|min:0|max:100',
            'agility' => 'required|integer|min:0|max:100',
            'endurance' => 'required|integer|min:0|max:100',
            'flexibility' => 'required|integer|min:0|max:100',
            'document_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ];

        $rules = array_merge(
            $this->userRole === 'athlete' ? array_merge($commonRules, $athleteExtraRules) : $commonRules,
            $documentRules
        );

        $this->validate($rules);

        $profile = Auth::user();
        $profile->firstname = $this->firstname;
        $profile->lastname = $this->lastname;
        $profile->email = $this->email;

        if ($this->userRole === 'athlete') {
            $profile->height = $this->height;
            $profile->weight = $this->weight;
            $profile->sport_type = $this->sport_type;
            $profile->specialization = $this->specialization;
            $profile->club_id = $this->club_id;
            $profile->status = $this->status ?? false;
        }

        if ($this->password) {
            $profile->password = Hash::make($this->password);
        }

        if ($this->image) {
            $path = $this->image->store('images', 'public');
            $profile->image = $path;
        }

        $profile->save();

        // Save or update document data
        $existing = DocumentUpload::where('user_id', $profile->id)->first();

        $data = [
            'speed' => $this->speed,
            'strength' => $this->strength,
            'agility' => $this->agility,
            'endurance' => $this->endurance,
            'flexibility' => $this->flexibility,
        ];

        if ($this->document_path) {
            $data['document_path'] = $this->document_path->store('documents', 'public');

            if ($existing && $existing->document_path) {
                Storage::disk('public')->delete($existing->document_path);
            }
        }

        if ($existing) {
            $existing->update($data);
        } else {
            $data['user_id'] = $profile->id;
            DocumentUpload::create($data);
        }

        session()->flash('success', 'Profile and documents updated successfully!');
        $this->redirect(route('profile'), navigate: true);
    }

    public function updateClub()
    {
        $this->club_id = (int) $this->club_id;
    }
}
