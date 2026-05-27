<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return response()->json(Banner::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $banner = Banner::create($request->all());
        return response()->json($banner, 201);
    }

    public function update(Request $request, int $id)
    {
        Banner::findOrFail($id)->update($request->all());
        return response()->json(['message' => 'OK']);
    }

    public function destroy(int $id)
    {
        Banner::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }

    public function uploadImage(Request $request, int $id)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp,mp4,webm|max:10240']);
        $file = $request->file('image');
        $filename =  time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('banners'), $filename);
        Banner::findOrFail($id)->update(['image' => '/banners/' . $filename]);
        return response()->json(['image' => '/banners/' . $filename]);
    }

    public function uploadTemp(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,webm,mov|max:20480',
        ], [
            'image.mimes' => 'Format harus JPG, PNG, WebP, MP4, WebM, atau MOV',
            'image.max' => 'Ukuran maksimal 20MB',
        ]);
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('banners'), $filename);
        return response()->json(['image' => '/banners/' . $filename]);
    }
}
