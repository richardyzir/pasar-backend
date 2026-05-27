<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('base_price', 12, 2)->nullable()->after('price');
            $table->decimal('packing_fee', 12, 2)->default(0)->after('base_price');
            $table->decimal('admin_fee_product', 12, 2)->default(0)->after('packing_fee');
            $table->decimal('kurir_fee', 12, 2)->default(0)->after('admin_fee_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
