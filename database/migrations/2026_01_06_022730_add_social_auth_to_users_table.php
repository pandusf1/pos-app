<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->nullable()->unique();

            // OAuth fields
            $table->string('provider')->nullable();        // google / facebook
            $table->string('provider_id')->nullable();     // id dari provider
            $table->string('avatar')->nullable();

            // Untuk login manual (opsional)
            $table->string('password')->nullable();

            $table->rememberToken();
            $table->timestamps();

            // Optional index
            $table->index(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
