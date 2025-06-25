<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0 !important;
            padding: 1rem 1.35rem;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-color: #dee2e6;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f0f1f4;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
        }

        .badge.bg-success { background-color: var(--success-color); }
        .badge.bg-warning { background-color: var(--warning-color); }
        .badge.bg-danger { background-color: var(--danger-color); }
        .badge.bg-info { background-color: var(--info-color); }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">
            <i class="fas fa-shopping-cart me-2"></i>Quản lý đơn hàng
        </h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Danh sách đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                                        <span class="badge @switch($order->status)
                                            @case('confirmed')
                                                bg-success
                                                @break
                                            @case('pending')
                                                bg-warning text-dark
                                                @break
                                            @case('canceled')
                                                bg-danger
                                                @break
                                            @case('completed')
                                                bg-info
                                                @break
                                            @default
                                                ''
                                        @endswitch">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        {{ $order->delivery_time ? \Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') : 'Chưa xác định' }}
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
                </div>
                @if ($orders->hasPages())
                    <div class="mt-4 text-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>