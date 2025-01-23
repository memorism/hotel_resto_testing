<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->integer('no_of_adults');
            $table->integer('no_of_children');
            $table->integer('no_of_weekend_nights');
            $table->integer('no_of_week_nights');
            $table->string('type_of_meal_plan');
            $table->integer('required_car_parking_space');
            $table->string('room_type_reserved');
            $table->integer('lead_time');
            $table->integer('arrival_year');
            $table->integer('arrival_month');
            $table->integer('arrival_date');
            $table->string('market_segment_type');
            $table->integer('repeated_guest');
            $table->integer('no_of_previous_cancellations');
            $table->integer('no_of_previous_bookings_not_canceled');
            $table->decimal('avg_price_per_room', 8, 2);
            $table->integer('no_of_special_requests');
            $table->string('booking_status'); // "Canceled" or "Not Canceled"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
