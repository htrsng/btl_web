<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng #{{ $order->id }} | Hệ thống quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
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
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0 !important;
            padding: 1rem 1.35rem;
        }
        
        .page-title {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }
        
        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: var(--warning-color);
            color: #000;
        }
        
        .status-confirmed {
            background-color: #36b9cc;
            color: #fff;
        }
        
        .status-completed {
            background-color: var(--success-color);
            color: #fff;
        }
        
        .status-canceled {
            background-color: var(--danger-color);
            color: #fff;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">
                <i class="bi bi-clipboard-check me-2"></i>Xác nhận đơn hàng #{{ $order->id }}
            </h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Quay lại
            </a>
        </div>

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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">
                            <i class="bi bi-info-circle me-2"></i>Thông tin đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Khách hàng:</strong> {{ $order->name }}</p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }} VNĐ</p>
                                <p class="mb-1"><strong>Trạng thái hiện tại:</strong> 
                                    <span class="status-badge status-{{ $order->status }}">
                                        @if($order->status == 'pending') Chờ xử lý
                                        @elseif($order->status == 'confirmed') Đã xác nhận
                                        @elseif($order->status == 'completed') Hoàn thành
                                        @elseif($order->status == 'canceled') Đã hủy
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">
                            <i class="bi bi-gear me-2"></i>Cập nhật trạng thái
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">Trạng thái mới</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                                <div class="form-text">Chọn trạng thái mới cho đơn hàng này</div>
                            </div>

                            <div class="mb-4">
                                <label for="delivery_time" class="form-label fw-bold">Thời gian giao dự kiến</label>
                                <input type="datetime-local" name="delivery_time" id="delivery_time" class="form-control"
                                       value="{{ old('delivery_time', $order->delivery_time ? $order->delivery_time->format('Y-m-d\TH:i') : '') }}">
                                <div class="form-text">Nhập thời gian dự kiến giao hàng (nếu có)</div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-bold">Ghi chú</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
                                <div class="form-text">Thêm ghi chú về đơn hàng (nếu cần)</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Đặt lại
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Xác nhận thay đổi
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
        document.addEventListener('DOMContentLoaded', function() {
            // Tự động đóng thông báo lỗi sau 5 giây
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    new bootstrap.Alert(alert).close();
                }
            }, 5000);
            
            // Hiển thị thông báo khi chọn hủy đơn hàng
            const statusSelect = document.getElementById('status');
            statusSelect.addEventListener('change', function() {
                if (this.value === 'canceled') {
                    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                        this.value = '{{ $order->status }}';
                    }
                }
            });
        });
    </script>
</body>
</html>