@include('header')

@php
    $user = Auth::user();
@endphp

<form action="{{ route('order.place.submit') }}" method="POST" id="orderForm" class="py-4 bg-light">
  @csrf
  <div class="container bg-white p-4 rounded shadow">
    <div class="row">
      <!-- Cột trái: Địa chỉ giao hàng, Thông tin thêm -->
      <div class="col-md-6">
        <h2 class="mb-4">Địa chỉ giao hàng</h2>
        <div class="mb-3">
          <label for="name" class="form-label fw-bold">Họ và tên *</label>
          <input type="text" name="name" id="name" placeholder="Nhập họ và tên" class="form-control text-dark" 
                 value="{{ old('name', $user->name ?? '') }}" readonly style="background-color: #e9ecef;">
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="phone" class="form-label fw-bold">Số điện thoại *</label>
            <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" class="form-control text-dark" 
                   value="{{ old('phone', $user->phone ?? '') }}" readonly style="background-color: #e9ecef;">
          </div>
          <div class="col">
            <label for="email" class="form-label fw-bold">Địa chỉ email *</label>
            <input type="email" name="email" id="email" placeholder="Nhập email" class="form-control text-dark" 
                   value="{{ old('email', $user->email ?? '') }}" readonly style="background-color: #e9ecef;">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="province" class="form-label fw-bold">Tỉnh / Thành phố *</label>
            <select name="province" id="province" class="form-select" required>
              <option value="">Chọn tỉnh / thành phố</option>
              <!-- Options load từ JS -->
            </select>
          </div>
          <div class="col">
            <label for="district" class="form-label fw-bold">Quận / Huyện *</label>
            <select name="district" id="district" class="form-select" required>
              <option value="">Chọn quận / huyện</option>
              <!-- Options load từ JS -->
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="ward" class="form-label fw-bold">Phường / Xã *</label>
          <select name="ward" id="ward" class="form-select" required>
            <option value="">Chọn phường / xã</option>
            <!-- Options load từ JS -->
          </select>
        </div>
        <div class="mb-3">
          <label for="address_detail" class="form-label fw-bold">Địa chỉ cụ thể *</label>
          <input type="text" name="address_detail" id="address_detail" placeholder="Nhập địa chỉ cụ thể" class="form-control" required>
        </div>
        <h2 class="mb-4">Thông tin thêm</h2>
        <div class="mb-4">
          <label for="order_notes" class="form-label fw-bold">Lưu ý cho đơn hàng (tùy chọn)</label>
          <textarea name="order_notes" id="order_notes" rows="4" placeholder="Viết các lưu ý cho đơn hàng của bạn..." class="form-control"></textarea>
        </div>
      </div>

      <!-- Cột phải: Tóm tắt đơn hàng & Chính sách bán hàng -->
      <div class="col-md-6">
        <h2 class="mb-4">Tóm tắt đơn hàng</h2>
        <div class="border p-3 mb-4">
          <div class="d-flex justify-content-between mb-2">
            <span class="fw-semibold">Thành tiền</span>
            <span class="fw-bold">
              {{ number_format($carts->sum(fn($cart) => $cart->sale_price * $cart->quantity), 0, ',', '.') }}₫
            </span>
          </div>
          <!-- Phần chỉnh sửa: Thay Hình thức vận chuyển thành Phí vận chuyển và miễn phí -->
          <div class="d-flex justify-content-between mb-2">
            <span class="fw-semibold">Phí vận chuyển</span>
            <span class="fw-bold text-success">Miễn phí</span>
            <input type="hidden" name="shipping" value="free">
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="fw-semibold">Tổng cộng</span>
            <span class="fw-bold">
              {{ number_format($carts->sum(fn($cart) => $cart->sale_price * $cart->quantity), 0, ',', '.') }}₫
            </span>
          </div>
          <div class="border-top pt-3">
            <div class="d-flex align-items-center mb-3">
              <span class="fw-semibold me-2">Sản phẩm</span>
              <span class="badge bg-danger">
                {{ $carts->count() }}
              </span>
            </div>
            @foreach($carts as $cart)
              <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('images/'.$cart->image) }}" alt="{{ $cart->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                <div class="ms-2">
                  <p class="mb-0 fw-bold">{{ $cart->name }}</p>
                  <small class="text-muted">x {{ $cart->quantity }}</small>
                </div>
                <div class="ms-auto fw-bold">
                  {{ number_format($cart->sale_price * $cart->quantity, 0, ',', '.') }}₫
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <h2 class="mb-4">Chính sách bán hàng</h2>
        <div class="border p-3 mb-4" style="height: 200px; overflow-y: auto;">
          <h3 class="fw-semibold mb-2">1. Thanh toán</h3>
          <p class="text-muted small mb-2">
            Chúng tôi chấp nhận thanh toán qua thẻ tín dụng, chuyển khoản ngân hàng hoặc thanh toán khi nhận hàng. 
            Tất cả giao dịch đều được thực hiện an toàn và bảo mật.
          </p>
          <p class="text-muted small mb-2">
            - Nếu thanh toán trực tuyến, vui lòng đảm bảo thông tin thẻ của quý khách chính xác và còn hiệu lực.
          </p>
          <p class="text-muted small mb-2">
            - Đối với thanh toán khi nhận hàng, nhân viên giao hàng sẽ liên hệ xác nhận thời gian giao hàng trước.
          </p>

          <h3 class="fw-semibold mb-2">2. Giao hàng</h3>
          <p class="text-muted small mb-2">
            Chúng tôi cam kết giao hàng trong vòng 3-5 ngày làm việc. Nếu có sự chậm trễ, khách hàng sẽ được thông báo kịp thời.
          </p>

          <h3 class="fw-semibold mb-2">3. Đổi trả và Bảo hành</h3>
          <p class="text-muted small mb-2">
            Quý khách có thể đổi trả sản phẩm nếu sản phẩm bị lỗi do nhà sản xuất trong vòng 7 ngày kể từ ngày nhận hàng. 
            Sản phẩm đổi trả phải còn nguyên vẹn, chưa qua sử dụng và đầy đủ phụ kiện.
          </p>
          <p class="text-muted small mb-2">
            Thời gian bảo hành cụ thể sẽ được thông báo tùy theo loại sản phẩm và theo chính sách của nhà sản xuất.
          </p>

          <h3 class="fw-semibold mb-2">4. Chính sách bảo mật</h3>
          <p class="text-muted small mb-2">
            Thông tin cá nhân của quý khách được bảo mật tuyệt đối và chỉ sử dụng cho mục đích xử lý đơn hàng, giao dịch và chăm sóc khách hàng.
          </p>
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" id="terms" name="terms" type="checkbox" required>
          <label for="terms" class="form-check-label">
            Tôi đã đọc, hiểu và đồng ý với toàn bộ chính sách bán hàng, bao gồm các điều khoản về thanh toán, giao hàng, đổi trả, bảo hành và bảo mật.
          </label>
        </div>

        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold">
          Đặt mua
        </button>
      </div>
    </div>
  </div>
</form>

<!-- Script load Tỉnh/Quận/Phường (không đổi) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $.get("https://provinces.open-api.vn/api/?depth=3", function (data) {
      data.forEach(function(province) {
        $('#province').append(`<option value="${province.code}">${province.name}</option>`);
      });
    });

    $('#province').change(function () {
      let provinceCode = $(this).val();
      $('#district').html('<option value="">Chọn quận / huyện</option>');
      $('#ward').html('<option value="">Chọn phường / xã</option>');

      if (provinceCode) {
        $.get(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`, function (data) {
          data.districts.forEach(function(district) {
            $('#district').append(`<option value="${district.code}">${district.name}</option>`);
          });
        });
      }
    });

    $('#district').change(function () {
      let districtCode = $(this).val();
      $('#ward').html('<option value="">Chọn phường / xã</option>');

      if (districtCode) {
        $.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`, function (data) {
          data.wards.forEach(function(ward) {
            $('#ward').append(`<option value="${ward.code}">${ward.name}</option>`);
          });
        });
      }
    });
  });
</script>


@include('footer')
