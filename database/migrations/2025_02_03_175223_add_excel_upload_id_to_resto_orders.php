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
        Schema::table('resto_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('excel_upload_id')->nullable();
    
            // Menambahkan foreign key untuk menghubungkan dengan tabel excel_uploads
            $table->foreign('excel_upload_id')->references('id')->on('excel_uploads')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('resto_orders', function (Blueprint $table) {
            $table->dropForeign(['excel_upload_id']);
            $table->dropColumn('excel_upload_id');
        });
    }
    
};
