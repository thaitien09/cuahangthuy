{{-- resources/views/admin/transactions/show.blade.php --}}
@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2>Chi tiết giao dịch</h2>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Thông tin giao dịch #{{ $transaction->id }}</h5>
            </div>
            <div class="card-body">
                <p><strong>ID người dùng:</strong> {{ $transaction->user_id }}</p>
                <p><strong>Tên người dùng:</strong> {{ $user->name }}</p>  {{-- Tên người dùng từ bảng users --}}
                <p><strong>Email người dùng:</strong> {{ $user->email }}</p>  {{-- Email người dùng từ bảng users --}}
                
                <p><strong>ID dịch vụ:</strong> {{ $transaction->service_id }}</p>
                <p><strong>Tên dịch vụ:</strong> {{ $service->name }}</p>  {{-- Tên dịch vụ từ bảng services --}}
                
                <p><strong>Số tiền:</strong> {{ number_format($transaction->amount) }}đ</p>
                <p><strong>Mã giao dịch:</strong> {{ $transaction->transaction_code }}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($transaction->status) }}</p>  {{-- Chuyển trạng thái thành chữ hoa đầu từ --}}
                <p><strong>Ngày tạo:</strong> {{ $transaction->created_at }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $transaction->updated_at }}</p>  {{-- Thêm ngày cập nhật giao dịch --}}
            </div>
        </div>

        <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary mt-3">Quay lại</a>
    </div>
@endsection
