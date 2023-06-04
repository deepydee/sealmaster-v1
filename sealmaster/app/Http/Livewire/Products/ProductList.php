<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public Product $product;
    public array $products;
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
        // 'blog_tag_id' => 0,
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
        $this->products = Product::with('categories')
            ->pluck('title', 'id')->toArray();
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

    public function delete(Product $product)
    {
        $message = "Товар '{$product->title}' успешно удален";
        $product->delete();

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
        $products = Product::with('categories', 'attributes'); //->orderBy($this->sortColumn, $this->sortDirection);

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                $products
                    ->when($column === 'title', fn($posts) => $posts->where('blog_posts.' . $column, 'LIKE', '%' . $value . '%'));
            }
        }

        $products->orderBy($this->sortColumn, $this->sortDirection);

        $links = $products->paginate($this->perPage)->links();

        return view('livewire.products.product-list', [
            'links' => $links,
        ]);
    }
}
