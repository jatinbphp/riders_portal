<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentUpload;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DocumentUploads extends Component
{
    use WithFileUploads;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $speed = 0;
    public $strength = 0;
    public $agility = 0;
    public $endurance = 0;
    public $flexibility = 0;
    public $document;
    public $existingStats;

    protected $listeners = ['deleteDocument'];

    public function mount()
    {
        $this->existingStats = DocumentUpload::where('user_id', Auth::id())->first();

        if ($this->existingStats) {
            $this->speed = $this->existingStats->speed;
            $this->strength = $this->existingStats->strength;
            $this->agility = $this->existingStats->agility;
            $this->endurance = $this->existingStats->endurance;
            $this->flexibility = $this->existingStats->flexibility;
        }
    }

    public function submit()
    {
        $this->validate([
            'speed' => 'required|integer|min:0|max:100',
            'strength' => 'required|integer|min:0|max:100',
            'agility' => 'required|integer|min:0|max:100',
            'endurance' => 'required|integer|min:0|max:100',
            'flexibility' => 'required|integer|min:0|max:100',
        ]);

        DocumentUpload::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'speed' => $this->speed,
                'strength' => $this->strength,
                'agility' => $this->agility,
                'endurance' => $this->endurance,
                'flexibility' => $this->flexibility,
            ]
        );

        session()->flash('success', 'Profile stats saved successfully!');

        return redirect()->route('document-uploads'); // 👈
    }  
 

public function getDocumentsData()
{
    $user = Auth::user();
    $isSuperAdmin = $user->role === 'super_admin';

    $query = DocumentUpload::select();

    $dataTable = DataTables::of($query)
        ->addColumn('document_path', function ($row) {
            if (!empty($row->document_path)) {
                $url = asset('storage/' . $row->document_path);
                return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa fa-download"></i>
                        </a>';
            }
            return 'No File';
        });

    // Only add the 'actions' column if NOT super_admin
    if (!$isSuperAdmin) {
        $dataTable->addColumn('actions', function ($row) {
            return view('livewire.document-uploads.actions', [
                'document' => $row,
                'type' => 'action',
            ]);
        });
    }

    return $dataTable
        ->rawColumns(['document_path', 'actions']) // Safe to include 'actions' even if not added
        ->make(true);
}




    public function deleteDocument($documentId)
    {
        $document = DocumentUpload::find($documentId);
        
        if ($document) {
            $document->delete();
            $this->dispatch('documentDeleted');
        }
    }

    public function uploadDocument()
    {
        $this->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $this->document->store('documents');

        DocumentUpload::updateOrCreate(
            ['user_id' => Auth::id()],
            ['document_path' => $path]
        );

        session()->flash('success', 'Document uploaded successfully!');
    } 

    public function render()
    {
        $this->menu = "Documents Uploads";
        $this->breadcrumb = [
            ['route' => 'dashboard', 'title' => 'Dashboard'],
        ];
        $this->activeMenu = 'Documents Uploads';
        return view('livewire.document-uploads')->extends('layouts.app');
    }

}
