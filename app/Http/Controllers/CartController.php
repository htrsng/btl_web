<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('user.cart.index', compact('cartItems'));
    }

    public function remove($id)
  {
    $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
    $product = $cart->product;
    $cart->delete();
    $product->increment('stock', $cart->quantity); // Tăng stock khi xóa
    return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
  }
}