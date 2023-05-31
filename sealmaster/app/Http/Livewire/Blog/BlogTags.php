<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BlogTag as Tag;
use Illuminate\Support\Collection;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\View\View;

class BlogTags extends Component
{
    use WithPagination;

    public Tag $tag;
    public Collection $tags;
    public bool $showModal = false;
    public array $selected = [];
    public string $sortColumn = 'blog_tags.created_at';
    public string $sortDirection = 'desc';
    public int $editedTagId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;

    protected $listeners = ['delete', 'deleteSelected'];

    public array $itemsToShow = [
        10,
        50,
        100,
        500,
        1000,
    ];

    protected function rules(): array
    {
        return [
            'tag.title' => ['required', 'string', 'min:3'],
            'tag.slug' => ['required', 'string'],
        ];
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

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

    public function openModal(): void
    {
        $this->showModal = true;
        $this->tag = new Tag();
    }

    public function updatedTagTitle(): void
    {
        $this->validateOnly('tag.title');
        $this->tag->slug = SlugService::createSlug(Tag::class, 'slug',  $this->tag->title);
    }

    public function editTag(Tag $tag): void
    {
        $this->editedTagId = $tag->id;
        $this->tag = $tag;
    }

    public function cancelTagEdit(): void
    {
        $this->resetValidation();
        $this->reset('editedTagId');
    }

    public function save(): void
    {
        $this->validate();

        $action = $this->editedTagId === 0
            ? 'создан'
            : 'отредактирован';
        $message = "Тег '{$this->tag->title}' успешно $action";

        $this->tag->save();

        $this->resetValidation();
        $this->reset('showModal', 'editedTagId');

        $this->dispatchBrowserEvent('notify', $message);
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

    public function delete(Tag $tag)
    {
        $message = "Тег '{$tag->title}' успешно удален";
        $tag->delete();

        $this->dispatchBrowserEvent('notify', $message);
    }

    public function deleteSelected(): void
    {
        $tags = Tag::whereIn('id', $this->selected)->get();
        $tagCount = count($tags);
        $tags->each->delete();
        $message = "$tagCount тегов успешно удалено";

        $this->dispatchBrowserEvent('notify', $message);

        $this->reset('selected');
    }


    public function render(): View
    {
        $tags = Tag::orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        $links = $tags->links();
        $this->currentPage = $tags->currentPage();
        $this->tags = collect($tags->items());

        return view('livewire.blog.blog-tags', [
            'links' => $links,
            'tags' => $tags,
        ]);
    }
}
