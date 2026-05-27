<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Kirim OTP (development: simpan di log)
     */
    public function sendOtp($phone, $token)
    {
        $phone = $this->formatPhone($phone);

        $message = "Kode verifikasi Anda: *{$token}*\n";
        $message .= "Kode berlaku 2 menit.\n";
        $message .= "Jangan berikan kode ini kepada siapapun.\n";
        $message .= "- Pasar Online";

        return true;
    }

    /**
     * Format nomor telepon
     */
    private function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
