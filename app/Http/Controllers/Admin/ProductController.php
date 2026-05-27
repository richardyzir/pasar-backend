<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 20;
        $query = Product::latest();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'nullable|numeric',
            'packing_fee' => 'nullable|numeric',
            'admin_fee_product' => 'nullable|numeric',
            'kurir_fee' => 'nullable|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string',
        ]);

        $data = $request->all();

        // Hitung harga jual otomatis
        $data['price'] = ($request->base_price ?? 0)
            + ($request->packing_fee ?? 0)
            + ($request->admin_fee_product ?? 0)
            + ($request->kurir_fee ?? 0);

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        $data['price'] = ($request->base_price ?? 0)
            + ($request->packing_fee ?? 0)
            + ($request->admin_fee_product ?? 0)
            + ($request->kurir_fee ?? 0);

        $product->update($data);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Hapus gambar lama
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Upload gambar baru
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('products'), $filename);

        $product->update(['image' => '/products/' . $filename]);

        return response()->json(['message' => 'Uploaded', 'image' => $product->image]);
    }

    public function uploadTemp(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $file = $request->file('image');
        $filename = 'products/' . time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('products'), $filename);
        return response()->json(['image' => '/products/' . $filename]);
    }
}
