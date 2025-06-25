<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Hệ thống quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0 !important;
            padding: 1rem 1.35rem;
        }
        
        .card-product {
            border-left: 0.25rem solid var(--primary-color);
        }
        
        .card-order {
            border-left: 0.25rem solid var(--success-color);
        }
        
        .card-user {
            border-left: 0.25rem solid var(--info-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .dashboard-title {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }
        
        .stat-icon {
            font-size: 2rem;
            opacity: 0.7;
        }
        
        .stat-count {
            font-size: 1.75rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="dashboard-title">
                <i class="bi bi-speedometer2 me-2"></i>Bảng điều khiển Admin
            </h1>
            <div class="text-muted">
                <i class="bi bi-calendar me-1"></i> 
                <span id="current-date"></span>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Sản phẩm Card -->
            <div class="col-xl-4 col-md-6">
                <div class="card card-product h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title text-uppercase text-primary mb-2">
                                    <i class="bi bi-box-seam me-2"></i>Sản phẩm
                                </h5>
                                <p class="stat-count mb-0">{{ \App\Models\Product::count() }}</p>
                                <p class="text-muted mb-0">Tổng số sản phẩm</p>
                            </div>
                            <div class="col-4 text-end">
                                <i class="bi bi-box-seam stat-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary stretched-link">
                            Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Đơn hàng Card -->
            <div class="col-xl-4 col-md-6">
                <div class="card card-order h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title text-uppercase text-success mb-2">
                                    <i class="bi bi-cart-check me-2"></i>Đơn hàng
                                </h5>
                                <p class="stat-count mb-0">{{ \App\Models\Order::count() }}</p>
                                <p class="text-muted mb-0">Tổng số đơn hàng</p>
                            </div>
                            <div class="col-4 text-end">
                                <i class="bi bi-cart-check stat-icon text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-success stretched-link">
                            Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Thêm card thống kê khác nếu cần -->
            <div class="col-xl-4 col-md-6">
                <div class="card card-user h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title text-uppercase text-info mb-2">
                                    <i class="bi bi-people me-2"></i>Người dùng
                                </h5>
                                <p class="stat-count mb-0">{{ \App\Models\User::count() }}</p>
                                <p class="text-muted mb-0">Tổng số người dùng</p>
                            </div>
                            <div class="col-4 text-end">
                                <i class="bi bi-people stat-icon text-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-sm btn-info stretched-link">
                            Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Có thể thêm các phần khác như biểu đồ, đơn hàng mới nhất, v.v. -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị ngày hiện tại
        document.addEventListener('DOMContentLoaded', function() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date();
            document.getElementById('current-date').textContent = today.toLocaleDateString('vi-VN', options);
            
            // Thêm hiệu ứng tooltip nếu cần
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>