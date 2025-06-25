@extends('layouts.app')

@section('title', 'Sửa Đơn hàng')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Sửa Đơn hàng #{{ $order->id }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">Người dùng</label>
            <select name="user_id" class="form-control border p-2 w-full">
                @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Tên</label>
            <input type="text" name="name" value="{{ old('name', $order->name) }}" class="form-control border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">Địa chỉ</label>
            <input type="text" name="address" value="{{ old('address', $order->address) }}" class="form-control border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">Số điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone', $order->phone) }}" class="form-control border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">Tổng tiền</label>
            <input type="number" step="0.01" name="total" value="{{ old('total', $order->total) }}" class="form-control border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">Yêu cầu từ khách</label>
            <textarea name="requirements" class="form-control border p-2 w-full" readonly>{{ old('requirements', $order->requirements) ?? 'Không có yêu cầu' }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block">Trạng thái</label>
            <select name="status" class="form-control border p-2 w-full" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Thời gian giao dự kiến</label>
            <input type="datetime-local" name="delivery_time" value="{{ old('delivery_time', $order->delivery_time ? $order->delivery_time->format('Y-m-d\TH:i') : '') }}" class="form-control border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">Phản hồi cho khách</label>
            <textarea name="admin_reply" class="form-control border p-2 w-full" maxlength="1000" placeholder="Nhập phản hồi...">{{ old('admin_reply', $order->admin_reply) ?? '' }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Cập nhật</button>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white p-2 rounded inline-block ml-2">Quay lại</a>
    </form>
@endsection