<?php

namespace App\Http\Livewire\Slider;

use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;
use \Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

class SlideForm extends Component
{
    use WithFileUploads;

    public Slide $slide;
    public bool $editing = false;
    public $thumbnail;
    public bool $updateThumb = false;

    protected function rules(): array
    {
        return [
            'slide.title' => ['required', 'string', 'min:3'],
            'slide.description' => ['required', 'string', 'min:10'],
            'slide.content' => ['nullable', 'string', 'min:10'],
            'slide.link' => ['nullable', 'string', 'min:10'],
            'thumbnail' => ['nullable', 'image', 'max:1000'],
        ];
    }

    public function mount(Slide $slide)
    {
        $this->slide = $slide;

        if ($this->slide->exists) {
            $this->editing = true;
        }
    }

    public function updatedSlideTitle()
    {
        $this->validateOnly('slide.title');
    }

    public function updatedSlideDescription()
    {
        $this->validateOnly('slide.content');
    }


    public function updatedSlideContent()
    {
        $this->validateOnly('slide.content');
    }

    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
        $this->updateThumb = true;
    }

    public function render()
    {
        return view('livewire.slider.slide-form');
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->validate();

        $this->slide->save();

        if ($this->updateThumb) {
            $this->slide->clearMediaCollection('slides');
            $mediaItems = $this->slide
                ->addMedia($this->thumbnail)
                ->toMediaCollection('slides');

            $responsiveImageGenerator = app(ResponsiveImageGenerator::class);
            $responsiveImageGenerator->generateResponsiveImages($mediaItems);

            $this->updateThumb = false;
        }

        $message = $this->editing
        ? "Слайд '{$this->slide->title}' успешно отредактирован"
        : "Слайд '{$this->slide->title}' успешно создан";

        $this->dispatchBrowserEvent('notify', $message);

        return redirect()->route('admin.slides.index');
    }
}
