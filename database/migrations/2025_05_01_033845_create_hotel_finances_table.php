<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotel_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('transaction_code')->unique(); // contoh: TRX20250428001
            $table->date('transaction_date');
            $table->time('transaction_time')->nullable();

            $table->enum('transaction_type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);

            $table->string('payment_method'); // contoh: cash, transfer, QRIS
            $table->string('category');       // contoh: Room Booking, Gaji, Laundry
            $table->string('subcategory')->nullable(); // contoh: Deluxe, Superior, dsb

            $table->string('source_or_target')->nullable(); // nama customer/supplier/pegawai
            $table->string('reference_number')->nullable(); // no invoice / bukti pembayaran

            $table->text('description')->nullable(); // catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_finances');
    }
};
