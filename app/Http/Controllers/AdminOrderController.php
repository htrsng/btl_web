<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.confirm', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Received request data: ', $request->all());

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,canceled',
            'delivery_time' => 'nullable|date_format:Y-m-d\TH:i',
            'admin_reply' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($id);

        // Debug trước khi cập nhật
        Log::info('Validated data before update: ', $validated);
        Log::info('Current admin_reply before update: ' . ($order->admin_reply ?? 'null'));

        // Xử lý delivery_time thành Carbon nếu có
        $deliveryTime = $validated['delivery_time'] ? Carbon::createFromFormat('Y-m-d\TH:i', $validated['delivery_time']) : null;

        $order->update([
            'status' => $validated['status'],
            'delivery_time' => $deliveryTime,
            'admin_reply' => $validated['admin_reply'],
        ]);

        // Refresh để lấy giá trị mới từ DB
        $order->refresh();

        Log::info('Order updated successfully: ', $order->toArray());

        // Kiểm tra trực tiếp từ DB
       $dbValue = DB::table('orders')->where('id', $id)->value('admin_reply');
       Log::info('Admin_reply from DB: ' . ($dbValue ?? 'null'));

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật.');
    }
}