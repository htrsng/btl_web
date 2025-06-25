<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Xác nhận đơn hàng #{{ $order->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="delivery_time" class="form-label">Thời gian giao dự kiến</label>
                <input type="datetime-local" name="delivery_time" id="delivery_time" class="form-control"
                       value="{{ old('delivery_time', $order->delivery_time ? $order->delivery_time->format('Y-m-d\TH:i') : '') }}">
            </div>

            <button type="submit" class="btn btn-primary">Xác nhận</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
