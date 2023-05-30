<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use App\Models\BlogCategory as Category;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BlogCategory extends Component
{
    use WithPagination;

    public Category $category;
    public Collection $categories;
    public bool $showModal = false;
    public int $editedCategoryId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;

    protected $listeners = ['delete'];

    protected function rules(): array
    {
        return [
            'category.title' => ['required', 'string', 'min:3'],
            'category.slug' => ['required', 'string'],
        ];
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->category = new Category();
    }

    public function updatedCategoryTitle(): void
    {
        $this->validateOnly('category.title');
        $this->category->slug = SlugService::createSlug(Category::class, 'slug',  $this->category->title);
    }

    public function editCategory(Category $category): void
    {
        $this->editedCategoryId = $category->id;
        $this->category = $category;
    }

    public function cancelCategoryEdit(): void
    {
        $this->resetValidation();
        $this->reset('editedCategoryId');
    }

    public function save(): void
    {
        $this->validate();

        $this->category->save();

        $this->resetValidation();
        $this->reset('showModal', 'editedCategoryId');
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

    public function delete(Category $category)
    {
        $category->delete();
    }

    public function render()
    {
        $cats = Category::orderBy('position')->paginate($this->perPage);
        $links = $cats->links();
        $this->currentPage = $cats->currentPage();
        $this->categories = collect($cats->items());

        return view('livewire.blog.blog-category', [
            'links' => $links,
        ]);
    }
}
