<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của user.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('user')->get();
        return view('user.orders.index', compact('orders'));
    }

    /**
     * Hiển thị form tạo đơn hàng từ giỏ hàng.
     */
    public function create()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        return view('user.orders.create', compact('cartItems', 'total'));
    }

    /**
     * Lưu đơn hàng từ giỏ hàng.
     */
    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
        ]);

        // Xóa giỏ hàng sau khi tạo order
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    /**
     * Hiển thị chi tiết đơn hàng.
     */
    public function show(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            return redirect()->route('orders.index')->with('error', 'Bạn không có quyền xem đơn hàng này.');
        }
        $order->load('user');
        return view('user.orders.show', compact('order'));
    }
}