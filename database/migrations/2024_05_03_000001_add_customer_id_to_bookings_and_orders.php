
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->after('hotel_id');
            $table->foreign('customer_id')->references('id')->on('shared_customers')->nullOnDelete();
        });

        Schema::table('resto_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->after('resto_id');
            $table->foreign('customer_id')->references('id')->on('shared_customers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });

        Schema::table('resto_orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
