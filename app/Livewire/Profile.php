<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Clubs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public $userId, $firstname, $lastname, $email, $password, $password_confirmation;
    public $sport_type, $specialization, $height, $weight, $about, $club_id, $image, $status;
    public $clubs;
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    public function mount()
    {       
        $this->menu = "Profile";
        $this->breadcrumb = [['route' => 'profile', 'title' => 'Profile']];
        $this->activeMenu = 'Edit';

        $this->clubs = Clubs::where('status', 1)->get(['id', 'name']);

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

        $this->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->userId, 
            'password' => 'nullable|min:6|confirmed', 
            'password_confirmation' => 'nullable|min:6',           
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'sport_type' => 'required|string', 
            'specialization' => 'nullable|string',
            // 'about' => 'nullable|string',
            'club_id' => 'nullable|exists:clubs,id',
            // 'image' => 'nullable|image|max:1024', // 1MB max
            'status' => 'boolean'
        ]);

        $profile = Auth::user();
        $profile->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,          
            'height' => $this->height,
            'weight' => $this->weight,
            'sport_type' => $this->sport_type,
            'specialization' => $this->specialization,
            // 'about' => $this->about,
            'club_id' => $this->club_id,
            'status' => $this->status ?? false, // Default to false if null
        ]);


        // Update password if provided
        if ($this->password) {
            $profile->update(['password' => Hash::make($this->password)]);
        }

        if ($this->image) {
            $path = $this->image->store('images', 'public');
            $profile->update(['image' => $path]);
        }

        session()->flash('success', 'Profile updated successfully!');

        $this->redirect(route('dashboard'), navigate: true);
    }
}
