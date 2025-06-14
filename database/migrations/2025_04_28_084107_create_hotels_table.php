<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Nama hotel
            $table->string('street')->nullable();       // Jalan / No Rumah
            $table->string('village')->nullable();      // Kelurahan / Desa
            $table->string('district')->nullable();     // Kecamatan
            $table->string('city')->nullable();         // Kota / Kabupaten
            $table->string('province')->nullable();     // Provinsi
            $table->string('postal_code')->nullable();  // Kode Pos
            $table->string('phone')->nullable();        // Telepon hotel
            $table->string('email')->nullable();        // Email hotel
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
