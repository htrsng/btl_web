<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Bảng điều khiển Admin</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm</h5>
                        <p class="card-text">{{ \App\Models\Product::count() }} sản phẩm</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quản lý sản phẩm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Đơn hàng</h5>
                        <p class="card-text">{{ \App\Models\Order::count() }} đơn hàng</p>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Quản lý đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>