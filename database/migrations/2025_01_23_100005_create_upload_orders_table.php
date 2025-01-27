<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_upload_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('upload_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Relasi dengan tabel users
            $table->integer('upload_order');  // Urutan upload
            $table->string('file_name');  // Nama file yang diupload
            $table->string('description');  // Tipe file yang diupload
            $table->timestamps();

            // Menambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_orders');
    }
}
