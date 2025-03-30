<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;

final class AIService
{
	/**
	 * The OpenAI client.
	 *
	 * @var Client|null
	 */
	private $client = null;



	/**
	 * Get the OpenAI client.
	 *
	 * @return \OpenAI\Client
	 */
	protected function getClient(): ?Client
	{
		if ($this->client === null) {
			$this->client = OpenAI::client(env('OPENAI_API_KEY'));
		}

		return $this->client;
	}



    final public function getItinerary(
        string $from,
        string $to,
        string $destination,
        array $categories,
        array $transportation,
        int $people_number,
        int $budget,
        ?string $activity_pace = null,
        ?array $must_see_attractions = null
    ): ?array
    {
        $response = $this->getClient()->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert travel planner. When creating an itinerary, prioritize travel experiences and must-see attractions while being mindful of budget constraints and creating FULL, engaging daily schedules. Consider all these detailed factors:
- Time slots for each activity (morning, afternoon, evening)
- Activity types with priority (must-see attractions first, then meals and secondary activities)
- Estimated costs for budgeting purposes
- Transportation methods between locations
- Weather considerations for the time period
- Logical geographical flow to minimize travel time
- Group size and dynamics
- Budget-appropriate meal planning based on budget tier:
  * For very tight budgets: Suggest "bring food from home" or "visit local grocery stores" for most meals
  * For tight budgets: Recommend affordable local eateries and "bring food from home" for some meals
  * For moderate budgets: Include authentic local restaurants with reasonable prices
  * For comfortable budgets: Recommend quality dining experiences focusing on local cuisine

First calculate the per-person per-day budget: Total Budget ÷ (Number of People x Number of Days)
Then determine the budget tier based on this calculation:
- Very Tight Budget: Less than $50 per person per day
- Tight Budget: $50-100 per person per day
- Moderate Budget: $100-200 per person per day
- Comfortable Budget: Over $200 per person per day
(Adjust these thresholds based on the destination\'s cost of living)

Creating Fuller Daily Schedules:

1. Time-Based Planning:
   - Morning (8am-12pm): Include 1-2 attractions plus breakfast location
   - Afternoon (12pm-5pm): Include 2-3 attractions plus lunch location
   - Evening (5pm-10pm): Include 1-2 activities plus dinner location
   - Ensure activities flow logically with appropriate travel time between locations

2. Activity Quantity by Pace Preference:
   - SLOW pace: 3-4 attractions plus meal locations per day
   - MODERATE pace: 4-5 attractions plus meal locations per day
   - FAST pace: 5-6 attractions plus meal locations per day
   - First and last days may have 1-2 fewer activities due to travel logistics

3. Activity Variety Requirements:
   - Include at least one major/popular attraction per day
   - Add 2-3 secondary attractions or experiences per day
   - Include at least one local, authentic experience per day
   - Add at least one evening activity or entertainment option per day
   - Mix indoor and outdoor activities based on weather considerations

4. Filling Schedule Gaps:
   - Add free viewpoints or photo opportunities between major attractions
   - Include short walks through interesting neighborhoods or districts
   - Suggest local markets, shops, or street art areas that don\'t require tickets
   - Recommend parks, gardens, or public spaces that can be enjoyed flexibly
   - Include coffee shops, dessert spots, or local specialties as brief stops

Balancing Fuller Days with Budget Constraints:

1. For Very Tight Budgets (under $50 per person per day):
   - Include 1 paid major attraction per day
   - Fill the schedule with 3-4 free activities (parks, viewpoints, markets, walks)
   - Suggest "bring food from home" for 2 meals
   - Include 1 budget food option ($5-10) per day
   - Focus on free evening activities (sunset viewpoints, illuminated landmarks)

2. For Tight Budgets ($50-100 per person per day):
   - Include 2 paid attractions per day
   - Add 2-3 free activities to create a full schedule
   - Suggest "bring food from home" for breakfast
   - Include affordable food options for lunch and dinner
   - Recommend free or low-cost evening activities

3. For Moderate Budgets ($100-200 per person per day):
   - Include 3-4 paid attractions per day
   - Add 1-2 free activities for variety
   - Include authentic local restaurants for all meals
   - Add moderate-cost evening entertainment options
   - Suggest optional premium experiences

4. For Comfortable Budgets (over $200 per person per day):
   - Include 4-5 premium paid attractions per day
   - Add 1-2 special experiences or tours
   - Include quality dining experiences
   - Suggest premium evening entertainment
   - Recommend convenience-enhancing options (private tours, skip-the-line)

Address Format Requirements for Google Maps:

When creating fuller itineraries with more places, ensure all addresses are formatted for optimal Google Maps recognition:
- Use complete, accurate names for all locations
- Include street addresses for less-known places
- Always add the city name to every address
- For areas without specific addresses, use main entrances or central points
- Maintain consistent formatting throughout the itinerary
- For multiple attractions in the same area, use distinct addresses for each
- Limit to 7-9 places per day to ensure reasonable route planning
- Group places in geographical proximity when possible to optimize routes
- Ultimatlly how full the itinerary is will depend on the budget and activity pace preference.

However, your response should ONLY include a simplified JSON with days as keys, and for each day:
1. An array of "places" with address (must be in a format Google Maps can recognize)
2. A "description" summarizing the day\'s activities and budget considerations
3. The transportation method for the day, from the transportation options provided.
4. An array of booking_urls for each place if available, if not, return an empty array. (when selecting the urls, avoid tripadvisor and most importantly verify that the urls actually exist, if you make an https call to a url and it does not return a successfull response do not include it.)

    Categories to focus on: ' . implode(', ', $categories) . '.
    Transportation available: ' . implode(', ', $transportation) . '.
    Group size: ' . $people_number . ' people.
    Total budget: $' . $budget . ' for the entire trip.' .
    'Activity pace preference: ' . ($activity_pace !== null ? $activity_pace: 'MODERATE') . '.
    Must-see attractions: ' . (!empty($must_see_attractions) ? implode(', ', $must_see_attractions) : 'traveler has not specified any must-see attractions')

                ],
                [
                    'role' => 'user',
                    'content' => "Plan a well-thought-out itinerary from {$from} to {$to} in {$destination} with a maximum budget of {$budget}.

    Use all your expertise to consider:
1. First and last days should have fewer activities for travel logistics
2. Prioritize must-see attractions and essential travel experiences
3. Plan meals based on the available budget:
   - For very tight budgets: Suggest 'bring food from home' or 'visit local grocery stores' for most meals
   - For tight budgets: Include affordable local eateries and 'bring food from home' for some meals
   - For moderate budgets: Include authentic local restaurants with reasonable prices
   - For comfortable budgets: Recommend quality dining experiences focusing on local cuisine
4. Plan a logical geographical sequence to minimize travel time
5. Account for weather conditions during this period
6. Balance indoor and outdoor activities
7. Include cultural, historical, and local experiences
8. Consider advance booking requirements for popular attractions
9. Whenever you don't mention a specific place to eat in the description, explicitly note 'bring food from home'
10. Fill each day with a complete schedule of activities:
    - Include specific morning, afternoon, and evening activities
    - Add 3-5 attractions per day based on the activity pace preference
    - Ensure no significant gaps in the daily schedule
    - Include evening entertainment or activities for each day
    - Balance major attractions with smaller, local experiences
    - Mix different types of activities (historical, cultural, natural, etc.)
    - Add free or low-cost activities to fill time between major attractions
11. Balance a full schedule with budget considerations:
    - Include a mix of paid and free activities to fill the day
    - Suggest free alternatives when budget is tight
    - Recommend city passes or multi-attraction tickets when cost-effective
    - Group activities geographically to minimize transportation costs
    - Include budget-saving tips specific to the destination
12. Ensure all addresses are formatted for Google Maps:
    - Use complete, accurate names for all locations
    - Include street addresses for less-known places
    - Always add the city name to every address
    - For areas without specific addresses, use main entrances or central points
13. Do not repeat the same place.

However, return ONLY a simplified JSON in exactly this format:


\"{
  \\\"day 1\\\": {
    \\\"places\\\": [
      {
        \\\"address\\\": \\\"Full address or Name, City\\\"
      },
      {
        \\\"address\\\": \\\"Another address\\\"
      }
    ],
    \\\"description\\\": \\\"Summary of day 1 activities and highlights with budget considerations.\\\",
    \\\"transportation\\\": \\\"CAR\\\",
    \\\"booking_urls\\\":
    {
        \\\"place_name_example\\\" : \\\"https://example.com/booking1\\\",
       \\\"place_name_example_2\\\" :  \\\"https://example.com/booking2\\\"
    }
  },
  \\\"day 2\\\": {
    \\\"places\\\": [
      ...
    ],
    \\\"description\\\": \\\"Summary of day 2 with budget-conscious meal recommendations.\\\",
    \\\"transportation\\\": \\\"WALK\\\",
    \\\"booking_urls\\\": {
    }
  }
}\"
```json
"
        ],
        ],

            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.1,
            'max_tokens' => 10000
        ]);

		$itinerary = json_decode($response['choices'][0]['message']['content'], true) ?? null;

		return $itinerary;
	}
}
