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
        // Migration untuk tabel hotel_supplies
        Schema::create('hotel_supplies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Migration untuk tabel supply_transactions
        Schema::create('hotel_supply_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->string('note')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();

            $table->foreign('supply_id')->references('id')->on('hotel_supplies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_supplies');
        Schema::dropIfExists('hotel_supply_transactions');
    }
};
