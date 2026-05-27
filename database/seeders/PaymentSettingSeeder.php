<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingSeeder extends Seeder
{
    public function run()
    {
        PaymentSetting::create([
            'method' => 'bank_transfer',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'Fofi Mart',
            'instructions' => 'Transfer tepat hingga 3 digit terakhir',
            'order' => 1,
        ]);

        PaymentSetting::create([
            'method' => 'virtual_account',
            'bank_name' => 'BCA',
            'va_prefix' => '823',
            'instructions' => 'Bayar melalui ATM/Internet Banking BCA',
            'order' => 2,
        ]);

        PaymentSetting::create([
            'method' => 'qris',
            'instructions' => 'Scan QR code menggunakan aplikasi e-wallet atau mobile banking',
            'order' => 3,
        ]);

        PaymentSetting::create([
            'method' => 'cod',
            'instructions' => 'Bayar tunai saat pesanan diterima',
            'order' => 4,
        ]);
    }
}
