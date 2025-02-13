<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('resto_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->date('order_date');
            $table->time('time_order');
            $table->string('item_name');
            $table->string('item_type');
            $table->integer('item_price');
            $table->integer('quantity');
            $table->integer('transaction_amount');
            $table->string('transaction_type');
            $table->string('received_by');
            $table->string('type_of_order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resto_orders');
    }
};

