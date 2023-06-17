<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Livewire\Redirector;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public User $user;
    public $thumbnail;
    public bool $editing = false;
    public bool $updateThumb = false;
    public ?array $roles = [];
    public array $listsForFields = [];

    protected function rules(): array
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'user.password' => ['required', Rules\Password::defaults()],
            'user.description' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image'],
        ];
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->initListsForFields();

        if ($this->user->exists) {
            $this->editing = true;

            $this->roles = $this->user->roles()
                 ->pluck('id')->toArray();
        }
    }

    public function updatedUserName()
    {
        $this->validateOnly('user.name');
    }

    public function updatedUserEmail()
    {
        $this->validateOnly('user.email');
    }

    public function updatedUserPassword()
    {
        $this->validateOnly('user.password');
    }

    public function updatedUserDescription()
    {
        $this->validateOnly('user.description');
    }

    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
        $this->updateThumb = true;
    }

    protected function initListsForFields(): void
    {
        $roles = [
            1 => 'Администратор (может все)',
            2 => 'Редактор (работает с блогом)',
            3 => 'Менеджер (работает с каталогом)',
        ];

        $this->listsForFields['roles'] = $roles;
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->authorize('create', $this->user);

        $this->validate();

        // $this->user['password'] = bcrypt($this->user['password']);

        $this->user->save();

        if ($this->updateThumb) {
            $this->user->clearMediaCollection('avatars');
            $this->user
                ->addMedia($this->thumbnail)
                ->toMediaCollection('avatars');

            $this->updateThumb = false;
        }

        $this->user->roles()->sync($this->roles);

        $message = $this->editing
            ? "Пользователь '{$this->user->name}' успешно отредактирован"
            : "Пользователь '{$this->user->name}' успешно создан";

        $this->dispatchBrowserEvent('notify', $message);

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $this->authorize('create', $this->user);

        return view('livewire.users.user-form');
    }
}
