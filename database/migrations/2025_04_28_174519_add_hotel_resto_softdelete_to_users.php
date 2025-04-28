<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('resto_id')->nullable()->after('hotel_id');
            $table->softDeletes();

            $table->foreign('resto_id')->references('id')->on('restos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['resto_id']);
            $table->dropColumn(['hotel_id', 'resto_id', 'deleted_at']);
        });
    }
};
