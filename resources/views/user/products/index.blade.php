<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Danh sách sản phẩm</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @foreach ($products->groupBy('category.name') as $categoryName => $categoryProducts)
            <h3>{{ $categoryName }}</h3>
            <div class="row">
                @foreach ($categoryProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Giá: {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                                <p class="card-text">Số lượng tồn kho: {{ $product->stock }}</p>
                                @if ($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                                    </form>
                                @else
                                    <p class="text-danger">Hết hàng</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-4">Quay lại</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>