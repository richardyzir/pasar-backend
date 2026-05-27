<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendOtp($phone, $token)
    {
        $phone = $this->formatPhone($phone);
        $message = "Kode verifikasi Anda: *{$token}*\n\nKode berlaku 2 menit.\nJangan berikan kode ini kepada siapapun.\n\n- Pasar Online";

        try {
            $response = Http::withHeaders(['Authorization' => env('SMS_API_KEY')])
                ->post(env('SMS_API_URL'), ['target' => $phone, 'message' => $message]);

            if (!$response->successful()) {
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') $phone = '62' . substr($phone, 1);
        if (substr($phone, 0, 2) !== '62') $phone = '62' . $phone;
        return $phone;
    }
}
