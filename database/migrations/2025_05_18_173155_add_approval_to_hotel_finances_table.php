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
        Schema::table('hotel_finances', function (Blueprint $table) {
            $table->string('approval_status')->default('pending'); // pending, approved, rejected
            $table->text('rejection_note')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_finances', function (Blueprint $table) {
            $table->dropColumn('approval_status');
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
            $table->dropColumn('rejection_note');
        });
    }
};
