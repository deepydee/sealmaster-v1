<?php

namespace App\Http\Livewire\Attributes;

use App\Models\Attribute;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class AttributeList extends Component
{
    use WithPagination;

    public Attribute $attribute;
    public Collection $attributes;
    public array $selected = [];
    public array $attributeTypes = [];
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
        ];
    }

    public function mount()
    {
        $this->attributeTypes = [
            'text' => 'Текст',
            'image' => 'Изображение',
        ];
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
        $this->validate();

        $action = $this->editedAttributeId === 0
            ? 'создан'
            : 'отредактирован';
        $message = "Атрибут '{$this->attribute->title}' успешно $action";

        $this->attribute->save();

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
        $attrs = Attribute::latest()
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
