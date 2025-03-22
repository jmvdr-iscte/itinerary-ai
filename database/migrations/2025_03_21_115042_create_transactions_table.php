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
			$table->uuid('uid');
			$table->enum('status', array_map(fn($case) => $case->value, EStatus::cases()));
			$table->string('value');
			$table->string('currency');
			$table->string('method');
			$table->string('gateway');
            $table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('transactions.products');
			$table->string('country')->nullable(true);
			$table->string('gateway_reference')->nullable(true);
            $table->string('promo_code')->nullable(true);
            $table->unsignedBigInteger('itinerary_id');
			$table->foreign('itinerary_id')->references('id')->on('itinerary.itinerary');
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
