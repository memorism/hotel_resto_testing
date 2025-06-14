<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotel_resto_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('resto_id')->constrained('restos')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['hotel_id', 'resto_id']); // Hindari duplikasi relasi
        });
    }

    public function down(): void {
        Schema::dropIfExists('hotel_resto_links');
    }
};