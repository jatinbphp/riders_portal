<?php

namespace App\Livewire\ManageSocialLinks;

use Livewire\Component;
use App\Models\SocialLinks;


class ManageSocialLinksForm extends Component
{
    public $linkId;
    public $facebook, $twitter, $instagram, $linkedin, $status;
    public $menu;
    public $breadcrumb;
    public $activeMenu; 

    public function render()
    {
        return view('livewire.manage-social-links.manage-social-links-form')->extends('layouts.app');
    }

    public function mount($id = null)
    {
        $this->menu = "Social Links";
        $this->breadcrumb = [
            ['route' => 'social-links', 'title' => 'Social Links'],
        ];
        $this->activeMenu = 'Add';
        $this->status = 1;
        if($id){
            $this->activeMenu = 'Edit';
            $link = SocialLinks::findOrFail($id);
            $this->linkId = $link->id;
            $this->facebook = $link->facebook;
            $this->twitter = $link->twitter;
            $this->instagram = $link->instagram;
            $this->linkedin = $link->linkedin;
            $this->status = $link->status;
        }
    }

    public function updateLinks()
    {
        $this->validate([
            'facebook' => 'required',
            'twitter' => 'required',
            'instagram' => 'required',
            'linkedin' => 'required',
        ]);

        $filedData = [
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'status' => $this->status,
        ];

        if($this->linkId){
            $link = SocialLinks::findOrFail($this->linkId);
            $link->update($filedData);
            session()->flash('success', 'Social Link updated successfully!');
        } else {
            SocialLinks::create($filedData);
            session()->flash('success', 'Social Link created successfully!');
        }

        $this->redirect(route('social-links'), navigate: true);
    }
}
