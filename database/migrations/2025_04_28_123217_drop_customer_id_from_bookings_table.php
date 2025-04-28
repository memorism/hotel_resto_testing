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
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['customer_id']);    // drop foreign key
        $table->dropColumn('customer_id');       // drop kolom customer_id
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('customer_id')->nullable();
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
    });
}

};
