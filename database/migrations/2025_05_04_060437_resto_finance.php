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
        Schema::create('resto_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resto_id')->constrained('restos')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis'); // pemasukan / pengeluaran
            $table->string('keterangan')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
