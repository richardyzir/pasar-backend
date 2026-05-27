<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::orderBy('order')->paginate(50));
    }

    public function store(Request $request)
    {
        return response()->json(Category::create($request->all()), 201);
    }

    public function update(Request $request, $id)
    {
        Category::findOrFail($id)->update($request->all());
        return response()->json(['message' => 'OK']);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }
}
