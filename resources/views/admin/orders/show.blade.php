<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
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

        .btn-back {
            background-color: var(--info-color);
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: darken(var(--info-color), 10%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center mb-4">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">Tên Người Nhận:</span>
                    <span class="detail-value">{{ $order->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Địa Chỉ:</span>
                    <span class="detail-value">{{ $order->address }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Số Điện Thoại:</span>
                    <span class="detail-value">{{ $order->phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tổng Tiền:</span>
                    <span class="detail-value text-success">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Trạng Thái:</span>
                    <span class="detail-value text-info">{{ $order->status ?? 'Chưa cập nhật' }}</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-back btn-lg">Quay lại danh sách đơn hàng</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>