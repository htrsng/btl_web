<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-detail {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .product-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .no-image {
            width: 200px;
            height: 200px;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="product-detail">
            <h1 class="mb-4">Chi tiết sản phẩm</h1>
            <div class="row">
                <div class="col-md-4">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <p><strong>ID:</strong> {{ $product->id }}</p>
                    <p><strong>Tên:</strong> {{ $product->name }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa có' }}</p>
                    <p><strong>Mô tả:</strong> {{ $product->description ?? 'Chưa có' }}</p>
                    <p><strong>Tồn kho:</strong>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif
                    </p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning ms-2">Sửa</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>