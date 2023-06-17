<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;

class Avatar extends Component
{
    use WithFileUploads;

    public $avatar;
    public bool $isEditing;
    public bool $saved = false;

    protected $rules = [
        'avatar' => 'image|max:500',
    ];

    public function mount(): void
    {
        $this->avatar = auth()->user()
            ->getFirstMediaUrl('avatars', 'thumb');
        $this->isEditing = false;
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');

        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();
        $this->isEditing = false;

        auth()->user()
            ->clearMediaCollection('avatars');

        auth()->user()
            ->addMedia($this->avatar)
            ->toMediaCollection('avatars');

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.profile.avatar');
    }
}
