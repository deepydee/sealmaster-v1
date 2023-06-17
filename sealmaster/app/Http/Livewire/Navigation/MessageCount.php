<?php

namespace App\Http\Livewire\Navigation;

use App\Models\Callback;
use Livewire\Component;

class MessageCount extends Component
{
    public int $unreadMessages;

    protected $listeners = [
        'newMessage' => 'incrementCounter',
    ];

    public function mount()
    {
        $this->unreadMessages = Callback::where('is_read', false)->count();
    }

    public function render()
    {
        return view('livewire.navigation.message-count');
    }

    public function incrementCounter(string $phone)
    {
        $this->unreadMessages += 1;
        $this->dispatchBrowserEvent('notify', 'Новое входящее сообщение от '.$phone);
    }
}
