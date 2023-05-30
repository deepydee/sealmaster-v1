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
    public int $editedTagId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;

    protected $listeners = ['delete'];

    protected function rules(): array
    {
        return [
            'tag.title' => ['required', 'string', 'min:3'],
            'tag.slug' => ['required', 'string'],
        ];
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

        $this->tag->save();

        $this->resetValidation();
        $this->reset('showModal', 'editedTagId');
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
        $tag->delete();
    }


    public function render(): View
    {
        $tags = Tag::paginate($this->perPage);
        $links = $tags->links();
        $this->currentPage = $tags->currentPage();
        $this->tags = collect($tags->items());

        return view('livewire.blog.blog-tags', [
            'links' => $links,
        ]);
    }
}
