@include('header')

<div class="container py-5">
    <!-- Tiêu đề với thiết kế hiện đại -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="display-4 fw-bold mb-2">Danh sách bài viết</h2>
            <div class="divider-custom mx-auto mb-4">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-book-open"></i></div>
                <div class="divider-custom-line"></div>
            </div>
        </div>
    </div>
    
    @if($articles->isEmpty())
        <div class="alert alert-info text-center p-5 shadow-sm">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <p class="lead mb-0">Không có bài viết nào để hiển thị.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <!-- Ảnh thumbnail với hiển thị đầy đủ -->
                        <div class="card-img-container position-relative overflow-hidden">
                            @if($article->thumbnail)
                                <img src="{{ asset('images/' . $article->thumbnail) }}" alt="{{ $article->title }}" 
                                     class="card-img-top transition-image" style="width: 100%; height: auto; aspect-ratio: 16/9; object-fit: contain;">
                            @else
                                <img src="{{ asset('images/default-thumbnail.jpg') }}" alt="Default Thumbnail" 
                                     class="card-img-top transition-image" style="width: 100%; height: auto; aspect-ratio: 16/9; object-fit: contain;">
                            @endif
                            <div class="img-overlay d-flex align-items-center justify-content-center">
                                <a href="{{ route('article.show', $article->slug) }}" class="btn btn-light rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Meta info -->
                            <div class="d-flex justify-content-between mb-2 text-muted small">
                                <span><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($article->created_at)->format('d/m/Y') }}</span>
                                <span><i class="far fa-eye me-1"></i>{{ $article->view_count }} lượt xem</span>
                            </div>
                            
                            <!-- Tiêu đề bài viết -->
                            <h5 class="card-title fw-bold mb-3">{{ $article->title }}</h5>
                            
                            <!-- Tóm tắt bài viết -->
                            <p class="card-text text-muted flex-grow-1">{!! \Illuminate\Support\Str::limit($article->summary, 120) !!}</p>
                            
                            <!-- Nút đọc thêm -->
                            <a href="{{ route('article.show', $article->slug) }}" class="btn btn-outline-primary mt-3 align-self-start">
                                Đọc thêm <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Phân trang nếu có -->
        @if(isset($articles->links))
        <div class="mt-5">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
        @endif
    @endif
</div>

<!-- Custom CSS cho giao diện -->
<style>
    .divider-custom {
        width: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .divider-custom-line {
        width: 35px;
        height: 3px;
        background-color: #3b82f6;
        border-radius: 1rem;
    }
    
    .divider-custom-icon {
        color: #3b82f6;
        font-size: 1.2rem;
        padding: 0 1rem;
    }
    
    .hover-card {
        transition: transform 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
    }
    
    .card-img-container {
        position: relative;
        overflow: hidden;
        background-color: #f8f9fa;
        aspect-ratio: 16/9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .transition-image {
        transition: transform 0.5s ease;
        max-width: 100%;
        max-height: 100%;
    }
    
    .img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .card-img-container:hover .transition-image {
        transform: scale(1.05);
    }
    
    .card-img-container:hover .img-overlay {
        opacity: 1;
    }
    
    .btn-light.rounded-circle {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@include('footer')