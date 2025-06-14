<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_restos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('restos', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // Nama restoran
            $table->string('address')->nullable();        // Alamat (opsional)
            $table->string('phone')->nullable();          // Nomor telepon (opsional)
            $table->string('logo')->nullable();           // Logo resto (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restos');
    }
};

