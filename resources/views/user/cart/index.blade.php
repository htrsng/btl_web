<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
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

        .cart-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .cart-header {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .cart-header:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary-color);
        }

        .cart-table {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
        }

        .cart-table thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .cart-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: rgba(0,0,0,0.05);
        }

        .cart-table tbody tr:nth-child(even) {
            background-color: var(--light-gray);
        }

        .product-name {
            font-weight: 500;
            color: #4a4a4a;
        }

        .product-price {
            font-weight: 500;
            color: var(--primary-color);
        }

        .product-total {
            font-weight: 600;
            color: var(--success-color);
        }

        .quantity-badge {
            font-size: 1rem;
            padding: 0.35rem 0.75rem;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 0.25rem;
        }

        .btn-remove {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            font-weight: 500;
            padding: 0.375rem 0.75rem;
        }

        .btn-remove:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-checkout {
            background-color: var(--success-color);
            border-color: var(--success-color);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }

        .btn-checkout:hover {
            background-color: #17a673;
            border-color: #169b6b;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
        }

        .empty-cart-icon {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }

        .alert-success {
            border-radius: 0.5rem;
            font-weight: 500;
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        @media (max-width: 768px) {
            .cart-table thead {
                display: none;
            }
            
            .cart-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                overflow: hidden;
                box-shadow: 0 0.15rem 0.75rem 0 rgba(58, 59, 69, 0.1);
            }
            
            .cart-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                text-align: right;
            }
            
            .cart-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--primary-color);
                margin-right: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h1 class="cart-header">Giỏ Hàng Của Bạn</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($cartItems->isNotEmpty())
            <div class="cart-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Đơn Giá</th>
                            <th>Số Lượng</th>
                            <th>Thành Tiền</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td class="product-name" data-label="Sản Phẩm">
                                    {{ $item->product->name ?? 'Sản phẩm không tồn tại' }}
                                </td>
                                <td class="product-price" data-label="Đơn Giá">
                                    {{ number_format($item->product->price ?? 0, 0, ',', '.') }} VNĐ
                                </td>
                                <td data-label="Số Lượng">
                                    <span class="quantity-badge">{{ $item->quantity }}</span>
                                </td>
                                <td class="product-total" data-label="Thành Tiền">
                                    {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }} VNĐ
                                </td>
                                <td data-label="Thao Tác">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-remove btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <a href="{{ route('orders.create') }}" class="btn btn-checkout">
                    Tiến Hành Đặt Hàng
                </a>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    Tiếp tục mua sắm
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>