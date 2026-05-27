<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;

class PaymentSettingController extends Controller
{
    public function index()
    {
        return response()->json(PaymentSetting::where('is_active', true)->orderBy('order')->get());
    }
}
