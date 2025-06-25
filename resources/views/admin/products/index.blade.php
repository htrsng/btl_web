<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --hover-color: #2980b9;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            max-width: 95%;
            padding: 20px;
        }
        
        .dashboard-header {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-x: auto;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }
        
        .table th {
            background-color: var(--secondary-color);
            color: white;
            font-weight: 500;
        }
        
        .table td, .table th {
            vertical-align: middle;
            padding: 12px 15px;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .action-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .no-image {
            width: 60px;
            height: 60px;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            color: #777;
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                display: flex;
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Menu điều hướng -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin</a>
                <div class="navbar-nav">
                    <a class="nav-link active" href="{{ route('admin.products.index') }}">Quản lý sản phẩm</a>
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">Quản lý đơn hàng</a>
                </div>
            </div>
        </nav>

        <div class="dashboard-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0"><i class="fas fa-tachometer-alt me-2"></i>Bảng điều khiển</h1>
                    <p class="text-muted mb-0">Xin chào, Quản trị viên!</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Thêm sản phẩm
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Tồn kho</th>
                            <th>Hình ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="fw-bold">#{{ $product->id }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $product->name }}</span>
                                        <small class="text-muted">{{ $product->description ? Str::limit($product->description, 50) : 'Chưa có mô tả' }}</small>
                                    </div>
                                </td>
                                <td class="text-nowrap">{{ number_format($product->price, 0, ',', '.') }} ₫</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>