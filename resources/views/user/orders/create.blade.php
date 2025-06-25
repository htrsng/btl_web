<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
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
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-bottom: none;
        }

        .form-label {
            font-weight: 600;
            color: #5a5c69;
        }

        .form-control {
            border-radius: 0.35rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #3a5bc7;
            border-color: #3a5bc7;
        }

        .alert {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .table {
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-color: rgba(255,255,255,0.1);
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        .table tbody td {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
            border-color: rgba(0,0,0,0.05);
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .total-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .empty-cart {
            padding: 2rem;
            text-align: center;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
        }

        .empty-cart-icon {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <h1 class="page-title">Đặt hàng</h1>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Thông tin giao hàng</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Tên người nhận</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="requirements" class="form-label">Yêu cầu thêm (tùy chọn)</label>
                            <textarea name="requirements" id="requirements" class="form-control" rows="3" maxlength="500" placeholder="Nhập yêu cầu của bạn...">{{ old('requirements') }}</textarea>
                            <small class="text-muted">Tối đa 500 ký tự</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Danh sách sản phẩm</h4>
                </div>
                <div class="card-body">
                    @if ($cartItems->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                                            <td>{{ number_format($item->product->price ?? 0, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <p class="total-price">Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</p>
                            <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
                        </div>
                    @else
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cart-x" viewBox="0 0 16 16">
                                    <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.5-2H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                            </div>
                            <h5 class="text-muted">Giỏ hàng trống</h5>
                            <p class="text-muted mt-2">Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng</p>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>