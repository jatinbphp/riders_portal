<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Athlete extends Component
{
    use WithPagination;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $name, $email, $status, $athlete_id;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $this->menu = "Athletes";
        $this->breadcrumb = [
            ['route' => route('dashboard'), 'title' => 'Dashboard'], // Ensure the route is correct
        ];
        $this->activeMenu = 'Athletes'; 
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->status = 1;
        $this->athlete_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'role' => 'athlete',
        ]);

        session()->flash('message', 'Athlete added successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $athlete = User::findOrFail($id);
        $this->athlete_id = $athlete->id;
        $this->name = $athlete->name;
        $this->email = $athlete->email;
        $this->status = $athlete->status;
        $this->isEditMode = true;
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

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->athlete_id,
        ]);

        $athlete = User::findOrFail($this->athlete_id);
        $athlete->update([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Athlete updated successfully.');
        $this->resetFields();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Athlete deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $athlete = User::findOrFail($id);
        $athlete->update(['status' => !$athlete->status]);

        session()->flash('message', 'Status updated successfully.');
    } 

    public function render()
    {
        $this->menu = "Athletes";
        
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];

        $this->activeMenu = 'Athletes';

        $athletes = User::where('role', 'athlete')->paginate(10);

        return view('livewire.athlete')->extends('layouts.app'); 
    } 

}
