<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination, AuthorizesRequests;

    public User $user;
    public Collection $users;
    public array $selected = [];
    public string $sortColumn = 'users.name';
    public string $sortDirection = 'desc';
    public int $currentPage = 1;
    public int $perPage = 10;

    public array $itemsToShow = [
        10,
        50,
        100,
        500,
        1000,
    ];

    protected $listeners = ['delete', 'deleteSelected'];

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function sortByColumn($column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc'
                ? 'desc'
                : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function deleteConfirm($method, $id = null)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type'   => 'warning',
            'title'  => 'Вы уверены?',
            'text'   => '',
            'id'     => $id,
            'method' => $method,
        ]);
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        $message = "Пользователь '{$user->name}' успешно удален";
        $user->delete();

        $this->dispatchBrowserEvent('notify', $message);
    }

    public function deleteSelected(): void
    {
        $users = User::whereIn('id', $this->selected)->get();
        $usrCount = count($users);
        $users->each->delete();
        $message = "$usrCount категорий успешно удалено";

        $this->dispatchBrowserEvent('notify', $message);

        $this->reset('selected');
    }

    public function render()
    {
        $this->authorize('viewAny', \App\Models\User::class);

        $usrs = User::with('media', 'roles')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        $links = $usrs->links();
        $this->currentPage = $usrs->currentPage();
        $this->users = collect($usrs->items());

        return view('livewire.users.user-list', [
            'links' => $links,
            'users' => $usrs,
        ]);
    }
}
