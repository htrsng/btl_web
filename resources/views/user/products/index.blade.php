<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --category-bg: #f1f8ff;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .category-section {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.1);
            padding: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .category-header {
            background-color: var(--category-bg);
            padding: 0.75rem 1.25rem;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--info-color);
        }

        .category-title {
            color: var(--info-color);
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 0.75rem 0 rgba(58, 59, 69, 0.1);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.2);
        }

        .card-img-container {
            height: 220px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .card-text {
            color: #6e707e;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .price-text {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .stock-text {
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #3a5ec4;
            border-color: #3a5ec4;
        }

        .out-of-stock {
            background-color: #f8f9fa;
            color: var(--danger-color);
            font-weight: 500;
            padding: 0.5rem;
            text-align: center;
            border-radius: 0.25rem;
            margin-top: 1rem;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary-color);
        }

        .back-btn {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .alert-success {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .title-wrapper {
            flex: 1;
            min-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Phần header với nút quay lại và tiêu đề -->
        <div class="page-header">
            <div class="title-wrapper">
                <h1 class="page-title">Danh sách sản phẩm</h1>
            </div>
            <a href="{{ route('user.dashboard') }}" class="btn back-btn">Quay lại</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif

        @foreach ($products->groupBy('category.name') as $categoryName => $categoryProducts)
            <div class="category-section">
                <div class="category-header">
                    <h3 class="category-title">{{ $categoryName }}</h3>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($categoryProducts as $product)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-img-container">
                                    @if ($product->image && file_exists(public_path('storage/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="Placeholder">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text price-text">Giá: <span class="text-success">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span></p>
                                    <p class="card-text stock-text">Số lượng tồn kho: {{ $product->stock }}</p>
                                    @if ($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                                        </form>
                                    @else
                                        <div class="out-of-stock">Hết hàng</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>