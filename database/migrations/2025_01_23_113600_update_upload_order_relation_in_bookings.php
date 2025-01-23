<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class UpdateUploadOrderRelationInBookings extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Jika sudah ada foreign key sebelumnya, hapus dulu
            $table->dropForeign(['upload_order_id']);

            // Ubah agar upload_order_id merujuk ke id di upload_orders
            $table->foreign('upload_order_id')
                ->references('id')
                ->on('upload_orders')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['upload_order_id']);
        });
    }
}

