<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 0.5rem rgba(58, 59, 69, 0.1);
            border: none;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: none;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50%;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .form-label {
            font-weight: 500;
            color: #4a4a4a;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            padding: 0.5rem 0.75rem;
            transition: border-color 0.15s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.2);
        }

        textarea.form-control {
            min-height: 100px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #3a5bc7;
            border-color: #3a5bc7;
        }

        .btn-outline-secondary {
            border-color: #d1d3e2;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            border-radius: 4px;
            font-weight: 500;
        }

        .badge.bg-success { background-color: var(--success-color); }
        .badge.bg-warning { background-color: var(--warning-color); color: #2d3436; }
        .badge.bg-danger { background-color: var(--danger-color); }
        .badge.bg-info { background-color: var(--info-color); }
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="page-title">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa đơn hàng #{{ $order->id }}
        </h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Khách hàng</label>
                            <input type="text" class="form-control" value="{{ $order->user->name ?? 'Khách' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng tiền</label>
                            <input type="text" class="form-control" value="{{ number_format($order->total, 0, ',', '.') }} ₫" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Thời gian giao dự kiến</label>
                        <input type="datetime-local" name="delivery_time" class="form-control" 
                               value="{{ $order->delivery_time ? (is_string($order->delivery_time) ? \Carbon\Carbon::parse($order->delivery_time)->format('Y-m-d\TH:i') : $order->delivery_time->format('Y-m-d\TH:i')) : '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Yêu cầu từ khách</label>
                        <textarea class="form-control" readonly style="background-color: #f8f9fa;">{{ $order->requirements ?? 'Không có yêu cầu' }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Phản hồi cho khách <span class="text-muted">(Tối đa 1000 ký tự)</span></label>
                        <textarea name="admin_reply" class="form-control" maxlength="1000" 
                                  placeholder="Nhập phản hồi cho khách hàng...">{{ $order->admin_reply ?? '' }}</textarea>
                        <div class="text-end text-muted small mt-1">
                            <span id="charCount">0</span>/1000 ký tự
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Đếm ký tự cho textarea phản hồi
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea[name="admin_reply"]');
            const charCount = document.getElementById('charCount');
            
            if (textarea && charCount) {
                charCount.textContent = textarea.value.length;
                
                textarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }
        });
    </script>
</body>
</html>