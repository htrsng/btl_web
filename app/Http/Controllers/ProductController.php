<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.products.index', compact('products'));
        }
        return view('user.products.index', compact('products'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng và giảm stock.
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng!');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $cart->increment('quantity');
        $product->decrement('stock');
        $product->save(); // Đảm bảo cập nhật stock

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Hiển thị chi tiết sản phẩm.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.products.show', compact('product'));
        }
        return view('user.products.show', compact('product'));
    }
}