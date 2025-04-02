<?php 

namespace App\Livewire\Athlete;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AthleteForm extends Component
{
    public $athleteId, $name, $email, $status = 1;

    public function mount($id = null)
	{
	    if (!Gate::allows('manage-athletes')) {
	        abort(403, 'Unauthorized access.');
	    }

	    $this->menu = "Athletes";
	    $this->breadcrumb = [
	        ['route' => 'athletes.index', 'title' => 'Athletes'], // Updated breadcrumb for Athletes
	        ['route' => 'athletes.create', 'title' => 'Add Athlete'], // Adjusted for adding a new athlete
	    ];
	    $this->activeMenu = 'Add Athlete'; // Adjusted active menu label

	    if ($id) {
	        $athlete = User::findOrFail($id);
	        $this->athleteId = $athlete->id;
	        $this->name = $athlete->name;
	        $this->email = $athlete->email;
	        $this->status = $athlete->status;
	    }
	}


    public function save()
	{
	    $this->validate([
	        'name' => 'required|string|max:255',
	        'email' => 'required|email|unique:users,email',
	        'status' => 'required|in:active,inactive',
	    ]);

	    User::create([
	        'name' => $this->name,
	        'email' => $this->email,
	        'status' => $this->status,
	        'role' => 'athlete',
	    ]);

	    session()->flash('message', 'Athlete created successfully.');
	    return redirect()->route('athlete.index');
	}

    public function render()
    {
        return view('livewire.athlete.athlete-form')->extends('layouts.app');
    }

    public function getAthletesData(Request $request)
    {
        $query = User::where('role', 'athlete');

        return DataTables::of($query)
            ->addColumn('actions', function ($athlete) {
                return view('components.athlete-actions', compact('athlete'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
