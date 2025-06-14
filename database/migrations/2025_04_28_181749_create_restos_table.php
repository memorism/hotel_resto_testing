<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restos', function (Blueprint $table) {
            $table->string('street')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('restos', function (Blueprint $table) {
            $table->dropColumn(['street', 'village', 'district', 'city', 'province', 'postal_code']);
        });
    }
    
};
