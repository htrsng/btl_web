<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
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

        .detail-row {
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #e3e6f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .detail-value {
            color: #6e707e;
        }

        .detail-value.text-success {
            color: var(--success-color);
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
        <h1 class="text-center text-primary mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

        @if (session('error'))
            <div class="alert alert-danger text-center mb-4">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">Ngày đặt:</span>
                    <span class="detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tổng tiền:</span>
                    <span class="detail-value text-success">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Trạng thái:</span>
                    <span class="detail-value">{{ $order->status }}</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>