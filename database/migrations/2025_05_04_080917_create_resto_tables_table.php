<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resto_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resto_id')->constrained('restos')->onDelete('cascade');
            $table->string('table_code')->unique(); // misal: T1, T2, VIP-01
            $table->integer('capacity')->default(4); // kapasitas kursi
            $table->boolean('is_active')->default(true); // bisa nonaktifkan meja
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resto_tables');
    }
};
