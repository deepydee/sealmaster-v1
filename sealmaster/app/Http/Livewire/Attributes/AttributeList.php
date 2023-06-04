<?php

namespace App\Http\Livewire\Attributes;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class AttributeList extends Component
{
    use WithPagination;

    public Attribute $attribute;
    public Collection $attributes;
    public $category;
    public array $selected = [];
    public array $attributeTypes = [];
    public array $categoriesList = [];
    public bool $showModal = false;
    public int $editedAttributeId = 0;
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

    protected function rules(): array
    {
        return [
            'attribute.title' => ['required', 'string', 'min:3'],
            'attribute.type' => ['required', 'string'],
            'category' => ['required'],
        ];
    }

    public function mount()
    {
        $this->attributeTypes = [
            'text' => 'Текст',
            'image' => 'Изображение',
        ];

        $this->categoriesList = Category::pluck('title', 'id')
            ->toArray();
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->attribute = new Attribute();
    }

    public function updatedAttributeTitle(): void
    {
        $this->validateOnly('attribute.title');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function editAttribute(Attribute $attribute): void
    {
        $this->editedAttributeId = $attribute->id;
        $this->attribute = $attribute;
    }

    public function cancelAttributeEdit(): void
    {
        $this->resetValidation();
        $this->reset('editedAttributeId');
    }

    public function save(): void
    {
        // dd(Category::descendantsAndSelf($this->category)->pluck('title', 'id')->toArray());

        $this->validate();

        $this->attribute->save();

        $categories = Category::descendantsAndSelf($this->category)
            ->pluck('id')->toArray();

        $this->attribute->categories()->sync($categories);

        $action = $this->editedAttributeId === 0
            ? 'создан'
            : 'отредактирован';
        $message = "Атрибут '{$this->attribute->title}' успешно $action";


        $this->resetValidation();
        $this->reset('showModal', 'editedAttributeId');


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

    public function delete(Attribute $attribute)
    {
        $attribute->delete();

        $message = "Атрибут '{$attribute->title}' успешно удален";
        $this->dispatchBrowserEvent('notify', $message);
    }

    public function deleteSelected(): void
    {
        $attributes = Attribute::whereIn('id', $this->selected)->get();
        $attrCount = count($attributes);
        $attributes->each->delete();
        $message = "$attrCount атрибутов успешно удалено";

        $this->dispatchBrowserEvent('notify', $message);

        $this->reset('selected');
    }

    public function render(): View
    {
        $attrs = Attribute::with('categories')
            ->latest()
            ->paginate($this->perPage);

        $links = $attrs->links();
        $this->currentPage = $attrs->currentPage();
        $this->attributes = collect($attrs->items());

        return view('livewire.attributes.attribute-list', [
            'links' => $links,
            'attributes' => $attrs,
        ]);
    }
}
