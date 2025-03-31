<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Itinerary;

class cancelOldItineraries extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:cancel-old-itineraries';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$pending_itineraries = Itinerary::whereIn('status', ['PENDING', 'CREATED'])
			->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()->subDays(2)])
			->get();

		$count = $pending_itineraries->count();

		foreach ($pending_itineraries as $itinerary) {
			$itinerary->status = 'CANCELED';
			$itinerary->save();
		}

		Log::info("CancelPendingItinerariesJob: {$count} pending itineraries have been canceled.");
	}
}
