<?php

namespace App\Enums\Transaction;

enum Status
{
	const PENDING = 'PENDING';
	const PENDING_PAYMENT = 'PENDING_PAYMENT';
	const COMPLETED = 'COMPLETED';
	const FAILED = 'FAILED';
	const CANCELED = 'CANCELED';
}
