
@if ($featuredPosts)
<div class="col-12">
    <h3 class="fw-bold">Рекомендуем</h3>

    <div class="row">
        @foreach ($featuredPosts as $post)
        <div class="col-12 mb-3">
            @include('front.layouts.chunks.post-card', ['post' => $post])
        </div>
        @endforeach
    </div>
</div>
@endif
