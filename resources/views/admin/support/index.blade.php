@extends('layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Quản lý Hỗ trợ & Phản hồi</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
           
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Thời gian gửi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
               
                <td>{{ $contact->message }}</td>
                <td>
                    <select class="update-status" data-id="{{ $contact->id }}">
                        <option value="Chưa xử lý" {{ $contact->status == 'Chưa xử lý' ? 'selected' : '' }}>Chưa xử lý</option>
                        <option value="Đang xử lý" {{ $contact->status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="Đã xử lý" {{ $contact->status == 'Đã xử lý' ? 'selected' : '' }}>Đã xử lý</option>
                    </select>
                </td>
                <td>{{ $contact->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="statusToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Thông báo</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
            Cập nhật trạng thái thành công!
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.update-status').change(function() {
        var contactId = $(this).data('id');
        var newStatus = $(this).val();

        $.ajax({
            url: "{{ route('admin.support.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: contactId,
                status: newStatus
            },
            success: function(response) {
                $('#toastBody').text(response.message);  // Cập nhật nội dung của toast
                var toast = new bootstrap.Toast($('#statusToast')[0]);
                toast.show();
            },
            error: function() {
                $('#toastBody').text('Cập nhật trạng thái thất bại!');  // Thông báo lỗi
                var toast = new bootstrap.Toast($('#statusToast')[0]);
                toast.show();
            }
        });
    });
});
</script>
@endsection
