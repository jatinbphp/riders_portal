<?php

namespace App\Livewire\ManageUploads;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Uploads;

class ManageUploadsForm extends Component
{
    use WithFileUploads;
    public $uplaodId;
    public $title, $file;
    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $allType;

    protected function rules()
    {
        return [
            'file' => 'required|file|max:10240', // 10MB max
            'title' => 'required',
        ];
    }

    public function render()
    {
        return view('livewire.manage-uploads.manage-uploads-form')->extends('layouts.app');
    }

    public function mount($id = null)
    {
        $this->menu = "Uploads";
        $this->breadcrumb = [
            ['route' => 'uploads', 'title' => 'Uploads'],
        ];
        $this->activeMenu = 'Add';
        $this->allType = Uploads::uploadType;
        if($id){
            $this->activeMenu = 'Edit';
            $club = Clubs::findOrFail($id);
            $this->clubId = $club->id;
            $this->name = $club->name;
            $this->description = $club->description;
            $this->status = $club->status;
        }
    }

    public function manageUploads()
    {
        $this->validate();
        $path = $this->file->store('uploads', 'public');

        $mimeType = $this->file->getMimeType();
        $type = str_starts_with($mimeType, 'image') ? Uploads::TYPE_IMAGE : Uploads::TYPE_VIDEO;
        Uploads::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'type' => $type,
            'path' => $path,
        ]);

        // Send success message
        session()->flash('message', 'File uploaded successfully!');

        $this->redirect(route('uploads'), navigate: true);
    }
}
