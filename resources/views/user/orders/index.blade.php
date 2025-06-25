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
            --light-gray: #f8f9fa;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-bottom: none;
        }

        .table-responsive {
            border-radius: 0 0 0.5rem 0.5rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-color: rgba(255,255,255,0.1);
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        .table tbody td {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
            border-color: rgba(0,0,0,0.05);
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35rem 0.65rem;
            font-weight: 500;
            border-radius: 0.25rem;
        }

        .badge-pending { 
            background-color: var(--warning-color);
            color: #000;
        }
        .badge-confirmed { 
            background-color: var(--success-color);
            color: #fff;
        }
        .badge-canceled { 
            background-color: var(--danger-color);
            color: #fff;
        }
        .badge-completed { 
            background-color: var(--info-color);
            color: #fff;
        }
        .badge-other { 
            background-color: #6c757d;
            color: #fff;
        }

        .btn-detail {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: white;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
        }

        .btn-detail:hover {
            background-color: #2a96a5;
            border-color: #2a96a5;
            color: white;
        }

        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            margin-top: 1rem;
        }

        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .alert-success {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .note-cell {
            max-width: 200px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <h1 class="page-title">Danh sách đơn hàng của bạn</h1>
            <a href="{{ route('user.dashboard') }}" class="btn btn-back">Quay lại</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif

        @if ($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cart-x" viewBox="0 0 16 16">
                        <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.5-2H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                </div>
                <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
                <p class="text-muted mt-2">Khi bạn đặt hàng, đơn hàng sẽ xuất hiện tại đây</p>
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Danh sách đơn hàng</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thời gian giao</th>
                                <th>Yêu cầu</th>
                                <th>Phản hồi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status }}">
                                            @if ($order->status == 'confirmed') Xác nhận
                                            @elseif ($order->status == 'pending') Chờ xử lý
                                            @elseif ($order->status == 'canceled') Đã hủy
                                            @elseif ($order->status == 'completed') Hoàn thành
                                            @else Khác
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        {{ $order->delivery_time ? (is_string($order->delivery_time) ? \Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') : $order->delivery_time->format('d/m/Y H:i')) : 'Chưa xác định' }}
                                    </td>
                                    <td class="note-cell">
                                        {{ $order->requirements ? nl2br(e($order->requirements)) : '-' }}
                                    </td>
                                    <td class="note-cell">
                                        {{ $order->admin_reply ? nl2br(e($order->admin_reply)) : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-detail">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>