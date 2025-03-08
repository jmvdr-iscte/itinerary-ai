<?php

namespace App\Enums\Transaction;

enum Status: string
{
	case PENDING = 'PENDING';
	case PENDING_PAYMENT = 'PENDING_PAYMENT';
	case PROCESSING = 'PROCESSING';
	case COMPLETED = 'COMPLETED';
	case FAILED = 'FAILED';
	case CANCELED = 'CANCELED';
}
