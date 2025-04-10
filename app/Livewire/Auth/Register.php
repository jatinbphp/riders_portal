<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $firstname, $lastname, $email, $password, $password_confirmation;

    public function register()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'athlete',
            'status' => 1,
        ]);

        Auth::login($user);

        return redirect('/profile');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth');
    }
}
