<?php

namespace App\Enums\Itinerary;

enum Category: string
{
	case ADVENTURE = 'ADVENTURE';
	case CULTURE = 'CULTURE';
	case LOVE = 'LOVE';
    case RELAX = 'RELAX';
    case NIGHTLIFE = 'NIGHTLIFE';
    case SHOPPING = 'SHOPPING';
    case SPORTS = 'SPORTS';
    case FAMILY = 'FAMILY';
    case BUSINESS = 'BUSINESS';
    case FOOD = 'FOOD';
    case NATURE = 'NATURE';
    case RELIGION = 'RELIGION';
    case WINE = 'WINE';
}
