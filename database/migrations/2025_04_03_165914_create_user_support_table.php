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
        Schema::create('users.support', function (Blueprint $table) {
            $table->id();
            $table->string('email', 256);
            $table->string('name', 256);
            $table->string('title', 256)->nullable();
            $table->string('content', 1024);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users.support');
    }
};
