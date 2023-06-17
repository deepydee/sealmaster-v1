<?php

namespace App\Http\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, AuthorizesRequests;

    public Product $product;
    public Collection $products;
    public array $categories = [];
    public array $selected = [];
    public string $sortColumn = 'products.updated_at';
    public string $sortDirection = 'desc';
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

    public array $searchColumns = [
        'title' => '',
        'product_category_id' => 0,
    ];

    protected $queryString = [
        'sortColumn' => [
            'except' => 'products.updated_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public function mount(): void
    {
        $this->categories = Category::pluck('title', 'id')->toArray();
    }

    public function updatedPerPage(): void
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

    public function delete($id)
    {
        $this->authorize('delete', Product::findOrFail($id));

        $product = Product::findOrFail($id);
        $product->delete();

        $message = "Товар '{$product->title}' успешно удален";

        $this->dispatchBrowserEvent('notify', $message);
    }

    public function deleteSelected(): void
    {
        $products = Product::whereIn('id', $this->selected)->get();
        $productsCount = count($products);
        $products->each->delete();
        $message = "Удалено $productsCount товаров";

        $this->dispatchBrowserEvent('notify', $message);

        $this->reset('selected');
    }


    public function render()
    {
        $this->authorize('viewAny', \App\Models\Product::class);

        $products = Product::query()
            ->select(['products.id', 'products.slug', 'products.title', 'products.code', 'categories.id as categoryId', 'categories.title as categoryTitle',])
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id')
            ->with('categories', 'media');

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                $products
                    ->when($column === 'product_category_id', fn($products) => $products->whereRelation('categories', 'id', $value))
                    ->when($column === 'title', fn($products) => $products->where('products.' . $column, 'LIKE', '%' . $value . '%'));
            }
        }

        $products->orderBy($this->sortColumn, $this->sortDirection);

        $links = $products->paginate($this->perPage)->links();

        $this->products = collect($products->paginate($this->perPage)->items());

        return view('livewire.products.product-list', [
        'links' => $links,
        ]);
    }
}
