<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Itinerary\Status as EStatus;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('itinerary.itinerary', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->enum('status', array_map(fn($case) => $case->value, EStatus::cases()));
            $table->string('email');
            $table->json('itinerary');
            $table->string('destination');
            $table->json('categories');
            $table->json('transportation');
            $table->integer('number_of_people');
            $table->string('origin');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->decimal('budget', 10, 2);
            $table->string('currency', 3);
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('itinerary.itinerary');
	}
};
