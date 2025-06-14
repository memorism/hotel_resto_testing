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
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->text('rejection_note')->nullable()->after('approval_status');
        });
    }

    public function down()
    {
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->dropColumn('rejection_note');
        });
    }

};
