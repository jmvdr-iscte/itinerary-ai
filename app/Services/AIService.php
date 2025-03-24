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

	//TODO: add prompt
	protected static $constant = 'prompt';



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
        ?array $activity_pace = null,
        ?array $must_see_attractions = null
    ): ?array
    {
        $response = $this->getClient()->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert travel planner. When creating an itinerary, consider all these detailed factors:

    - Time slots for each activity (morning, afternoon, evening)
    - Activity types (breakfast, lunch, dinner, sightseeing, museums, etc.)
    - Estimated costs for budgeting purposes
    - Transportation methods between locations
    - Weather considerations for the time period
    - Logical geographical flow to minimize travel time
    - Group size and dynamics
    - Spacing meals appropriately throughout the day
    - Including at least 3 meals daily prioritizing local restaurants
    - Planning 2-3 activities per day at an appropriate pace
    - Including evening entertainment where culturally appropriate

    However, your response should ONLY include a simplified JSON with days as keys, and for each day:
    1. An array of "places" with name and address
    2. A "description" summarizing the day\'s activities
    3. The transportation method for the day, from the transportation options provided.

    Categories to focus on: ' . implode(', ', $categories) . '.
    Transportation available: ' . implode(', ', $transportation) . '.
    Group size: ' . $people_number . ' people.
    Total budget: $' . $budget . ' for the entire trip.' .
    'Activity pace preference: ' . (!empty($activity_pace) ? implode(', ', $activity_pace) : 'moderate') . '.
    Must-see attractions: ' . (!empty($must_see_attractions) ? implode(', ', $must_see_attractions) : 'traveler has not specified any must-see attractions')

                ],
                [
                    'role' => 'user',
                    'content' => "Plan a well-thought-out itinerary from {$from} to {$to} in {$destination} with a maximum budget of {$budget}.

    Use all your expertise to consider:
    1. First and last days should have fewer activities for travel logistics
    2. Include breakfast, lunch, and dinner options prioritizing authentic local restaurants in every day
    3. Plan a logical geographical sequence to minimize travel time
    4. Account for weather conditions during this period
    5. Balance indoor and outdoor activities
    6. Include cultural, historical, and local experiences
    7. Consider advance booking requirements for popular attractions

    However, return ONLY a simplified JSON in exactly this format:

    ```json
    {
      \"day 1\": {
        \"places\": [
          {
            \"address\": \"Full address or Name, City\"
          },
          {
            \"address\": \"Another address\"
          }
        ],
        \"description\": \"Summary of day 1 activities and highlights.\",
        \"transportation\": \"CAR\"
      },
      \"day 2\": {
        \"places\": [
          ...
        ],
        \"description\": \"Summary of day 2.\",
        \"transportation\": \"WALK\"
            }
            }The returned JSON must strictly follow this format to be processed correctly."
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
