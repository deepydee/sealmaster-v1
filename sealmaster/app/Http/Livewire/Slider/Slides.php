<?php

namespace App\Http\Livewire\Slider;

use App\Models\Slide;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Slides extends Component
{
    use WithPagination;

    public Slide $slide;
    public Collection $slides;
    public array $selected = [];
    public int $currentPage = 1;
    public int $perPage = 10;

    protected $listeners = ['delete', 'deleteSelected'];

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function updateOrder($list): void
    {
        foreach ($list as $item) {
            $slide = $this->slides->firstWhere('id', $item['value']);
            $order = $item['order'] + ($this->currentPage - 1) * $this->perPage;

            if ($slide['position'] !== $order) {
                Slide::whereId($item['value'])->update([
                    'position' => $order,
                ]);

                // $message = "Порядок отображения для слайда '{$slide['title']}' успешно изменен на {$slide['position']}";

                // $this->dispatchBrowserEvent('notify', $message);
            }
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
        $product = Slide::findOrFail($id);
        $product->delete();

        $message = "Слайд '{$product->title}' успешно удален";

        $this->dispatchBrowserEvent('notify', $message);
    }

    public function render()
    {
        $slides = Slide::with('media')->orderBy('position')->paginate($this->perPage);
        $links = $slides->links();
        $this->currentPage = $slides->currentPage();
        $this->slides = collect($slides->items());

        $slides = Slide::with('media')->paginate($this->perPage);

        return view('livewire.slider.slides', [
            'links' => $links,
        ]);
    }
}
