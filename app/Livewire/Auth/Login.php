<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password;
    
    public function login() {
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('profile');
        } else {
            session()->flash('error', 'Invalid login credentials.');
        }
    }

    public function render() {
        return view('livewire.auth.login')->layout('layouts.app');
    }
}
