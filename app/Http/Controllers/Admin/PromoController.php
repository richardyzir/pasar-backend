<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        return response()->json(Promo::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $promo = Promo::create($request->all());
        return response()->json($promo, 201);
    }

    public function update(Request $request, $id)
    {
        Promo::findOrFail($id)->update($request->all());
        return response()->json(['message' => 'OK']);
    }

    public function destroy($id)
    {
        Promo::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $file = $request->file('image');
        $filename = 'promos/' . time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('promos'), $filename);
        Promo::findOrFail($id)->update(['image' => '/promos/' . $filename]);
        return response()->json(['image' => '/promos/' . $filename]);
    }
}
