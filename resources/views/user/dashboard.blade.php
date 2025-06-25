<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển - {{ Auth::user()->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df; /* Đổi màu chính sang xanh dương của admin */
            --secondary-color: #f8f9fc; /* Màu phụ của admin */
            --text-color: #333;
            --light-text: #888;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }
        
        .user-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-radius: 0 0 10px 10px;
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }
        
        .quick-menu {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); /* Shadow giống admin */
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .quick-menu-item {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .quick-menu-item:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }
        
        .quick-menu-icon {
            font-size: 24px;
            color: var(--primary-color); /* Màu icon theo primary mới */
            margin-bottom: 8px;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); /* Shadow giống admin */
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        
        .product-price {
            color: var(--primary-color); /* Màu giá theo primary mới */
            font-weight: bold;
        }
        
        .logout-btn {
            background-color: white;
            color: var(--primary-color); /* Màu chữ theo primary mới */
            border: 1px solid var(--primary-color); /* Viền theo primary mới */
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 500;
        }
        
        .logout-btn:hover {
            background-color: var(--primary-color); /* Nền khi hover theo primary mới */
            color: white;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color); /* Gạch chân theo primary mới */
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Phần header thông tin user -->
    <header class="user-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://via.placeholder.com/150" alt="Avatar" class="user-avatar me-3">
                    <div>
                        <h5 class="mb-1">Xin chào, {{ Auth::user()->name }}</h5>
                        <small class="d-block opacity-75">Thành viên từ {{ Auth::user()->created_at->format('d/m/Y') }}</small>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Menu chức năng nhanh -->
        <div class="quick-menu">
            <div class="row text-center">
                <div class="col-4">
                    <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                        <div class="quick-menu-item">
                            <div class="quick-menu-icon">
                                <i class="bi bi-flower1"></i>
                            </div>
                            <div>Sản phẩm</div>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">
                        <div class="quick-menu-item">
                            <div class="quick-menu-icon">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div>Giỏ hàng</div>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                        <div class="quick-menu-item">
                            <div class="quick-menu-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>Đơn hàng</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>