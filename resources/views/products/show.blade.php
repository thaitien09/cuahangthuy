<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Chi tiết sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>


        :root {
            --primary-color: #ff6677;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --light-gray: #f1f1f1;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: #fff;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
            padding: 5px 15px;
            font-weight: 600;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .product-image-container {
            position: relative;
            background-color: var(--secondary-color);
            border-radius: 10px;
            overflow: hidden;
            padding: 30px;
        }
        
        .product-image {
            transition: transform 0.3s ease;
        }
        
        .product-image:hover {
            transform: scale(1.05);
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-price {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .product-stock {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .in-stock {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .low-stock {
            background-color: #fff8e1;
            color: #f57f17;
        }
        
        .out-of-stock {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .feature-list {
            margin: 20px 0;
        }
        
        .feature-list li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .feature-list li i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .btn-add-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-add-cart:hover {
            background-color: #ff5266;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 119, 0.3);
        }
        
        .quantity-selector {
            width: 120px;
            margin-right: 15px;
        }
        
        .tab-content {
            padding: 30px;
            background-color: white;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .nav-tabs .nav-link {
            color: var(--text-color);
            font-weight: 500;
            border: none;
            padding: 15px 20px;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            background-color: transparent;
        }
        
        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #555;
        }
        
        .review-content {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .rating {
            color: #ffc107;
        }
        
        .product-thumbnails {
            display: flex;
            margin-top: 15px;
        }
        
        .product-thumbnail {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            padding: 2px;
        }
        
        .product-thumbnail.active {
            border-color: var(--primary-color);
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .back-to-top.show {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .product-image-container {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

@include('header')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<script>
    setTimeout(function() {
        window.location.href = "{{ url()->current() }}";
    }, 2000);
</script>
@endif

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="product-image-container">
                @if($product->stock > 0 && $product->stock < 10)
                    <span class="product-badge bg-warning text-dark">Sắp hết hàng</span>
                @elseif($product->stock <= 0)
                    <span class="product-badge bg-danger text-white">Hết hàng</span>
                @else
                    <span class="product-badge bg-danger text-white">Mới</span>
                @endif
                
                <img id="main-product-image" src="{{ asset('images/' . $product->image) }}" 
                     class="img-fluid rounded product-image" 
                     alt="{{ $product->name }}">
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <h2 class="fw-bold mb-2">{{ $product->name }}</h2>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="rating me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="ms-1 text-muted">(4.5/5)</span>
                    </div>
                    <span class="text-muted">|</span>
                    <span class="ms-2 text-muted">Đã bán: 120</span>
                </div>
                
                <h3 class="product-price fw-bold mb-3">
                    {{ number_format($product->sale_price, 0, ',', '.') }} VND
                </h3>
                
                <!-- Hiển thị số lượng còn lại -->
                @if($product->stock > 10)
                    <div class="product-stock in-stock">
                        <i class="fas fa-check-circle me-1"></i> Còn hàng ({{ $product->stock }})
                    </div>
                @elseif($product->stock > 0)
                    <div class="product-stock low-stock">
                        <i class="fas fa-exclamation-circle me-1"></i> Sắp hết hàng ({{ $product->stock }})
                    </div>
                @else
                    <div class="product-stock out-of-stock">
                        <i class="fas fa-times-circle me-1"></i> Hết hàng
                    </div>
                @endif
                
                <hr class="my-3">
                
                <div class="short-description mb-4">
                    <p>{{ \Illuminate\Support\Str::limit($product->description, 150) }}</p>
                </div>
                
                <ul class="feature-list list-unstyled">
                    <li><i class="fas fa-check-circle"></i> Hàng nhập khẩu chính hãng</li>
                    <li><i class="fas fa-check-circle"></i> Dễ sử dụng &amp; bảo quản</li>
                    <li><i class="fas fa-check-circle"></i> Dinh dưỡng cao, mùi thơm kích thích</li>
                    <li><i class="fas fa-check-circle"></i> SHIP COD toàn quốc</li>
                    <li><i class="fas fa-check-circle"></i> Đổi trả trong vòng 7 ngày</li>
                </ul>
                
                @if ($product->stock > 0)
    @if (Auth::check() && Auth::user()->role === 'user')
        <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center flex-wrap">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <button type="submit" class="btn btn-add-cart">
                <i class="fas fa-shopping-cart me-2"></i> THÊM VÀO GIỎ HÀNG
            </button>
        </form>
    @elseif (!Auth::check())
        <a href="{{ route('login') }}" class="btn btn-primary">
            <i class="fas fa-sign-in-alt me-2"></i> ĐĂNG NHẬP ĐỂ MUA HÀNG
        </a>
    @endif
@else
    <button class="btn btn-secondary" disabled>
        <i class="fas fa-times-circle me-2"></i> SẢN PHẨM ĐÃ HẾT HÀNG
    </button>
@endif

                
                <div class="mt-4">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-2" data-bs-toggle="tooltip" title="Thêm vào yêu thích">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="btn btn-outline-secondary me-2" data-bs-toggle="tooltip" title="So sánh">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Chia sẻ">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                        Chi tiết sản phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                        Đánh giá
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">
                        Vận chuyển & Đổi trả
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <h4 class="mb-4">Mô tả chi tiết</h4>
                    <p>{{ $product->description }}</p>
                    
                    <!-- Thêm nội dung mô tả chi tiết -->
                    <div class="mt-4">
                        <h5>Đặc điểm nổi bật</h5>
                        <ul>
                            <li>Sản phẩm nhập khẩu chính hãng</li>
                            <li>Chất lượng cao, đảm bảo an toàn</li>
                            <li>Được kiểm nghiệm chặt chẽ</li>
                            <li>Bao bì đẹp, sang trọng</li>
                        </ul>
                        
                        <h5 class="mt-4">Hướng dẫn sử dụng</h5>
                        <p>Sử dụng sản phẩm theo chỉ dẫn của nhà sản xuất để đạt hiệu quả tốt nhất. Bảo quản ở nơi khô ráo, thoáng mát và tránh ánh nắng trực tiếp.</p>
                        
                        <h5 class="mt-4">Thông số kỹ thuật</h5>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="30%">Thương hiệu</td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                               <tr>
    <td>Xuất xứ</td>
    <td>{{ $product->origin }}</td>
</tr>
                                <tr>
                                    <td>Bảo hành</td>
                                    <td>12 tháng</td>
                                </tr>
                                <tr>
                                    <td>Trọng lượng</td>
                                    <td>500g</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
    <div class="row">
        <div class="col-md-4">
            <div class="text-center p-4">
                <?php
                $averageRating = DB::table('comments')
                    ->where('product_id', $product->id)
                    ->whereNotNull('rating')
                    ->where('parent_id', null) // Only count parent comments for ratings
                    ->avg('rating') ?? 0;
                $totalReviews = DB::table('comments')
                    ->where('product_id', $product->id)
                    ->where('parent_id', null) // Only count parent comments for total
                    ->count();
                $ratingDistribution = DB::table('comments')
                    ->where('product_id', $product->id)
                    ->where('parent_id', null) // Only count parent comments for distribution
                    ->select('rating', DB::raw('count(*) as total'))
                    ->groupBy('rating')
                    ->pluck('total', 'rating')
                    ->all();
                ?>

                <h2 class="display-4 fw-bold">{{ round($averageRating, 1) }}</h2>
                <div class="rating mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <i class="fas fa-star"></i>
                        @elseif ($i - 0.5 <= $averageRating)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-muted">{{ $totalReviews }} đánh giá</p>

                @for ($i = 5; $i >= 1; $i--)
                    <?php $percentage = $totalReviews > 0 ? (isset($ratingDistribution[$i]) ? ($ratingDistribution[$i] / $totalReviews) * 100 : 0) : 0; ?>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar {{ $i >= 4 ? 'bg-success' : ($i == 3 ? 'bg-warning' : 'bg-danger') }}"
                             role="progressbar" style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>{{ $i }} sao</span>
                        <span>{{ round($percentage) }}%</span>
                    </div>
                @endfor

                @auth
                    <?php
                    $canComment = DB::table('orders')
                        ->where('user_id', Auth::id())
                        ->where('status', 'Giao hàng thành công')
                        ->exists();
                    $hasCommented = DB::table('comments')
                        ->where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->where('parent_id', null) // Check only parent comments
                        ->exists();
                    ?>
                    <div id="reviewFormContainer">
                        @if ($canComment && !$hasCommented)
                            <button class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#reviewForm">Viết đánh giá</button>
                            <div class="collapse mt-3" id="reviewForm">
                                <form id="commentForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Đánh giá:</label>
                                        <select name="rating" id="rating" class="form-select" required>
                                            <option value="">Chọn số sao</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} sao</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Bình luận:</label>
                                        <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                </form>
                                <div id="commentMessage" class="mt-2"></div>
                            </div>
                        @elseif ($hasCommented)
                            <p class="text-muted">Bạn đã đánh giá sản phẩm này.</p>
                        @else
                            <p class="text-muted">Bạn cần mua hàng để viết đánh giá.</p>
                        @endif
                    </div>
                @else
                    <p class="text-muted">Vui lòng đăng nhập để viết đánh giá.</p>
                @endauth
            </div>
        </div>

        <div class="col-md-8">
            <?php
            // Get main comments
            $mainComments = DB::table('comments')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'users.name as user_name', 'users.role as user_role')
                ->where('comments.product_id', $product->id)
                ->where('comments.parent_id', null)
                ->orderBy('comments.created_at', 'desc')
                ->get();
            
            // Get comment replies
            $commentIds = $mainComments->pluck('id')->toArray();
            $replies = DB::table('comments')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'users.name as user_name', 'users.role as user_role')
                ->whereIn('comments.parent_id', $commentIds)
                ->orderBy('comments.created_at', 'asc')
                ->get()
                ->groupBy('parent_id');
            ?>

            <div id="commentList">
                @foreach ($mainComments as $comment)
                    <div class="review-item mb-4 border-bottom pb-4" data-comment-id="{{ $comment->id }}">
                        <div class="d-flex">
                            <div class="review-avatar me-3">
                                <span>{{ strtoupper(substr($comment->user_name, 0, 2)) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-semibold">{{ $comment->user_name }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                                </div>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $comment->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="review-content">
                                    <p>{{ $comment->content }}</p>
                                </div>
                                
                                <!-- Display image if exists -->
                                @if ($comment->image)
                                    <div class="review-image mb-2">
                                        <img src="{{ asset('storage/comments/' . $comment->image) }}" alt="Review image" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                @endif
                                
                                <!-- Reply button for admin/staff -->
                                @auth
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                                        <button class="btn btn-sm btn-outline-secondary reply-toggle mt-2" 
                                                data-comment-id="{{ $comment->id }}">
                                            <i class="fas fa-reply"></i> Trả lời
                                        </button>
                                        
                                        <!-- Reply form (hidden by default) -->
                                        <div class="reply-form collapse mt-2" id="replyForm-{{ $comment->id }}">
                                            <form class="admin-reply-form" data-parent-id="{{ $comment->id }}">
                                                @csrf
                                                <div class="input-group">
                                                    <textarea name="content" class="form-control" rows="2" placeholder="Nhập phản hồi..." required></textarea>
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                                
                                <!-- Display replies -->
                                @if (isset($replies[$comment->id]))
                                    <div class="replies mt-3 ms-4">
                                        @foreach ($replies[$comment->id] as $reply)
                                            <div class="reply-item mb-3 p-3 bg-light rounded" data-reply-id="{{ $reply->id }}">
                                                <div class="d-flex">
                                                    <div class="review-avatar me-2 {{ $reply->user_role === 'admin' ? 'admin-avatar' : ($reply->user_role === 'staff' ? 'staff-avatar' : '') }}">
                                                        <span>{{ strtoupper(substr($reply->user_name, 0, 2)) }}</span>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 fw-semibold">
                                                                {{ $reply->user_name }}
                                                                @if ($reply->user_role === 'admin')
                                                                    <span class="badge bg-danger ms-1">Admin</span>
                                                                @elseif ($reply->user_role === 'staff')
                                                                    <span class="badge bg-info ms-1">Nhân viên</span>
                                                                @endif
                                                            </h6>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</small>
                                                        </div>
                                                        <div class="reply-content">
                                                            <p class="mb-0">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if ($mainComments->count() >= 5)
                <button id="loadMoreReviews" class="btn btn-outline-primary">Xem thêm đánh giá</button>
            @endif
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Customer review submission
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('comments.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#commentMessage').html('<div class="alert alert-success">' + response.message + '</div>');

                        let stars = '';
                        for (let i = 1; i <= 5; i++) {
                            stars += (i <= response.comment.rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        }

                        let newComment = `
                            <div class="review-item mb-4 border-bottom pb-4" data-comment-id="${response.comment.id}">
                                <div class="d-flex">
                                    <div class="review-avatar me-3">
                                        <span>${response.comment.user_name.substr(0, 2).toUpperCase()}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-semibold">${response.comment.user_name}</h6>
                                            <small class="text-muted">${response.comment.created_at}</small>
                                        </div>
                                        <div class="rating">${stars}</div>
                                        <div class="review-content">
                                            <p>${response.comment.content}</p>
                                        </div>`;
                        
                        // Add image if exists
                        if (response.comment.image) {
                            newComment += `
                                <div class="review-image mb-2">
                                    <img src="${response.comment.image_url}" alt="Review image" class="img-fluid rounded" style="max-height: 200px;">
                                </div>`;
                        }

                        // Add reply button for admin/staff (only shown to admin/staff users)
                        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'staff'))
                        newComment += `
                                <button class="btn btn-sm btn-outline-secondary reply-toggle mt-2" 
                                        data-comment-id="${response.comment.id}">
                                    <i class="fas fa-reply"></i> Trả lời
                                </button>
                                
                                <div class="reply-form collapse mt-2" id="replyForm-${response.comment.id}">
                                    <form class="admin-reply-form" data-parent-id="${response.comment.id}">
                                        @csrf
                                        <div class="input-group">
                                            <textarea name="content" class="form-control" rows="2" placeholder="Nhập phản hồi..." required></textarea>
                                            <input type="hidden" name="parent_id" value="${response.comment.id}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-primary">Gửi</button>
                                        </div>
                                    </form>
                                </div>`;
                        @endif

                        newComment += `
                                    </div>
                                </div>
                            </div>
                        `;

                        $('#commentList').prepend(newComment);
                        $('#commentForm')[0].reset();
                        $('#reviewForm').collapse('hide');
                        $('#reviewFormContainer').html('<p class="text-muted">Bạn đã đánh giá sản phẩm này.</p>');

                        // Update rating and total reviews
                        let newTotalReviews = {{ $totalReviews }} + 1;
                        let newAverageRating = ({{ $averageRating * $totalReviews }} + response.comment.rating) / newTotalReviews;
                        $('h2.display-4').text(newAverageRating.toFixed(1));
                        $('p.text-muted').first().text(newTotalReviews + ' đánh giá');

                        let newStars = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= Math.floor(newAverageRating)) {
                                newStars += '<i class="fas fa-star"></i>';
                            } else if (i - 0.5 <= newAverageRating) {
                                newStars += '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                newStars += '<i class="far fa-star"></i>';
                            }
                        }
                        $('.rating.mb-2').html(newStars);

                        // Initialize reply toggles for new comment
                        bindReplyToggles();

                        setTimeout(() => $('#commentMessage').empty(), 3000);
                    }
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Có lỗi xảy ra. Vui lòng thử lại!';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorDetails = '';
                        for (let key in xhr.responseJSON.errors) {
                            errorDetails += xhr.responseJSON.errors[key].join('<br>') + '<br>';
                        }
                        errorMsg += '<br>' + errorDetails;
                    }
                    $('#commentMessage').html('<div class="alert alert-danger">' + errorMsg + '</div>');
                    setTimeout(() => $('#commentMessage').empty(), 5000);
                }
            });
        });

        // Reply toggle functionality
        function bindReplyToggles() {
            $('.reply-toggle').off('click').on('click', function() {
                let commentId = $(this).data('comment-id');
                $('#replyForm-' + commentId).collapse('toggle');
            });
        }
        
        // Initial binding
        bindReplyToggles();

        // Admin/staff reply submission
        $(document).on('submit', '.admin-reply-form', function(e) {
            e.preventDefault();
            
            let form = $(this);
            let parentId = form.data('parent-id');
            let formData = new FormData(form[0]);
            
            $.ajax({
                url: '{{ route('comments.reply') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Create reply HTML
                        let badgeHtml = '';
                        if (response.reply.user_role === 'admin') {
                            badgeHtml = '<span class="badge bg-danger ms-1">Admin</span>';
                        } else if (response.reply.user_role === 'staff') {
                            badgeHtml = '<span class="badge bg-info ms-1">Nhân viên</span>';
                        }
                        
                        let avatarClass = response.reply.user_role === 'admin' ? 'admin-avatar' : 
                                         (response.reply.user_role === 'staff' ? 'staff-avatar' : '');
                        
                        let replyHtml = `
                            <div class="reply-item mb-3 p-3 bg-light rounded" data-reply-id="${response.reply.id}">
                                <div class="d-flex">
                                    <div class="review-avatar me-2 ${avatarClass}">
                                        <span>${response.reply.user_name.substr(0, 2).toUpperCase()}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-semibold">
                                                ${response.reply.user_name}
                                                ${badgeHtml}
                                            </h6>
                                            <small class="text-muted">${response.reply.created_at}</small>
                                        </div>
                                        <div class="reply-content">
                                            <p class="mb-0">${response.reply.content}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        // Add reply to the comment
                        let repliesContainer = form.closest('.flex-grow-1').find('.replies');
                        
                        if (repliesContainer.length === 0) {
                            // Create replies container if it doesn't exist
                            form.closest('.flex-grow-1').append('<div class="replies mt-3 ms-4"></div>');
                            repliesContainer = form.closest('.flex-grow-1').find('.replies');
                        }
                        
                        repliesContainer.append(replyHtml);
                        
                        // Reset form and hide it
                        form[0].reset();
                        $('#replyForm-' + parentId).collapse('hide');
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'Có lỗi xảy ra khi gửi phản hồi. Vui lòng thử lại.';
                    
                    alert(errorMessage);
                }
            });
        });
        
        // Load more reviews functionality
        let page = 1;
        $('#loadMoreReviews').on('click', function() {
            page++;
            
            $.ajax({
                url: '{{ route('comments.load-more') }}',
                method: 'GET',
                data: {
                    page: page,
                    product_id: {{ $product->id }}
                },
                success: function(response) {
                    if (response.comments.length > 0) {
                        // Append comments
                        response.comments.forEach(function(comment) {
                            // Create similar HTML structure as above
                            let commentHtml = createCommentHtml(comment, response.replies);
                            $('#commentList').append(commentHtml);
                        });
                        
                        // Rebind events
                        bindReplyToggles();
                    } else {
                        $('#loadMoreReviews').text('Không còn đánh giá').prop('disabled', true);
                    }
                }
            });
        });
        
        // Helper function to create comment HTML
        function createCommentHtml(comment, replies) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += (i <= comment.rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
            }
            
            let html = `
                <div class="review-item mb-4 border-bottom pb-4" data-comment-id="${comment.id}">
                    <div class="d-flex">
                        <div class="review-avatar me-3">
                            <span>${comment.user_name.substr(0, 2).toUpperCase()}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">${comment.user_name}</h6>
                                <small class="text-muted">${comment.created_at_formatted}</small>
                            </div>
                            <div class="rating">${stars}</div>
                            <div class="review-content">
                                <p>${comment.content}</p>
                            </div>`;
            
            // Add image if exists
            if (comment.image) {
                html += `
                    <div class="review-image mb-2">
                        <img src="${comment.image_url}" alt="Review image" class="img-fluid rounded" style="max-height: 200px;">
                    </div>`;
            }
            
            // Add reply button for admin/staff
            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'staff'))
            html += `
                <button class="btn btn-sm btn-outline-secondary reply-toggle mt-2" 
                        data-comment-id="${comment.id}">
                    <i class="fas fa-reply"></i> Trả lời
                </button>
                
                <div class="reply-form collapse mt-2" id="replyForm-${comment.id}">
                    <form class="admin-reply-form" data-parent-id="${comment.id}">
                        @csrf
                        <div class="input-group">
                            <textarea name="content" class="form-control" rows="2" placeholder="Nhập phản hồi..." required></textarea>
                            <input type="hidden" name="parent_id" value="${comment.id}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </div>
                    </form>
                </div>`;
            @endif
            
            // Add replies if any
            if (replies && replies[comment.id] && replies[comment.id].length > 0) {
                html += `<div class="replies mt-3 ms-4">`;
                
                replies[comment.id].forEach(function(reply) {
                    let badgeHtml = '';
                    if (reply.user_role === 'admin') {
                        badgeHtml = '<span class="badge bg-danger ms-1">Admin</span>';
                    } else if (reply.user_role === 'staff') {
                        badgeHtml = '<span class="badge bg-info ms-1">Nhân viên</span>';
                    }
                    
                    let avatarClass = reply.user_role === 'admin' ? 'admin-avatar' : 
                                    (reply.user_role === 'staff' ? 'staff-avatar' : '');
                    
                    html += `
                        <div class="reply-item mb-3 p-3 bg-light rounded" data-reply-id="${reply.id}">
                            <div class="d-flex">
                                <div class="review-avatar me-2 ${avatarClass}">
                                    <span>${reply.user_name.substr(0, 2).toUpperCase()}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-semibold">
                                            ${reply.user_name}
                                            ${badgeHtml}
                                        </h6>
                                        <small class="text-muted">${reply.created_at_formatted}</small>
                                    </div>
                                    <div class="reply-content">
                                        <p class="mb-0">${reply.content}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
                
                html += `</div>`;
            }
            
            html += `
                        </div>
                    </div>
                </div>
            `;
            
            return html;
        }
    });
</script>

<style>
.review-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #495057;
}

.admin-avatar {
    background-color: #dc3545;
    color: white;
}

.staff-avatar {
    background-color: #17a2b8;
    color: white;
}

.reply-item {
    border-left: 3px solid #17a2b8;
}
</style>
                
                <!-- Shipping Tab -->
                <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                    <h4 class="mb-4">Chính sách vận chuyển & đổi trả</h4>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-shipping-fast me-2 text-primary"></i> Chính sách vận chuyển</h5>
                        <ul>
                            <li>Giao hàng toàn quốc</li>
                            <li>Miễn phí giao hàng cho đơn hàng từ 500.000 VND</li>
                            <li>Thời gian giao hàng: 1-3 ngày làm việc đối với nội thành, 3-5 ngày làm việc đối với các tỉnh thành khác</li>
                            <li>Đơn vị vận chuyển: Giao hàng nhanh, Viettel Post, GHTK</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-exchange-alt me-2 text-primary"></i> Chính sách đổi trả</h5>
                        <ul>
                            <li>Đổi trả trong vòng 7 ngày kể từ ngày nhận hàng</li>
                            <li>Sản phẩm còn nguyên tem, mác, bao bì</li>
                            <li>Sản phẩm chưa qua sử dụng, không bị hư hỏng</li>
                            <li>Phí đổi trả: Miễn phí nếu lỗi do nhà sản xuất, tính phí nếu lỗi do người dùng</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-shield-alt me-2 text-primary"></i> Bảo hành</h5>
                        <ul>
                            <li>Thời gian bảo hành: 12 tháng</li>
                            <li>Phạm vi bảo hành: Lỗi kỹ thuật do nhà sản xuất</li>
                            <li>Không bảo hành với sản phẩm bị hư hỏng do người dùng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="related-products my-4">
    <h5 class="mb-3 text-center">Sản phẩm liên quan</h5>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
        @foreach($relatedProducts as $related)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column">
                    <div class="ratio ratio-1x1">
                        <img src="{{ asset('images/' . $related->image) }}" 
                             class="img-fluid object-fit-contain" 
                             alt="{{ $related->name }}">
                    </div>
                    <div class="card-body p-2 d-flex flex-column">
                        <div class="fw-bold small text-truncate mb-1" title="{{ $related->name }}">
                            {{ $related->name }}
                        </div>
                        <div class="text-success fw-semibold small">
                            {{ number_format($related->sale_price, 0, ',', '.') }}₫
                        </div>
                        <a href="{{ route('products.show', $related->id) }}" 
                           class="btn btn-outline-primary btn-sm w-100 mt-auto">
                            Xem
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>




<!-- Back to top button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</a>

@include('footer')

<!-- Bootstrap JS -->


<script>
    
    
    // Back to top button
    window.addEventListener('scroll', function() {
        var backToTopButton = document.getElementById('backToTop');
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });
    
    document.getElementById('backToTop').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
</script>
</body>
</html>