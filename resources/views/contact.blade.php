@include('header')

<!-- Success notification -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
        <div class="container d-flex align-items-center">
            <i class="fa-solid fa-circle-check me-2"></i>
            <strong>{{ session('success') }}</strong>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Contact Hero Section with Background -->
<section class="py-5 bg-gradient">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-success mb-3">Liên Hệ Với Chúng Tôi</h1>
                <p class="lead mb-4">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn với mọi thắc mắc về thú cưng của bạn.</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form Card -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 shadow h-100">
                    <div class="card-header bg-success text-white py-3 border-0">
                        <h3 class="card-title fw-bold mb-0 fs-4">
                            <i class="fa-solid fa-paper-plane me-2"></i>Gửi Yêu Cầu Hỗ Trợ
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- User info card -->
                        <div class="mb-4 p-3 bg-light rounded-3">
                            @if (auth()->check())
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-success text-white me-3">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="mb-0"><strong>{{ auth()->user()->name }}</strong></p>
                                        <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-secondary text-white me-3">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0"><strong>Khách hàng</strong></p>
                                        <p class="mb-0 text-muted small">Bạn cần <a href="{{ route('login') }}" class="text-success">đăng nhập</a> để gửi yêu cầu hỗ trợ và theo dõi lịch sử liên hệ.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if (auth()->check())
                            <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <!-- Message Field -->
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa-solid fa-comment text-success"></i></span>
                                        <textarea class="form-control" id="message" name="message" rows="6" placeholder="Nhập nội dung tin nhắn của bạn..." required></textarea>
                                        <div class="invalid-feedback">Vui lòng nhập nội dung tin nhắn</div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fa-solid fa-paper-plane me-2"></i>Gửi Tin Nhắn
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div class="empty-state-icon mx-auto">
                                        <i class="fa-solid fa-lock text-muted"></i>
                                    </div>
                                </div>
                                <h5 class="fw-semibold mb-3">Đăng nhập để gửi yêu cầu</h5>
                                <p class="text-muted mb-4">Bạn cần đăng nhập để có thể gửi yêu cầu hỗ trợ và theo dõi lịch sử liên hệ của mình.</p>
                                <a href="{{ route('login') }}" class="btn btn-success">
                                    <i class="fa-solid fa-sign-in-alt me-2"></i>Đăng nhập ngay
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact History for logged in users -->
            <div class="col-lg-6">
                <div class="card border-0 shadow h-100">
                    <div class="card-header bg-success text-white py-3 border-0">
                        <h3 class="card-title fw-bold mb-0 fs-4">
                            <i class="fa-solid fa-history me-2"></i>Lịch Sử Liên Hệ
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        @if (auth()->check())
                            @php
                                $contacts = DB::table('contacts')
                                    ->where('user_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp
                            
                            @if ($contacts->isEmpty())
                                <div class="text-center py-3">
                                    <div class="mb-4">
                                        <div class="empty-state-icon mx-auto">
                                            <i class="fa-solid fa-inbox text-muted"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-semibold mb-2">Chưa có lịch sử liên hệ</h5>
                                    <p class="text-muted">Bạn chưa gửi yêu cầu liên hệ nào trước đây.</p>
                                </div>
                            @else
                                <div class="contact-history mb-4">
                                    @foreach ($contacts as $contact)
                                        <div class="contact-item mb-3">
                                            <div class="card border">
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                                                    <span class="fw-semibold">Yêu cầu hỗ trợ</span>
                                                    @if ($contact->status == 'Chưa xử lý')
                                                        <span class="badge bg-warning text-dark">Chưa xử lý</span>
                                                    @elseif ($contact->status == 'Đang xử lý')
                                                        <span class="badge bg-info">Đang xử lý</span>
                                                    @else
                                                        <span class="badge bg-success">Đã xử lý</span>
                                                    @endif
                                                </div>
                                                <div class="card-body py-3">
                                                    <p class="mb-2">{{ $contact->message }}</p>
                                                    <small class="text-muted d-block text-end">
                                                        <i class="fa-regular fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y - H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div class="empty-state-icon mx-auto">
                                        <i class="fa-solid fa-history text-muted"></i>
                                    </div>
                                </div>
                                <h5 class="fw-semibold mb-3">Lịch sử liên hệ</h5>
                                <p class="text-muted mb-4">Đăng nhập để xem lịch sử liên hệ và theo dõi trạng thái xử lý yêu cầu của bạn.</p>
                               
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Contact Us Section with Modern Design -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Tại Sao Liên Hệ Với Chúng Tôi?</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 hover-card">
                    <div class="text-center mb-4">
                        <div class="feature-icon bg-success text-white mx-auto">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="fw-bold mb-3">Hỗ Trợ Nhanh Chóng</h4>
                        <p class="text-muted mb-0">Đội ngũ hỗ trợ luôn sẵn sàng 24/7 để giải đáp mọi thắc mắc của bạn.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 hover-card">
                    <div class="text-center mb-4">
                        <div class="feature-icon bg-success text-white mx-auto">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="fw-bold mb-3">Tận Tâm Với Khách Hàng</h4>
                        <p class="text-muted mb-0">Chúng tôi đặt sự hài lòng của bạn lên hàng đầu và cam kết mang đến trải nghiệm tốt nhất.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 hover-card">
                    <div class="text-center mb-4">
                        <div class="feature-icon bg-success text-white mx-auto">
                            <i class="fa-solid fa-shield-alt"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="fw-bold mb-3">Đáng Tin Cậy</h4>
                        <p class="text-muted mb-0">Với kinh nghiệm nhiều năm, chúng tôi tự hào là đối tác đáng tin cậy cho mọi nhu cầu về thú cưng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section - Modern Accordions -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Câu Hỏi Thường Gặp</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-semibold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Làm thế nào để theo dõi đơn hàng?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể theo dõi đơn hàng bằng cách đăng nhập vào tài khoản và vào mục "Đơn hàng của tôi". Tại đây bạn sẽ thấy trạng thái và thông tin cập nhật mới nhất về đơn hàng.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-semibold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Chính sách đổi trả hàng như thế nào?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi chấp nhận đổi trả sản phẩm trong vòng 7 ngày kể từ ngày nhận hàng. Sản phẩm cần được giữ nguyên tem, nhãn, hộp và không có dấu hiệu đã qua sử dụng.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-semibold rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Phí vận chuyển được tính như thế nào?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Phí vận chuyển được tính dựa trên khoảng cách, trọng lượng và kích thước của sản phẩm. Đơn hàng trên 500.000đ sẽ được miễn phí vận chuyển trong nội thành.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section - Moved here and visible to all users -->
<section class="py-5 bg-gradient">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Thông Tin Liên Hệ</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 mb-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="contact-item d-flex align-items-center p-3 border rounded bg-white shadow-sm mb-3 hover-card">
                            <div class="contact-icon bg-success-light text-success rounded-circle me-3">
                                <i class="fa-solid fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Địa chỉ</h5>
                                <p class="mb-0 text-muted">123 Đường Thú Cưng, TP. Hồ Chí Minh</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="contact-item d-flex align-items-center p-3 border rounded bg-white shadow-sm mb-3 hover-card">
                            <div class="contact-icon bg-success-light text-success rounded-circle me-3">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Hotline</h5>
                                <p class="mb-0 text-muted">0912 345 678</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="contact-item d-flex align-items-center p-3 border rounded bg-white shadow-sm mb-3 hover-card">
                            <div class="contact-icon bg-success-light text-success rounded-circle me-3">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Email</h5>
                                <p class="mb-0 text-muted">support@thucung.vn</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="contact-item d-flex align-items-center p-3 border rounded bg-white shadow-sm mb-3 hover-card">
                            <div class="contact-icon bg-success-light text-success rounded-circle me-3">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Giờ làm việc</h5>
                                <p class="mb-0 text-muted">Thứ 2 - Thứ 6: 8:00 - 17:30<br>Thứ 7: 8:00 - 12:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674197897!2d106.68800061535335!3d10.77148736221999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3ae35e3725%3A0x20c383376eaf8ac!2zMTIzIMSQxrDhu51uZyBUcuG6p24gSMawbmcgxJDhuqFvLCBQaMaw4budbmcgQsOsbmggVGjhuqFuaCwgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1652345678901!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS for custom elements -->
<style>
    .bg-gradient {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.05) 0%, rgba(25, 135, 84, 0.1) 100%);
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .contact-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: rgba(25, 135, 84, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .contact-history {
        max-height: 500px;
        overflow-y: auto;
        scrollbar-width: thin;
    }
    
    .contact-history::-webkit-scrollbar {
        width: 5px;
    }
    
    .contact-history::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .contact-history::-webkit-scrollbar-thumb {
        background: #198754;
        border-radius: 10px;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }
</style>
<style>
    /* ... existing styles ... */
    
    @media (min-width: 768px) {
        .contact-item {
            min-height: 100px;
        }
    }
    
    @media (min-width: 992px) {
        .contact-item {
            min-height: 120px;
        }
    }
</style>
@include('footer')