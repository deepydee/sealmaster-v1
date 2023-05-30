<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use App\Models\BlogCategory as Category;
use Illuminate\Support\Collection;
use Livewire\WithPagination;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\View\View;

class BlogCategories extends Component
{
    use WithPagination;

    public Category $category;
    public Collection $categories;
    public array $selected = [];
    public string $sortColumn = 'blog_categories.title';
    public string $sortDirection = 'asc';
    public bool $showModal = false;
    public int $editedCategoryId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;

    public array $itemsToShow = [
        10,
        50,
        100,
        500,
        1000,
    ];

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

    public function updatedPerPage()
    {
        $this->resetPage();
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

    public function render(): View
    {
        $cats = Category::orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        $links = $cats->links();
        $this->currentPage = $cats->currentPage();
        $this->categories = collect($cats->items());

        return view('livewire.blog.blog-categories', [
            'links' => $links,
            'categories' => $cats,
        ]);
    }
}