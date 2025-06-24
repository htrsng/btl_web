<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .dashboard-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .product-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-btn {
            margin: 2px;
            width: 70px;
        }
        .stock-indicator {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.85rem;
        }
        .stock-low {
            background-color: #fff3cd;
            color: #856404;
        }
        .stock-out {
            background-color: #f8d7da;
            color: #721c24;
        }
        .stock-ok {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Quản trị sản phẩm</h1>
                    <p class="text-muted mb-0">Xin chào Quản trị viên</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Thêm sản phẩm
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="product-table">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Tồn kho</th>
                            <th>Hình ảnh</th>
                            <th width="160">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="fw-bold">#{{ $product->id }}</td>
                                <td>
                                    <div>{{ $product->name }}</div>
                                    <small class="text-muted">{{ Str::limit($product->description, 30) ?: 'Không có mô tả' }}</small>
                                </td>
                                <td class="text-nowrap">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                <td>{{ $product->category->name ?? 'Chưa phân loại' }}</td>
                                <td>
                                    @if($product->stock == 0)
                                        <span class="stock-indicator stock-out">Hết hàng</span>
                                    @elseif($product->stock < 10)
                                        <span class="stock-indicator stock-low">{{ $product->stock }}</span>
                                    @else
                                        <span class="stock-indicator stock-ok">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                                    @else
                                        <div class="text-muted">Không có ảnh</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning action-btn">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger action-btn" 
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash me-1"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>