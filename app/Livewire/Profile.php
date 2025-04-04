<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Clubs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    public $user;
    public $userId, $firstname, $lastname, $email, $password, $password_confirmation;
    public $sport_type, $specialization, $height, $weight, $about, $club_id, $image, $status;
    public $clubs;
    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $userRole;

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
            // $this->about = $profile->about;
            $this->club_id = $profile->club_id;
            $this->status = $profile->status;
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

        // Conditional validation
        $rules = $this->userRole === 'athlete'
            ? array_merge($commonRules, $athleteExtraRules)
            : $commonRules;

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

        session()->flash('success', 'Profile updated successfully!');
        $this->redirect(route('dashboard'), navigate: true);
    }


    public function updateClub()
    {
        $this->club_id = (int) $this->club_id;
    }
}
