<?php

namespace App\Enums\Itinerary;

enum Status: string
{
	case CREATED = 'CREATED';
	case PENDING = 'PENDING';
	case CANCELED = 'CANCELED';
	case FAILED = 'FAILED';
	case COMPLETED = 'COMPLETED';
}
