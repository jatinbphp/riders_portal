<?php
namespace App\Livewire\DocumentUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentUpload;  

class DocumentUploadsForm extends Component
{
    use WithFileUploads;

    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $speed;
    public $strength;
    public $agility;
    public $endurance;
    public $flexibility;
    public $document;

    protected $rules = [
        'speed' => 'required|numeric|min:1|max:100',
        'strength' => 'required|numeric|min:1|max:100',
        'agility' => 'required|numeric|min:1|max:100',
        'endurance' => 'required|numeric|min:1|max:100',
        'flexibility' => 'required|numeric|min:1|max:100',
        'document' => 'required|file|mimes:pdf,doc,docx,pptx,xlsx|max:10240', // 10MB max size
    ]; 

    public function render()
    {
        return view('livewire.document-uploads.document-uploads-form')->extends('layouts.app');
    }

     public function mount($id = null)
    {
        $this->menu = "Document Uploads";
        $this->breadcrumb = [
            ['route' => 'document-uploads.create', 'title' => 'Document Uploads'],
        ];
        $this->activeMenu = 'Add Data';
        $this->status = 1;

        if ($id) {
            $this->activeMenu = 'Edit';
            $document = DocumentUpload::findOrFail($id);
            $this->documentId = $document->id;
            $this->name = $document->name;
            $this->description = $document->description;
            $this->status = $document->status;
            $this->document_path = $document->document_path;
        }
    }
 
    public function submit()
    { 
        $this->validate();
 
        $documentPath = $this->document->store('documents', 'public');
 
        DocumentUpload::create([
            'speed' => $this->speed,
            'strength' => $this->strength,
            'agility' => $this->agility,
            'endurance' => $this->endurance,
            'flexibility' => $this->flexibility,
            'document_path' => $documentPath,
            'user_id' => auth()->id(),
        ]);
 
        session()->flash('message', 'Document uploaded successfully!');
 
        $this->reset(['speed', 'strength', 'agility', 'endurance', 'flexibility', 'document']);
    }
 
    
}
