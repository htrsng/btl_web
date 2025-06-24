<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Bảng điều khiển - User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chào mừng, {{ Auth::user()->name }}!</h1>
        <p>Bạn đang ở trang bảng điều khiển dành cho người dùng.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm</h5>
                        <p class="card-text">Xem và mua các sản phẩm hoa tươi.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Xem sản phẩm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Giỏ hàng</h5>
                        <p class="card-text">Quản lý giỏ hàng của bạn.</p>
                        <a href="{{ route('cart.index') }}" class="btn btn-primary">Xem giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Đơn hàng</h5>
                        <p class="card-text">Xem lịch sử đơn hàng.</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-primary">Xem đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger mt-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>