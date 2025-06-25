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
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 0.5rem rgba(58, 59, 69, 0.1);
            border: none;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .table thead th {
            background-color: #f1f5fd;
            color: #2d3436;
            font-weight: 600;
            border-bottom: 2px solid #e0e6f5;
            padding: 0.75rem 1rem;
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.03);
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            border-radius: 4px;
            font-weight: 500;
        }

        .badge.bg-success { background-color: var(--success-color); }
        .badge.bg-warning { background-color: var(--warning-color); color: #2d3436; }
        .badge.bg-danger { background-color: var(--danger-color); }
        .badge.bg-info { background-color: var(--info-color); }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: 4px;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
            color: #636e72;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #b2bec3;
            margin-bottom: 0.5rem;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="page-title">
            <i class="fas fa-clipboard-list me-2"></i>Quản lý đơn hàng
        </h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Danh sách đơn hàng</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 15%;">Khách hàng</th>
                                <th style="width: 12%;">Tên</th>
                                <th style="width: 10%;">Tổng tiền</th>
                                <th style="width: 10%;">Trạng thái</th>
                                <th style="width: 12%;">Thời gian giao</th>
                                <th style="width: 18%;">Yêu cầu</th>
                                <th style="width: 18%;">Phản hồi</th>
                                <th style="width: 10%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Khách' }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                                    <td>
                                        <span class="badge @switch($order->status)
                                            @case('confirmed')
                                                bg-success
                                                @break
                                            @case('pending')
                                                bg-warning
                                                @break
                                            @case('canceled')
                                                bg-danger
                                                @break
                                            @case('completed')
                                                bg-info
                                                @break
                                            @default
                                                bg-secondary
                                        @endswitch">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $order->delivery_time ? \Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') : 'Chưa xác định' }}
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            {{ $order->requirements ?: 'Không có' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            {{ $order->admin_reply ?: 'Chưa có' }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open"></i>
                                            <h5 class="mt-2">Không có đơn hàng nào</h5>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($orders->hasPages())
                    <div class="p-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>