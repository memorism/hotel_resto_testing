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
        Schema::table('hotel_finances', function (Blueprint $table) {
            $table->unsignedBigInteger('hotel_upload_id')->nullable()->after('id');

            $table->foreign('hotel_upload_id')
                  ->references('id')
                  ->on('hotel_upload_logs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_finances', function (Blueprint $table) {
            //
        });
    }
};
