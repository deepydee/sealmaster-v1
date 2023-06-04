<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;


class CategoryForm extends Component
{
    use WithFileUploads;

    public Category $category;
    public $initialParentId;
    public $thumbnail;
    public bool $editing = false;
    public bool $updateThumb = false;
    public array $listsForFields = [];

    protected $casts = [
        'category.parent_id' => 'integer',
    ];

    protected function rules(): array
    {
        return [
            'category.title' => ['required', 'string', 'min:3'],
            'category.description' => ['required', 'string', 'min:50'],
            'category.keywords' => ['required', 'string'],
            'category.content' => ['nullable', 'string'],
            'category.parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'thumbnail' => ['nullable', 'image'],
        ];
    }

    public function mount(Category $category, Request $request): void
    {
        $this->category = $category;
        $this->initialParentId = $this->category->parent_id;
        $this->initListsForFields();

        if ($this->category->exists && $request->addChild) {
            $parent_id = $this->category->id;
            $this->category = new Category();
            $this->category->parent_id = $parent_id;
        }

        if ($this->category->exists && $request->addChild === null) {
            $this->editing = true;
        }
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['categories'] = Category::pluck('title', 'id')
            ->toArray();
    }

    public function updatedCategoryTitle()
    {
        $this->validateOnly('category.title');
    }

    public function updatedCategoryDescription()
    {
        $this->validateOnly('category.description');
    }

    public function updatedThumbnail()
    {
        $this->updateThumb = true;
        $this->validateOnly('thumbnail');
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->validate();

        DB::transaction(function () {
            $this->category->save();

            if ($this->category->parent_id && $this->category->parent_id !== $this->initialParentId) {
                $parentNode = Category::find($this->category->parent_id);
                $parentNode->appendNode($this->category);
            }
        });

        if ($this->updateThumb) {
            $this->category->clearMediaCollection('categories');
            $this->category
                ->addMedia($this->thumbnail)
                ->toMediaCollection('categories');

            $this->updateThumb = false;
        }


        $message = $this->editing
            ? "Категория '{$this->category->title}' успешно отредактирована"
            : "Категория '{$this->category->title}' успешно создана";

        $this->dispatchBrowserEvent('notify', $message);

        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.categories.category-form');
    }
}
