<?php

namespace App\Http\Livewire\Blog;

use App\Models\BlogCategory;
use App\Models\BlogPost as Post;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public Post $post;
    public $thumbnail;
    public bool $editing = false;
    public bool $updateThumb = false;
    public ?array $tags = [];
    public array $listsForFields = [];

    protected $casts = [
        'post.blog_category_id' => 'integer',
        'post.user_id' => 'integer',
        'post.is_published' => 'integer',
    ];

    protected function rules(): array
    {
        return [
            'post.title' => ['required', 'string', 'min:3'],
            'post.description' => ['required', 'string', 'min:50'],
            'post.keywords' => ['required', 'string'],
            'post.content' => ['required', 'string'],
            'post.blog_category_id' => ['required', 'integer', 'exists:blog_categories,id'],
            'post.user_id' => ['required', 'integer', 'exists:users,id'],
            'tags' => ['nullable', 'array'],
            'post.is_published' => ['boolean'],
            'thumbnail' => ['nullable', 'image'],
        ];
    }

    public function mount(Post $post): void
    {
        $this->post = $post;
        $this->initListsForFields();

        if ($this->post->exists) {
            $this->editing = true;

            $this->tags = $this->post->tags()
                 ->pluck('id')->toArray();
        } else {
            $this->post->is_published = false;
        }
    }

    public function updatedPostTitle()
    {
        $this->validateOnly('post.title');
    }

    public function updatedPostDescription()
    {
        $this->validateOnly('post.description');
    }

    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
        $this->updateThumb = true;
    }

    public function toggleIsPublished()
    {
        $this->post->update([
            'is_published' => $this->post->is_published,
        ]);
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['categories'] = BlogCategory::pluck('title', 'id')
            ->toArray();

        $this->listsForFields['tags'] = BlogTag::pluck('title', 'id')
            ->toArray();

        $this->listsForFields['users'] = User::whereRelation('roles', 'title', 'editor');

        if (! auth()->user()->isAdministrator()) {
            $this->listsForFields['users'] = $this->listsForFields['users']
                ->where('id', auth()->id());
        }

        $this->listsForFields['users'] = $this->listsForFields['users']
            ->pluck('name', 'id')
            ->toArray();
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->authorize('create', $this->post);

        $this->validate();

        $this->post->save();

        if ($this->updateThumb) {
            $this->post->clearMediaCollection('blog');
            $this->post
                ->addMedia($this->thumbnail)
                ->toMediaCollection('blog');

            $this->updateThumb = false;
        }


        $this->post->tags()->sync($this->tags);

        cache()->forget('blog-posts');
        cache()->forget('vsp-popularPosts');
        cache()->forget('vsp-blogCategories');
        cache()->forget('vsp-blogTags');

        $message = $this->editing
            ? "Статья '{$this->post->title}' успешно отредактирована"
            : "Статья '{$this->post->title}' успешно создана";

        $this->dispatchBrowserEvent('notify', $message);

        return redirect()->route('admin.blog.posts.index');
    }

    public function render()
    {
        $this->authorize('create', $this->post);

        return view('livewire.blog.post-form');
    }
}
