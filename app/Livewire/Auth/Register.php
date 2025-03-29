<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    use WithFileUploads;

    public $name, $email, $password, $password_confirmation, $sport, $profile_photo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:athletes,email',
        'password' => 'required|min:6|confirmed',
        // 'sport' => 'nullable|string',
        // 'profile_photo' => 'nullable|image|max:2048'
    ];

    public function register() {
        $this->validate();

        $photoPath = $this->profile_photo ? $this->profile_photo->store('profiles', 'public') : null;

        $athlete = Athlete::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            // 'sport' => $this->sport,
            // 'profile_photo' => $photoPath,
        ]);

        Auth::login($athlete);

        return redirect()->route('profile');
    }

    public function render() {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}
