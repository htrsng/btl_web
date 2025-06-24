<!DOCTYPE html>
<html>
<head>
    <title>Chi Tiết Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>Tên Người Nhận:</th>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <th>Địa Chỉ:</th>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <th>Số Điện Thoại:</th>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <th>Tổng Tiền:</th>
                <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Trạng Thái:</th>
                <td>{{ $order->status ?? 'Chưa cập nhật' }}</td>
            </tr>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
