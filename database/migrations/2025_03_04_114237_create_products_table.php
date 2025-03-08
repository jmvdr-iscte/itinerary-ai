<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Product\Status as EStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions.products', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
			$table->enum('status', array_map(fn($case) => $case->value, EStatus::cases()));
            $table->integer('value');
            $table->string('currency');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions.products');
    }
};
