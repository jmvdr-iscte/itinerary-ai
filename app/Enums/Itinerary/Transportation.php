<?php

namespace App\Enums\Itinerary;

enum Transportation: string
{
	case CAR = 'CAR';
	case WALK = 'WALK';
	case BIKE = 'BIKE';
    case PUBLIC_TRANSPORT = 'PUBLIC_TRANSPORT';
}
