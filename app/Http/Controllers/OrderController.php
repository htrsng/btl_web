<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.orders.create', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|regex:/^[0-9]{10,11}$/',
        ], [
            'name.required'    => 'Vui lòng nhập tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone.required'   => 'Vui lòng nhập số điện thoại.',
            'phone.regex'      => 'Số điện thoại không hợp lệ (10-11 số).',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone,
            'total'   => $total,
        ]);

        foreach ($cartItems as $item) {
            $product = $item->product;
            $product->decrement('stock', $item->quantity);
            $item->delete();
        }

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được đặt thành công!');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('user.orders.index', compact('orders'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'product_id'=> 'required|exists:products,id',
            'quantity'  => 'required|integer|min:1',
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'phone'     => 'required|string|regex:/^[0-9]{10,11}$/',
        ], [
            'user_id.required'   => 'Vui lòng chọn người dùng.',
            'product_id.required'=> 'Vui lòng chọn sản phẩm.',
            'quantity.required'  => 'Vui lòng nhập số lượng.',
            'quantity.min'       => 'Số lượng phải lớn hơn 0.',
            'name.required'      => 'Vui lòng nhập tên.',
            'address.required'   => 'Vui lòng nhập địa chỉ.',
            'phone.required'     => 'Vui lòng nhập số điện thoại.',
            'phone.regex'        => 'Số điện thoại không hợp lệ (10-11 số).',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Số lượng không đủ trong kho!');
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone,
            'total'   => $total,
        ]);

        $product->decrement('stock', $request->quantity);

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được tạo thành công!');
    }

    public function show($order)
    {
        $order = Order::findOrFail($order);

        if (Auth::user()->role === 'admin' || $order->user_id === Auth::id()) {
            return view('user.orders.show', compact('order'));
        }

        return redirect()->back()->with('error', 'Bạn không có quyền xem đơn hàng này.');
    }

    public function adminIndex()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }
}
