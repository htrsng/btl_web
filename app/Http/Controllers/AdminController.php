<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm (hoặc tùy chỉnh query nếu cần)
        Log::info('Admin Dashboard accessed with ' . $products->count() . ' products');
        return view('admin.dashboard', compact('products')); // Truyền biến $products
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        Product::create($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Sản phẩm đã được thêm!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Sản phẩm đã được xóa!');
    }
}