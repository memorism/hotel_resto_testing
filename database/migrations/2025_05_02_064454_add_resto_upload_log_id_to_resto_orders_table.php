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
        Schema::table('resto_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('resto_upload_log_id')->nullable()->after('id');

            // Optional: Tambahkan foreign key jika ingin ada relasi DB
            $table->foreign('resto_upload_log_id')->references('id')->on('resto_upload_logs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('resto_orders', function (Blueprint $table) {
            $table->dropForeign(['resto_upload_log_id']);
            $table->dropColumn('resto_upload_log_id');
        });
    }

};
