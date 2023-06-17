<?php

namespace App\Http\Livewire;

use App\Models\Callback;
use Livewire\Component;

class FooterForm extends Component
{
    public Callback $callback;

    protected function rules(): array
    {
        return [
            'callback.phone' => ['required', 'string', 'regex:/^[\+7|8]([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'callback.name' => ['nullable', 'string', 'max:255'],
            'callback.message' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function mount(Callback $callback)
    {
        $this->callback = $callback;
    }

    public function updatedCallbackPhone()
    {
        $this->validateOnly('callback.phone');
    }

    public function updatedCallbackName()
    {
        $this->validateOnly('callback.name');
    }

    public function updatedCallbackMessage()
    {
        $this->validateOnly('callback.message');
    }

    public function submit()
    {
        $this->validate();

        $this->callback['phone'] = preg_replace('/-|\s|\(|\)/', '', $this->callback['phone']);

        $this->callback->save();

        $this->resetErrorBag();
        $this->resetValidation();

        session()->flash('message', 'Благодарим за обращение! Скоро мы Вам перезвоним!');
    }

    public function render()
    {
        return view('livewire.footer-form');
    }
}
