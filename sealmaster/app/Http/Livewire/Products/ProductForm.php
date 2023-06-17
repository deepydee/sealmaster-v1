<?php

namespace App\Http\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public Product $product;
    public $thumbnail;
    public bool $editing = false;
    public bool $updateThumb = false;
    public int $categoryId;
    public array $attributes = [];
    public array $inputs = [];
    public array $listsForFields = [];
    public int $i = 1;
    public $attributeValue;

    protected function rules(): array
    {
        return [
            'product.title' => ['required', 'string', 'min:3'],
            'product.code' => ['nullable', 'string', 'min:3'],
            'product.description' => ['required', 'string', 'min:50'],
            'categoryId' => ['required', 'integer'],
            'attributes' => ['required'],
            'thumbnail' => ['nullable', 'image'],
            'attributes.*' => ['required'],
            'attributeValue.*' => ['required'],

        ];
    }

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->initListsForFields();

        if ($this->product->exists) {
            $this->editing = true;
            $this->product->load('categories', 'attributes');

            $this->categoryId = $this->product->categories->first()->id;

            $category = Category::findOrFail($this->categoryId);
            $attributes = $category->attributes()
                ->pluck('title', 'id')
                ->toArray();

            $this->listsForFields['attributes'] = $attributes;

            if ($this->product->attributes) {
                foreach ($this->product->attributes as $key => $value) {
                    $this->attributes[$key] = $value['id'];
                    $this->attributeValue[$key] = $value['pivot']['value'];

                    if ($this->i > 1) {
                        $this->inputs[$this->i] = $key;
                    }

                    $this->i++;
                }
            }

            // dd($this->attributes, $this->attributeValue,  $this->inputs);

        }
    }

    public function updatedAttributes()
    {
        // dd($this->attributes, $this->attributeValue,  $this->inputs);
    }

    public function updatedCategoryId()
    {
        $category = Category::findOrFail($this->categoryId);

        $attributes = $category->attributes()
            ->pluck('title', 'id')
            ->toArray();

        $this->listsForFields['attributes'] = $attributes;
    }

    public function updatedProductTitle()
    {
        $this->validateOnly('product.title');
    }

    public function updatedProductDescription()
    {
        $this->validateOnly('product.description');
    }

    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
        $this->updateThumb = true;
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['categories'] = Category::pluck('title', 'id')
            ->toArray();

        $this->listsForFields['attributes'] = [];
    }

    public function addAttribute(int $i): void
    {
        $i += 1;
        $this->i = $i;

        array_push($this->inputs, $i);
    }

    public function removeAttribute($i)
    {
        unset($this->attributes[$this->inputs[$i]]);
        unset($this->attributeValue[$this->inputs[$i]]);
        unset($this->inputs[$i]);
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->authorize('create', $this->product);

        $this->validate();

        $attributes = [];

        foreach ($this->attributes as $key => $value) {
            $attributes[$value] = ['value' => $this->attributeValue[$key]];
        }

        $category = Category::findOrFail($this->categoryId);

        // dd($this->attributeValue, $this->attributes, $attributes, $category);

        $this->product->save();

        if ($this->updateThumb) {
            $this->product->clearMediaCollection('products');
            $this->product
                ->addMedia($this->thumbnail)
                ->toMediaCollection('products');

            $this->updateThumb = false;
        }

        $this->product->categories()->sync($category);
        $this->product->attributes()->sync($attributes);


        $message = $this->editing
            ? "Товар '{$this->product->title}' успешно отредактирован"
            : "Товар '{$this->product->title}' успешно создан";

        $this->dispatchBrowserEvent('notify', $message);

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $this->authorize('create', \App\Models\Product::class);

        return view('livewire.products.product-form');
    }
}
