<?php 

namespace App\Livewire\Athlete;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AthleteForm extends Component
{
    public $athleteId, $firstname, $lastname, $email, $password, $password_confirmation, $status = '1';
    public $menu;
    public $breadcrumb;
    public $activeMenu;

    public function mount($id = null)
    {
        $user = Auth::user(); 

        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Unauthorized Access');
        } 
        
        $this->menu = "Athlete";
        $this->breadcrumb = [
            ['route' => 'athlete.create', 'title' => 'Athlete'],
        ];
        $this->activeMenu = 'Add';

        if ($id) {
            $this->activeMenu = 'Edit';
            $athlete = User::findOrFail($id);
            $this->athleteId = $athlete->id;
            $this->firstname = $athlete->firstname;
            $this->lastname = $athlete->lastname;
            $this->email = $athlete->email;
            $this->status = $athlete->status;
        }
    }

    public function save()
    {

    	$this->status = $this->status ? 1 : 0;

        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->athleteId,
            'password' => $this->athleteId ? 'nullable|min:6|confirmed' : 'required|min:6|confirmed',
            'status' => 'required|in:0,1',
        ]);

        $athlete = $this->athleteId ? User::findOrFail($this->athleteId) : new User();
        $athlete->firstname = $this->firstname;
        $athlete->lastname = $this->lastname;
        $athlete->email = $this->email;

        if ($this->password) {
            $athlete->password = Hash::make($this->password);
        } 
        $athlete->status = $this->status;
        $athlete->role = 'athlete'; // Ensure role is set correctly
        $athlete->save();

        session()->flash('success', $this->athleteId ? 'Athlete updated successfully' : 'Athlete added successfully');

        return redirect()->route('athlete');
    }

    public function render()
    {
        return view('livewire.manage-athletes.athlete-form')->extends('layouts.app');
    }

    public function getAthletesData(Request $request)
	{
	    // Debug: Check if users exist with the 'athlete' role
	    $athleteCount = User::where('role', 'athlete')->count();
	    if ($athleteCount == 0) {
	        return response()->json(['error' => 'No athletes found'], 404);
	    }

	    // Fetch only athletes
	    $query = User::where('role', 'athlete')->select(['id', 'firstname', 'lastname', 'email', 'status']);

	    return DataTables::of($query)
	        ->addColumn('actions', function ($athlete) { 
                return view('livewire.manage-athletes.actions', ['athlete' => $athlete, 'type' => 'action']);
	        })
	        ->addColumn('status', function ($athlete) { 
	            return view('livewire.manage-athletes.actions', ['athlete' => $athlete, 'type' => 'status']);
	        })
	        ->rawColumns(['status', 'actions'])
	        ->make(true); 
	} 

    public function toggleStatus($id)
	{
	    $athlete = User::findOrFail($id);
	    $athlete->status = !$athlete->status; // Toggle status using boolean
	    $athlete->save();

	    session()->flash('success', 'Status updated successfully.');

	    // Refresh the component after updating status
	    $this->dispatch('statusUpdated');
	}

}
