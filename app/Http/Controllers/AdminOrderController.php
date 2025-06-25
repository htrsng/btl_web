<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    $order = Order::findOrFail($id);
    $request->validate([
        'status' => 'required|in:pending,confirmed,completed,canceled',
        'delivery_time' => 'nullable|date',
    ]);

    Log::info('Status received: ' . $request->status); // Debug
    $order->update([
        'status' => $request->status,
        'delivery_time' => $request->delivery_time,
    ]);

    return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật.');
}
}