<?php

namespace App\Http\Livewire\Blog;

use App\Models\BlogCategory;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BlogPost as Post;
use App\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class BlogPosts extends Component
{
    use WithPagination;

    public Post $post;
    public Collection $posts;
    public array $selected = [];
    public array $categories = [];
    public array $tags = [];
    public array $active = [];
    public string $sortColumn = 'blog_posts.created_at';
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
        'blog_category_id' => 0,
        'blog_tag_id' => 0,
    ];

    protected $queryString = [
        'sortColumn' => [
            'except' => 'blog_posts.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public function mount(): void
    {
        $this->categories = BlogCategory::pluck('title', 'id')->toArray();
        $this->tags = BlogTag::pluck('title', 'id')->toArray();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function toggleIsActive(Post $post): void
    {
        $post->update([
            'is_published' => $this->active[$post->id],
        ]);

        $message = $post->is_published
            ? "Статья '{$post->title}' опубликована"
            : "Статья '{$post->title}' снята с публикации";

        $this->dispatchBrowserEvent('notify', $message);
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

    public function delete(Post $post)
    {
        $message = "Статья '{$post->title}' успешно удалена";
        $post->delete();

        $this->dispatchBrowserEvent('notify', $message);
    }

    public function deleteSelected(): void
    {
        $posts = Post::whereIn('id', $this->selected)->get();
        $postCount = count($posts);
        $posts->each->delete();
        $message = "Удалено $postCount статей";

        $this->dispatchBrowserEvent('notify', $message);

        $this->reset('selected');
    }


    public function render(): View
    {
        $posts = Post::query()
            ->select(['blog_posts.*', 'blog_categories.id as categoryId', 'blog_categories.title as categoryTitle',])
            ->join('blog_categories', 'blog_categories.id', '=', 'blog_posts.blog_category_id')
            ->with('category', 'tags', 'user', 'media');

        // $posts = Post::with('category', 'tags', 'user', 'media'); //->orderBy($this->sortColumn, $this->sortDirection);

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                $posts
                    ->when($column === 'blog_category_id', fn($posts) => $posts->whereRelation('category', 'id', $value))
                    ->when($column === 'blog_tag_id', fn($posts) => $posts->whereRelation('tags', 'id', $value))
                    ->when($column === 'title', fn($posts) => $posts->where('blog_posts.' . $column, 'LIKE', '%' . $value . '%'));
            }
        }

        $posts->orderBy($this->sortColumn, $this->sortDirection);

        $links = $posts->paginate($this->perPage)->links();

        $this->posts = collect($posts->paginate($this->perPage)->items());
        $this->active = $this->posts->mapWithKeys(
            fn (Post $item) => [$item['id'] => (bool) $item['is_published']]
        )->toArray();

        return view('livewire.blog.blog-posts', [
            'links' => $links,
        ]);
    }
}
