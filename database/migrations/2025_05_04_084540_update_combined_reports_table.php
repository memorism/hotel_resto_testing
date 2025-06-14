<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('combined_reports', function (Blueprint $table) {
            $table->renameColumn('total_transaksi', 'hotel_income');
        });
    
        Schema::table('combined_reports', function (Blueprint $table) {
            $table->decimal('hotel_income', 15, 2)->nullable()->change();
            $table->decimal('hotel_expense', 15, 2)->nullable()->after('hotel_income');
            $table->decimal('resto_income', 15, 2)->nullable()->after('hotel_expense');
            $table->decimal('resto_expense', 15, 2)->nullable()->after('resto_income');
            $table->decimal('total_income', 15, 2)->nullable()->after('resto_expense');
            $table->decimal('total_expense', 15, 2)->nullable()->after('total_income');
            $table->decimal('net_profit', 15, 2)->nullable()->after('total_expense');
            $table->decimal('table_utilization_rate', 5, 2)->nullable()->after('total_okupansi');
            $table->foreignId('created_by')->nullable()->constrained('users')->after('net_profit');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('combined_reports', function (Blueprint $table) {
            $table->renameColumn('hotel_income', 'total_transaksi');
            $table->dropColumn([
                'hotel_expense', 'resto_income', 'resto_expense',
                'total_income', 'total_expense', 'net_profit',
                'table_utilization_rate', 'created_by',
            ]);
        });
    }
    
};
