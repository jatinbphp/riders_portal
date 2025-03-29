<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function mount(){
        $user = Auth::user();
        if ($user) {
            $user->save();        
        }
        
        Auth::logout();
        session()->flush();
        $this->redirect(route('login'));
    }
}
