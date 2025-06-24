<!DOCTYPE html>
<html>
<head>
    <title>Tạo sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tạo sản phẩm mới</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Tên sản phẩm" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Giá" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Số lượng tồn kho</label>
                <input type="number" name="stock" id="stock" class="form-control" placeholder="Số lượng" min="0" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả (tùy chọn)</label>
                <textarea name="description" id="description" class="form-control" placeholder="Mô tả sản phẩm"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>