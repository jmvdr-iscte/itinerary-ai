<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class cancelOldTransactions extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:cancel-old-transactions';

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
        $pending_transactions = Transaction::whereIn('status', ['PENDING', 'PENDING_PAYMENT'])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()->subDays(2)])
            ->get();

		$count = $pending_transactions->count();

		foreach ($pending_transactions as $transactions) {
			$transactions->status = 'CANCELED';
			$transactions->save();
		}

		Log::info("CancelPendingTransactionsJob: {$count} pending transactions have been canceled.");
	}
}
