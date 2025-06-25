<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .badge.bg-secondary { background-color: #6c757d; }

        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }

        .btn-info:hover {
            background-color: darken(var(--info-color), 10%);
            border-color: darken(var(--info-color), 10%);
        }

        .btn-secondary {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: darken(var(--info-color), 10%);
            border-color: darken(var(--info-color), 10%);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Danh sách đơn hàng của bạn</h1>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif

        @if ($orders->isEmpty())
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Danh sách đơn hàng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian giao</th>
                                    <th>Ghi chú (Yêu cầu)</th>
                                    <th>Phản hồi từ Admin</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                        <td>
                                            <span class="badge 
                                                @if ($order->status == 'confirmed') bg-success 
                                                @elseif ($order->status == 'pending') bg-warning text-dark 
                                                @elseif ($order->status == 'canceled') bg-danger 
                                                @elseif ($order->status == 'completed') bg-info 
                                                @else bg-secondary 
                                                @endif
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $order->delivery_time ? (is_string($order->delivery_time) ? \Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') : $order->delivery_time->format('d/m/Y H:i')) : 'Chưa xác định' }}
                                        </td>
                                        <td>
                                            {{ $order->requirements ? nl2br(e($order->requirements)) : 'Không có yêu cầu' }}
                                        </td>
                                        <td>
                                            {{ $order->admin_reply ? nl2br(e($order->admin_reply)) : 'Chưa có phản hồi' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>