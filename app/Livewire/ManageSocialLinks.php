<?php 

namespace App\Livewire;

use Livewire\Component;
use App\Models\SocialLinks;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables; 

class ManageSocialLinks extends Component
{
    public $menu;
    public $breadcrumb;
    public $activeMenu;
    public $facebook, $twitter, $instagram, $linkedin;

    public function mount()
    {
        $this->menu = "Social Links";
        $this->breadcrumb = [['route' => 'social-links', 'title' => 'Social Links']];
        $this->activeMenu = 'Social Links';

        $links = SocialLinks::where('user_id', Auth::id())->first();

        if ($links) {
            $this->facebook = $links->facebook;
            $this->twitter = $links->twitter;
            $this->instagram = $links->instagram;
            $this->linkedin = $links->linkedin;
        }
    }

    public function saveLinks()
    {
        $this->validate([
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        $links = SocialLinks::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'linkedin' => $this->linkedin,
            ]
        );

        session()->flash('success', 'Social media links updated successfully!');
    }

    public function getLinksData()
    {
        return DataTables::of(SocialLinks::where('user_id', Auth::id()))
            ->addColumn('actions', function ($row) {
                return view('livewire.manage-social-links.actions', ['links' => $row, 'type' => 'action']);
            })->addColumn('status', function ($row) {
                return view('livewire.manage-social-links.actions', ['links' => $row, 'type' => 'status']);
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function updateStatus($id)
    {
        $links = SocialLinks::where('id', $id)->where('user_id', Auth::id())->first();

        if ($links) {
            $links->status = !$links->status;
            $links->save();
        }
    }

    public function render()
    {
        return view('livewire.manage-social-links')->extends('layouts.app');
    }
}
