<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadOrderIdToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('upload_order_id')->nullable();  // Menambahkan kolom upload_order_id

            // Menambahkan foreign key
            $table->foreign('upload_order_id')->references('id')->on('upload_orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['upload_order_id']);
            $table->dropColumn('upload_order_id');
        });
    }
}

