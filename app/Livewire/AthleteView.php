<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Athlete;
use App\Models\User;

class AthleteView extends Component
{
    public $athlete;

    protected $listeners = ['openAthleteModal' => 'loadAthlete'];

    public function loadAthlete($athleteId)
    {
        $this->athlete = User::find($athleteId);
    }

    public function render()
    {
        return view('livewire.athlete-view');
    }
}
