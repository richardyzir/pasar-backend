<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
 public function index()
{
    return response()->json(['message' => 'Payment settings endpoint']);
}
}
