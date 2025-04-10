@extends('layout') {{-- Nếu bạn dùng layout khác thì sửa lại tên --}}

@section('content')
    <div class="container mt-4">
        <h2>Quản lý giao dịch</h2>

        {{-- Thông báo khi cập nhật thành công --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Service ID</th>
                    <th>Số tiền</th>
                    <th>Mã giao dịch</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicePurchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->user_id }}</td>
                        <td>{{ $purchase->service_id }}</td>
                        <td>{{ number_format($purchase->amount) }}đ</td>
                        <td>{{ $purchase->transaction_code }}</td>
                        
                        {{-- Form cập nhật trạng thái --}}
                        <td>
                        <form action="{{ route('admin.transactions.updateStatus', $purchase->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="Chờ xử lý" {{ $purchase->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
        <option value="Hoàn tất" {{ $purchase->status == 'Hoàn tất' ? 'selected' : '' }}>Hoàn tất</option>
        <option value="Thất bại" {{ $purchase->status == 'Thất bại' ? 'selected' : '' }}>Thất bại</option>
    </select>
</form>

                        </td>

                        <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d-m-Y H:i') }}</td>

                        {{-- Các nút thao tác (nếu cần thêm chức năng sau) --}}
                        <td>
                        <a href="{{ route('admin.transactions.show', $purchase->id) }}" class="btn btn-info btn-sm">Xem</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
