<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Danh sách đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Danh sách đơn hàng của bạn</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thời gian giao</th>
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
                                {{ $order->delivery_time ? $order->delivery_time->format('d/m/Y H:i') : 'Chưa xác định' }}
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-4">Quay lại</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
