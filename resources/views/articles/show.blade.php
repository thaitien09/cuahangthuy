@include('header')

<div class="container py-5">
    <!-- Article Header Section -->
    <div class="row mb-5">
        <div class="col-lg-10 col-md-12 mx-auto">
            <h1 class="display-4 fw-bold mb-4 text-center">{{ $article->title }}</h1>

            <!-- Stylish divider -->
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="bg-primary" style="height: 2px; width: 80px;"></div>
                <div class="mx-3"><i class="fas fa-book-open text-primary"></i></div>
                <div class="bg-primary" style="height: 2px; width: 80px;"></div>
            </div>

            <!-- Article Meta -->
            <div class="d-flex justify-content-center flex-wrap gap-4 mb-4">
                <div class="d-flex align-items-center">
                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                    <span>{{ \Carbon\Carbon::parse($article->created_at)->format('d/m/Y') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="far fa-eye me-2 text-primary"></i>
                    <span>{{ number_format($article->view_count) }} lượt xem</span>
                </div>
                <div class="d-flex align-items-center">
    <i class="fas fa-folder-open me-2 text-primary"></i>
    <span>{{ $article->category }}</span>
</div>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    <div class="row mb-5">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="rounded-3 overflow-hidden shadow-lg">
                @if($article->thumbnail)
                    <img src="{{ asset('images/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="img-fluid w-100" style="max-height: 600px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/default-thumbnail.jpg') }}" alt="Default Thumbnail" class="img-fluid w-100" style="max-height: 600px; object-fit: cover;">
                @endif
            </div>
        </div>
    </div>

    <!-- Article Summary -->
   

    <!-- Article Content -->
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <article class="bg-white shadow rounded-3 p-4 p-md-5">
                <div class="article-content fs-5 lh-lg">
                    {!! $article->content !!}
                </div>
            </article>
        </div>
    </div>

    <!-- Tags Section -->
    @if($article->tags)
    <div class="row mt-4">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="mb-3">
                <h6 class="text-muted mb-2">Tags:</h6>
                @foreach(explode(',', $article->tags) as $tag)
                    <span class="badge bg-secondary me-2 mb-1">{{ trim($tag) }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="row mt-5">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <a href="{{ url('/articles') }}" class="btn btn-outline-primary">
                    <i class="fas fa-chevron-left me-2"></i> Trở lại
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .article-content {
        color: #333;
    }

    .article-content h2,
    .article-content h3,
    .article-content h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .article-content p {
        margin-bottom: 1.2rem;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .article-content blockquote {
        border-left: 4px solid #0d6efd;
        padding-left: 1rem;
        color: #555;
        font-style: italic;
        margin: 1.5rem 0;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 2rem;
        margin-bottom: 1.2rem;
    }

    .article-content a {
        color: #0d6efd;
        text-decoration: none;
    }

    .article-content a:hover {
        text-decoration: underline;
    }

    html {
        scroll-behavior: smooth;
    }
</style>

@include('footer')
