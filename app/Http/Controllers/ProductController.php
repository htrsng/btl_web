<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.products.index', compact('products'));
        }
        return view('user.products.index', compact('products'));
    }

    public function addToCart($id, Request $request)
{
    $product = Product::findOrFail($id);
    $quantity = $request->input('quantity', 1); // Nhận số lượng từ form, mặc định là 1

    if ($quantity <= 0 || $quantity > $product->stock) {
        return redirect()->back()->with('error', 'Số lượng không hợp lệ hoặc vượt quá tồn kho!');
    }

    $cart = Cart::firstOrCreate(
        ['user_id' => Auth::id(), 'product_id' => $product->id],
        ['quantity' => 0]
    );
    $cart->update(['quantity' => $cart->quantity + $quantity]);
    $product->decrement('stock', $quantity);
    $product->save();

    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
}


    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.products.show', compact('product'));
        }
        return view('user.products.show', compact('product'));
    }
}