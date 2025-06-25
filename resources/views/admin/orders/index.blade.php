<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="dashboard-header">
            <h1 class="h3 mb-0"><i class="fas fa-shopping-cart me-2"></i>Quản lý đơn hàng</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Tên</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thời gian giao</th>
                        <th>Ghi chú (Yêu cầu)</th>
                        <th>Phản hồi từ Admin</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Không rõ' }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <span class="badge" :class="{
                                    'bg-success': $order->status == 'confirmed',
                                    'bg-warning text-dark': $order->status == 'pending',
                                    'bg-danger': $order->status == 'canceled',
                                    'bg-info': $order->status == 'completed'
                                }">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                {{ $order->delivery_time ? (\Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') ?? 'Chưa xác định') : 'Chưa xác định' }}
                            </td>
                            <td>
                                {{ $order->requirements ? nl2br(e($order->requirements)) : 'Không có yêu cầu' }}
                            </td>
                            <td>
                                {{ $order->admin_reply ? nl2br(e($order->admin_reply)) : 'Chưa có phản hồi' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($orders->hasPages())
                <div class="mt-4">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>