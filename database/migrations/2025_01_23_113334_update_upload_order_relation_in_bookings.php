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
            $table->dropColumn('upload_order'); // Hapus kolom upload_order
        });
    }

    public function down()
    {
        Schema::table('upload_orders', function (Blueprint $table) {
            $table->string('upload_order')->nullable(); // Jika ingin rollback
        });
    }
};
