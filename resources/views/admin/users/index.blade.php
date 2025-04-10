@extends('layout')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="container py-4">
    <!-- Header with Stats -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h1 class="fw-bold text-primary mb-0">Danh sách người dùng</h1>
        <div class="d-flex gap-3 flex-wrap">
            <div class="card bg-primary text-white">
                <div class="card-body p-3">
                    <h6 class="mb-1">Tổng nhân viên</h6>
                    <h2 class="mb-0">{{ $totalStaff }}</h2>
                </div>
            </div>
            <div class="card bg-success text-white">
                <div class="card-body p-3">
                    <h6 class="mb-1">Tổng khách hàng</h6>
                    <h2 class="mb-0">{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Quick Actions Row -->
    <div class="row mb-4">
        <!-- Filter Form -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter text-primary me-2"></i>Bộ lọc
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('users.index') }}" class="mb-0">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="role" class="form-label">Quyền người dùng</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Tìm kiếm</label>
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="Tên người dùng" value="{{ request('name') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <a href="{{ route('users.create') }}" class="btn btn-success w-100">
                                    <i class="fas fa-plus-circle me-1"></i>Thêm người dùng
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-users text-primary me-2"></i>Quản lý người dùng
            </h5>
            <span class="badge bg-primary">{{ $users->total() }} kết quả</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" width="5%">ID</th>
                            <th width="8%">Ảnh đại diện</th>
                            <th width="25%">Tên</th>
                            <th width="30%">Email</th>
                            <th width="12%">Quyền</th>
                            <th class="text-end pe-3" width="20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="ps-3">{{ $user->id }}</td>
                                <td>
                                    <img src="{{ asset('/images/' . $user->avatar) }}" alt="Avatar" 
                                         class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td class="fw-medium">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger">Quản trị viên</span>
                                    @elseif($user->role == 'staff')
                                        <span class="badge bg-info">Nhân viên</span>
                                    @else
                                        <span class="badge bg-secondary">Người dùng</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info btn-sm me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-search me-2"></i>Không tìm thấy người dùng nào
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị {{ $users->firstItem() ?? 0 }} đến {{ $users->lastItem() ?? 0 }} của {{ $users->total() }} người dùng
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom styles */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .card {
        border-radius: 0.75rem;
        border: none;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }
    
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .btn-group .btn {
        border-radius: 0.25rem;
        margin-right: 0.25rem;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    @media (max-width: 767.98px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Đảm bảo bạn đã thêm Font Awesome vào layout chính
    // Nếu chưa, thêm dòng này vào layout của bạn:
    // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</script>
@endsection