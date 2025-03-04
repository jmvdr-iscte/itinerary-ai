<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Transaction\Status as EStatus;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('transactions.transactions', function (Blueprint $table) {
			$table->id();
			$table->string('uid')->unique();
			$table->enum('status', array_map(fn($case) => $case->value, EStatus::cases()));
			$table->string('value');
			$table->string('currency');
			$table->string('method');
			$table->string('gateway');
			$table->foreign('product_id')->references('id')->on('transactions.products');
			$table->string('country')->nullable(true);
			$table->string('gateway_reference')->nullable(true);
			$table->json('metadata')->nullable(true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('transactions.transactions');
	}
};
