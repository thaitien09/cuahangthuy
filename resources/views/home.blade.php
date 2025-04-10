@include('header')
<section id="banner" style="background: #F9F3EC;">
    <div class="container">
        <div class="swiper main-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide py-5">
                    <div class="row banner-content align-items-center">
                        <div class="img-wrapper col-md-5">
                            <img src="images/banner-img.png" class="img-fluid">
                        </div>
                        <div class="content-wrapper col-md-7 p-5 mb-5">
                            <div class="secondary-font text-primary text-uppercase mb-4">Giảm giá từ 10 đến 20%</div>
                            <h2 class="banner-title display-1 fw-normal">Các phụ kiện <span class="text-primary">cho thú cưng</span></h2>
                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Mua ngay
                                <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide py-5">
                    <div class="row banner-content align-items-center">
                        <div class="img-wrapper col-md-5">
                            <img src="images/banner-img3.png" class="img-fluid">
                        </div>
                        <div class="content-wrapper col-md-7 p-5 mb-5">
                            <div class="secondary-font text-primary text-uppercase mb-4">Giảm giá từ 10 đến 20%</div>
                            <h2 class="banner-title display-1 fw-normal">Các phụ kiện <span class="text-primary">cho thú cưng</span></h2>
                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Mua ngay
                                <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide py-5">
                    <div class="row banner-content align-items-center">
                        <div class="img-wrapper col-md-5">
                            <img src="images/banner-img4.png" class="img-fluid">
                        </div>
                        <div class="content-wrapper col-md-7 p-5 mb-5">
                            <div class="secondary-font text-primary text-uppercase mb-4">Giảm giá từ 10 đến 20%</div>
                            <h2 class="banner-title display-1 fw-normal">Các phụ kiện <span class="text-primary">cho thú cưng</span></h2>
                            <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Mua ngay
                                <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Thêm nút điều hướng -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination mb-5"></div>
        </div>
    </div>
</section>




<script>
    var swiper = new Swiper('.main-swiper', {
        slidesPerView: 1, // Number of slides visible at once
        spaceBetween: 10, // Space between slides
        loop: true, // Loop through slides infinitely
        pagination: {
            el: '.swiper-pagination', // Pagination element
            clickable: true, // Allow pagination to be clickable
        },
        autoplay: {
            delay: 3000, // Auto slide delay in milliseconds (3 seconds)
        },
    });
</script>
<!-- Include Swiper JS -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<div class="container mt-5">
    <!-- Filter Section -->
    <div class="card shadow-sm mb-4 border-0 rounded-lg">
        <div class="card-body">
            <form method="GET" action="{{ url('/home') }}" class="mb-0">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Danh mục</label>
                        <select name="category" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Loại sản phẩm</label>
                        <select name="type" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            <option value="">Tất cả loại</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Sắp xếp theo</label>
                        <select name="sort_price" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            <option value="">Mặc định</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Sản phẩm</h3>
        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
            <i class="fas fa-shopping-basket me-1"></i> {{ $products->total() ?? 0 }} sản phẩm
        </span>
    </div>

    <!-- Product Grid -->
    <div id="product-list">
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card h-100 product-card border-0 shadow-sm">
                        <div class="product-img-container position-relative">
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body p-3">
                            <h5 class="card-title" title="{{ $product->name }}">{{ $product->name }}</h5>
                            <div class="product-info">
                                <p class="text-muted mb-1 d-flex align-items-center">
                                    <i class="fas fa-tag me-1 small"></i>
                                    <span>{{ $product->category_name ?? 'Không xác định' }}</span>
                                </p>
                                <p class="text-muted mb-2 d-flex align-items-center">
                                    <i class="fas fa-cubes me-1 small"></i>
                                    <span>{{ $product->type_name ?? 'Không xác định' }}</span>
                                </p>
                            </div>
                            <p class="text-success fw-bold fs-5 mb-3">
                                {{ number_format($product->sale_price, 0, ',', '.') }} VND
                            </p>
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-primary rounded-pill w-100">
                               <i class="fas fa-eye me-1"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <ul class="pagination">
                {{-- Liên kết Trang Trước --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link rounded-start border-0"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-start border-0" href="{{ $products->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Các Liên kết Trang --}}
                @foreach ($products->links() as $link)
                    {{-- "Ba dấu chấm" --}}
                    @if (is_string($link))
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link border-0">{{ $link }}</span>
                        </li>
                    @endif

                    {{-- Mảng các liên kết --}}
                    @if (is_array($link))
                        @foreach ($link as $page => $url)
                            @if ($page == $products->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link border-0">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Liên kết Trang Tiếp theo --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-end border-0" href="{{ $products->nextPageUrl() }}" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link rounded-end border-0"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Contact Buttons -->
<div class="position-fixed top-50 end-0 translate-middle-y p-3 d-flex flex-column gap-3 contact-buttons">
    <a href="https://zalo.me/0913263053" target="_blank" class="btn btn-light border-0 rounded-circle shadow p-2 contact-btn zalo-btn" title="Liên hệ qua Zalo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Icon_of_Zalo.svg/120px-Icon_of_Zalo.svg.png" 
             alt="Zalo" width="32">
    </a>
    <a href="https://m.me/thai.tien.395282" target="_blank" class="btn btn-primary border-0 rounded-circle shadow p-2 contact-btn messenger-btn" title="Nhắn tin qua Messenger">
        <i class="fab fa-facebook-messenger text-white fs-5"></i>
    </a>
    <a href="tel:0913263053" class="btn btn-danger border-0 rounded-circle shadow p-2 contact-btn phone-btn" title="Gọi ngay">
        <i class="fas fa-phone-alt text-white fs-5"></i>
    </a>
</div>


<!-- Phần Tính năng -->
<section class="features-section">
  <div class="container">
    <div class="features-row">
      <!-- Tính năng Giao hàng Miễn phí -->
      <div class="feature-item">
        <div class="feature-icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <h3>Giao hàng Miễn phí</h3>
        <p>Đau đớn có thể xảy ra, nhưng đó là điều cần thiết cho quá trình tiến hóa.</p>
      </div>
      
      <!-- Tính năng Thanh toán An toàn 100% -->
      <div class="feature-item">
        <div class="feature-icon">
          <i class="fas fa-lock"></i>
        </div>
        <h3>Thanh toán An toàn 100%</h3>
        <p>Đau đớn có thể xảy ra, nhưng đó là điều cần thiết cho quá trình tiến hóa.</p>
      </div>
      
      <!-- Tính năng Ưu đãi Hàng ngày -->
      <div class="feature-item">
        <div class="feature-icon">
          <i class="fas fa-tag"></i>
        </div>
        <h3>Ưu đãi Hàng ngày</h3>
        <p>Đau đớn có thể xảy ra, nhưng đó là điều cần thiết cho quá trình tiến hóa.</p>
      </div>
      
      <!-- Tính năng Đảm bảo Chất lượng -->
      <div class="feature-item">
        <div class="feature-icon">
          <i class="fas fa-medal"></i>
        </div>
        <h3>Đảm bảo Chất lượng</h3>
        <p>Đau đớn có thể xảy ra, nhưng đó là điều cần thiết cho quá trình tiến hóa.</p>
      </div>
    </div>
  </div>
</section>

<!-- Phần Thư viện Ảnh Thú cưng -->
<section class="pet-gallery">
  <div class="container">
    <div class="gallery-row">
      <!-- Ảnh Thú cưng 1 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta1.jpg" alt="Mèo với khăn đỏ">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
      
      <!-- Ảnh Thú cưng 2 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta2.jpg" alt="Mèo trên gối">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
      
      <!-- Ảnh Thú cưng 3 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta3.jpg" alt="Chó Shih Tzu">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
      
      <!-- Ảnh Thú cưng 4 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta4.jpg" alt="Hai con chó">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
      
      <!-- Ảnh Thú cưng 5 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta5.jpg" alt="Chó Bulldog Pháp">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
      
      <!-- Ảnh Thú cưng 6 -->
      <div class="gallery-item">
        <div class="image-container">
          <img src="images/insta6.jpg" alt="Mèo với cột cào">
          <div class="overlay">
            <i class="fab fa-instagram"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* General styles */

/* Features section styles */
.features-section {
  padding: 60px 0;
  background-color: #f9f9f9;
}

.features-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.feature-item {
  flex: 0 0 calc(25% - 20px);
  text-align: center;
  padding: 20px;
  margin-bottom: 20px;
  transition: all 0.3s ease;
}

.feature-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.feature-icon {
  font-size: 2.5rem;
  color: #3498db; /* Đổi sang màu xanh */
  margin-bottom: 15px;
}

.feature-item h3 {
  margin-bottom: 10px;
  font-size: 1.2rem;
  color: #333;
}

.feature-item p {
  color: #666;
  font-size: 0.9rem;
}

/* Gallery section styles */
.pet-gallery {
  padding: 60px 0;
}

.gallery-row {
  display: flex;
  flex-wrap: wrap;
  margin: -10px;
}

.gallery-item {
  flex: 0 0 calc(16.666% - 20px);
  margin: 10px;
}

.image-container {
  position: relative;
  overflow: hidden;
  aspect-ratio: 1/1;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.overlay i {
  color: #3498db; /* Đổi sang màu xanh */
  font-size: 2rem;
}

.gallery-item:hover .overlay {
  opacity: 1;
}

.gallery-item:hover img {
  transform: scale(1.1);
}

/* Responsive styles */
@media (max-width: 992px) {
  .feature-item {
    flex: 0 0 calc(50% - 20px);
  }
  
  .gallery-item {
    flex: 0 0 calc(33.333% - 20px);
  }
}

@media (max-width: 576px) {
  .feature-item {
    flex: 0 0 100%;
  }
  
  .gallery-item {
    flex: 0 0 calc(50% - 20px);
  }
}
</style>
<style>
    /* Global Styles */
    body {
        background-color: #f8f9fa;
    }
    
    /* Product Card Styles */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .product-img-container {
        height: 200px;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .card-img-top {
        height: 100%;
        object-fit: contain;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .card-title {
        font-size: 16px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #343a40;
        margin-bottom: 12px;
    }
    
    .product-info {
        font-size: 13px;
    }
    
    /* Form Controls */
    .form-select, .form-control {
        border: 1px solid #e0e0e0;
        font-size: 14px;
    }
    
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }
    
    /* Pagination */
    .pagination .page-link {
        color: #495057;
        padding: 0.5rem 0.75rem;
        font-size: 14px;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
    }
    
    /* Contact Buttons */
    .contact-buttons {
        z-index: 1000;
    }
    
    .contact-btn {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .contact-btn:hover {
        transform: scale(1.1);
    }
    
    .zalo-btn:hover {
        background-color: #0068ff;
    }
    
    .messenger-btn {
        background-color: #0084ff;
    }
    
    .phone-btn {
        background-color: #f44336;
    }
    
    /* Responsive Fixes */
    @media (max-width: 767px) {
        .product-img-container {
            height: 160px;
        }
        
        .contact-btn {
            width: 40px;
            height: 40px;
        }
    }
</style>

@include('footer')