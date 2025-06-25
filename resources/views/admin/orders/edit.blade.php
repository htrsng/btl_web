<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa đơn hàng</title>
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

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-control {
            border-color: #d1d3e2;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: darken(var(--primary-color), 10%);
            border-color: darken(var(--primary-color), 10%);
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
        <h1 class="text-center text-primary mb-4">Chỉnh sửa đơn hàng #{{ $order->id }}</h1>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger text-center mb-4">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thời gian giao dự kiến</label>
                        <input type="datetime-local" name="delivery_time" class="form-control" value="{{ $order->delivery_time ? (is_string($order->delivery_time) ? \Carbon\Carbon::parse($order->delivery_time)->format('Y-m-d\TH:i') : $order->delivery_time->format('Y-m-d\TH:i')) : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yêu cầu từ khách</label>
                        <textarea class="form-control" readonly>{{ $order->requirements ?? 'Không có yêu cầu' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phản hồi cho khách</label>
                        <textarea name="admin_reply" class="form-control" maxlength="1000" placeholder="Nhập phản hồi...">{{ $order->admin_reply ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>