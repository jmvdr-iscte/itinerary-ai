<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions.products', function (Blueprint $table) {
			$table->string('symbol', 3);
        });
    }

    public function down(): void
    {
        Schema::table('transactions.products', function (Blueprint $table) {
			$table->string('symbol', 3);
        });
    }
};
