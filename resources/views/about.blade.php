@include('header')

<section id="about" class="py-5">
  <div class="container">
    <!-- Phần Vì Sao Chọn Chúng Tôi? -->
    <div class="row align-items-center">
      <!-- Cột hình ảnh -->
      <div class="col-lg-5 mb-4 mb-lg-0 text-center">
        <!-- Thay đường dẫn ảnh tại src -->
        <img src="images/about-1.jpg" alt="Chú chó" class="img-fluid rounded-3">
      </div>
      <!-- Cột nội dung -->
      <div class="col-lg-7">
        <h2 class="fw-bold mb-4">Vì Sao Chọn Chúng Tôi?</h2>
        <div class="row gy-4">
          <!-- Dịch vụ 1 -->
          <div class="col-md-6 d-flex">
            <div class="me-3 text-success fs-2">
              <i class="fa-solid fa-heart"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-1">Tư Vấn Chăm Sóc</h5>
              <p class="mb-0 text-muted">Xa thật xa, phía sau những ngọn núi và đại dương.</p>
            </div>
          </div>
          <!-- Dịch vụ 2 -->
          <div class="col-md-6 d-flex">
            <div class="me-3 text-success fs-2">
              <i class="fa-solid fa-headset"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-1">Hỗ Trợ Khách Hàng</h5>
              <p class="mb-0 text-muted">Xa thật xa, phía sau những ngọn núi và đại dương.</p>
            </div>
          </div>
          <!-- Dịch vụ 3 -->
          <div class="col-md-6 d-flex">
            <div class="me-3 text-success fs-2">
              <i class="fa-solid fa-ambulance"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-1">Dịch Vụ Khẩn Cấp</h5>
              <p class="mb-0 text-muted">Xa thật xa, phía sau những ngọn núi và đại dương.</p>
            </div>
          </div>
          <!-- Dịch vụ 4 -->
          <div class="col-md-6 d-flex">
            <div class="me-3 text-success fs-2">
              <i class="fa-solid fa-stethoscope"></i>
            </div>
            <div>
              <h5 class="fw-bold mb-1">Hỗ Trợ Thú Y</h5>
              <p class="mb-0 text-muted">Xa thật xa, phía sau những ngọn núi và đại dương.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Phần thống kê (xanh lá) -->
  <div class="mt-5" style="background-color: #00a651;">
    <div class="container py-4">
      <div class="row text-white text-center">
        <div class="col-md-3 mb-3 mb-md-0">
          <h3 class="fw-bold display-6">50</h3>
          <p class="mb-0">Khách Hàng</p>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <h3 class="fw-bold display-6">8,500</h3>
          <p class="mb-0">Chuyên Gia</p>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <h3 class="fw-bold display-6">20</h3>
          <p class="mb-0">Sản Phẩm</p>
        </div>
        <div class="col-md-3">
          <h3 class="fw-bold display-6">50</h3>
          <p class="mb-0">Thú Cưng Đã Giải Cứu</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="faq" class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <!-- Cột trái: FAQ -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h2 class="fw-bold mb-3">Câu Hỏi Thường Gặp</h2>
        <p class="text-muted mb-4">
          Ở một nơi xa xôi, sau những dãy núi và đại dương, có những câu chuyện chưa được khám phá...
        </p>
        <div class="accordion" id="faqAccordion">
          <!-- Câu hỏi 1 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Làm thế nào để huấn luyện chó cưng?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Huấn luyện chó cần sự kiên nhẫn, nhất quán và khen thưởng đúng lúc. Bạn có thể tham khảo các khóa huấn luyện chuyên nghiệp hoặc áp dụng phương pháp clicker training.
              </div>
            </div>
          </div>
          <!-- Câu hỏi 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Cách quản lý thú cưng?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Hãy chuẩn bị môi trường sống an toàn, sạch sẽ và lịch trình ăn uống, vận động phù hợp. Ngoài ra, thường xuyên kiểm tra sức khỏe định kỳ cho thú cưng.
              </div>
            </div>
          </div>
          <!-- Câu hỏi 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Phương pháp chăm sóc lông tốt nhất cho thú cưng?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Tắm gội định kỳ, chải lông thường xuyên và sử dụng dầu gội chuyên dụng cho từng loại lông. Có thể kết hợp với spa thú cưng nếu cần.
              </div>
            </div>
          </div>
          <!-- Câu hỏi 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Điều kiện cần thiết để trông giữ thú cưng?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Chuẩn bị không gian đủ rộng, thức ăn, nước uống và đảm bảo an toàn. Đồng thời, theo dõi tình trạng sức khỏe của thú cưng để can thiệp kịp thời.
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Cột phải: Hình ảnh -->
      <div class="col-lg-6">
        <div class="position-relative mb-4">
          <!-- Ảnh chính -->
          <img src="images/about.jpg" alt="FAQ Main" class="img-fluid rounded-3 w-100">
          <!-- Icon play ở giữa ảnh -->
          <div class="position-absolute top-50 start-50 translate-middle">
            <a href="#" class="btn btn-light rounded-circle p-3 shadow">
              <i class="fa-solid fa-play text-primary fs-4"></i>
            </a>
          </div>
        </div>
        <!-- 2 Ảnh nhỏ bên dưới -->
        <div class="row g-3">
          <div class="col-6">
            <img src="images/about-2.jpg" alt="FAQ Image 1" class="img-fluid rounded-3 w-100">
          </div>
          <div class="col-6">
            <img src="images/about-3.jpg" alt="FAQ Image 2" class="img-fluid rounded-3 w-100">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@include('footer')
