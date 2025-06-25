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
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            border-top-left-radius: 0.35rem;
            border-top-right-radius: 0.35rem;
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-color);
        }

        .card-text {
            color: #6e707e;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: darken(var(--primary-color), 10%);
            border-color: darken(var(--primary-color), 10%);
        }

        .text-danger {
            font-weight: 500;
        }

        .category-title {
            color: var(--info-color);
            font-weight: 600;
            margin-top: 2rem;
            border-bottom: 2px solid var(--info-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Danh sách sản phẩm</h1>

        @if (session('success'))
            <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
        @endif

        @foreach ($products->groupBy('category.name') as $categoryName => $categoryProducts)
            <h3 class="category-title">{{ $categoryName }}</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($categoryProducts as $product)
                    <div class="col">
                        <div class="card h-100">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Giá: <span class="text-success">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span></p>
                                <p class="card-text">Số lượng tồn kho: {{ $product->stock }}</p>
                                @if ($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                                    </form>
                                @else
                                    <p class="text-danger mt-auto">Hết hàng</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="text-center mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>