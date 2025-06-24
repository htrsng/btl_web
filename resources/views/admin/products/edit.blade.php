<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm | Hệ thống quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
        
        .current-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h4 class="m-0 font-weight-bold">
                            <i class="bi bi-pencil-square me-2"></i>Sửa sản phẩm
                        </h4>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5 class="alert-heading">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Có lỗi xảy ra!
                                </h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                        <input type="text" name="name" id="name" class="form-control" 
                                               value="{{ old('name', $product->name) }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="number" name="price" id="price" class="form-control" 
                                               value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                                        <input type="number" name="stock" id="stock" class="form-control" 
                                               value="{{ old('stock', $product->stock) }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewFile()">
                                
                                @if ($product->image)
                                    <div class="mt-2">
                                        <p>Ảnh hiện tại:</p>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh hiện tại" class="current-image img-thumbnail">
                                    </div>
                                @endif
                                
                                <img id="preview" class="preview-image img-thumbnail mt-2" src="#" alt="Preview" style="display: none;" />
                            </div>
                            
                            <div class="mb-4">
                                <label for="description" class="form-label">Mô tả sản phẩm</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-x-circle me-1"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Xem trước hình ảnh
        function previewFile() {
            const preview = document.getElementById('preview');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = "block";
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = "none";
            }
        }
        
        // Hiển thị thông báo lỗi cụ thể hơn
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                input.addEventListener('invalid', function() {
                    this.setCustomValidity('Vui lòng điền thông tin này');
                });
                
                input.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            });
        });
    </script>
</body>
</html>