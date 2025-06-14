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
        Schema::table('hotel_upload_logs', function (Blueprint $table) {
            $table->string('type');
        });
    }
    
    public function down()
    {
        Schema::table('hotel_upload_logs', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
    
};
