<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Tạo đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tạo đơn hàng</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <h4>Danh sách sản phẩm trong giỏ hàng</h4>
        @if ($cartItems->isEmpty())
            <p>Giỏ hàng trống.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->product->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->quantity * $item->product->price, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</strong></p>
        @endif
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
            <a href="{{ route('cart.index') }}" class="btn btn-secondary">Quay lại giỏ hàng</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>