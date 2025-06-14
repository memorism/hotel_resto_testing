<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('upload_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('hotel_id')->after('id')->nullable();
            $table->foreign('hotel_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upload_orders', function (Blueprint $table) {
            //
        });
    }
};
