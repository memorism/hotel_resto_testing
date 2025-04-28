<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // 🔥 DROP FOREIGN KEY DULU
            $table->dropForeign(['user_id']);
            // 🔥 DROP COLUMN user_id
            $table->dropColumn('user_id');

            // ✅ TAMBAH hotel_id
            $table->unsignedBigInteger('hotel_id')->after('id');

            // 🔥 HAPUS field riwayat
            if (Schema::hasColumn('bookings', 'no_of_previous_cancellations')) {
                $table->dropColumn('no_of_previous_cancellations');
            }
            if (Schema::hasColumn('bookings', 'no_of_previous_bookings_not_canceled')) {
                $table->dropColumn('no_of_previous_bookings_not_canceled');
            }
        });
    }


    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dropColumn('hotel_id');
            $table->integer('no_of_previous_cancellations')->nullable();
            $table->integer('no_of_previous_bookings_not_canceled')->nullable();
        });
    }
};
