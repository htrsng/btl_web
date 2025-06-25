<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ $order->id }}</title>
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
            line-height: 1.6;
        }

        .page-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
        }

        .order-id {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            border-bottom: none;
        }

        .detail-row {
            display: flex;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row:nth-child(even) {
            background-color: var(--light-gray);
        }

        .detail-label {
            flex: 0 0 180px;
            font-weight: 600;
            color: #5a5c69;
        }

        .detail-value {
            flex: 1;
            color: #6e707e;
        }

        .detail-value.text-success {
            color: var(--success-color);
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: capitalize;
        }

        .status-pending { background-color: var(--warning-color); color: #000; }
        .status-confirmed { background-color: var(--success-color); color: #fff; }
        .status-canceled { background-color: var(--danger-color); color: #fff; }
        .status-completed { background-color: var(--info-color); color: #fff; }

        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.6rem 1.75rem;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 0.3rem;
            margin-top: 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-1px);
        }

        .alert-danger {
            border-radius: 0.5rem;
            font-weight: 500;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 576px) {
            .detail-row {
                flex-direction: column;
                padding: 1rem;
            }
            .detail-label {
                flex: 1;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="page-header">
            <h1 class="page-title">Chi tiết đơn hàng</h1>
            <div class="order-id">Mã đơn hàng: #{{ $order->id }}</div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger text-center mb-4">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <div class="detail-label">Ngày đặt hàng:</div>
                    <div class="detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tổng giá trị:</div>
                    <div class="detail-value text-success">{{ number_format($order->total, 0, ',', '.') }} VNĐ</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Trạng thái:</div>
                    <div class="detail-value">
                        <span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span>
                    </div>
                </div>
                @if($order->delivery_time)
                <div class="detail-row">
                    <div class="detail-label">Thời gian giao:</div>
                    <div class="detail-value">
                        {{ is_string($order->delivery_time) ? \Carbon\Carbon::parse($order->delivery_time)->format('d/m/Y H:i') : $order->delivery_time->format('d/m/Y H:i') }}
                    </div>
                </div>
                @endif
                @if($order->requirements)
                <div class="detail-row">
                    <div class="detail-label">Yêu cầu:</div>
                    <div class="detail-value">{{ $order->requirements }}</div>
                </div>
                @endif
                @if($order->admin_reply)
                <div class="detail-row">
                    <div class="detail-label">Phản hồi từ quản trị:</div>
                    <div class="detail-value">{{ $order->admin_reply }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('orders.index') }}" class="btn btn-back">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>