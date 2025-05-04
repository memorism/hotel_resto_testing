<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('combined_reports', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('resto_id')->constrained('restos')->onDelete('cascade');

            $table->integer('total_booking')->default(0);
            $table->integer('total_tamu')->default(0);
            $table->decimal('total_okupansi', 5, 2)->default(0.00);
            $table->decimal('total_transaksi', 15, 2)->default(0.00);
            $table->decimal('total_pendapatan', 15, 2)->default(0.00);

            $table->timestamps();

            $table->unique(['tanggal', 'hotel_id', 'resto_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combined_reports');
    }
};
