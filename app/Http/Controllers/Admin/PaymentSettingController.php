<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        return response()->json(PaymentSetting::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        return response()->json(PaymentSetting::create($request->all()), 201);
    }

    public function update(Request $request, $id)
    {
        PaymentSetting::findOrFail($id)->update($request->all());
        return response()->json(['message' => 'OK']);
    }

    public function destroy($id)
    {
        PaymentSetting::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }
}
