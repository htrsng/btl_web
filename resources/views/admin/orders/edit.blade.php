<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Chỉnh sửa đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chỉnh sửa đơn hàng #{{ $order->id }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
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
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>