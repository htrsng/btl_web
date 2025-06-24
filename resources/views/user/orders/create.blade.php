<!DOCTYPE html>
<html>
<head>
    <title>Đặt Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Đặt Hàng</h1>
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
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên Người Nhận</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa Chỉ</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>
            <h4>Danh Sách Sản Phẩm</h4>
            @if ($cartItems->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Chưa có' }}</td>
                                <td>{{ number_format($item->product->price ?? 0, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><strong>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</strong></p>
                <button type="submit" class="btn btn-primary">Xác Nhận Đặt Hàng</button>
            @else
                <p>Giỏ hàng trống. Vui lòng thêm sản phẩm trước.</p>
            @endif
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>