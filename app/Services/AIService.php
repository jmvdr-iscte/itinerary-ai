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
        string $origin,
        string $from,
        string $to,
        string $destination,
        array $categories,
        array $transportation,
        int $people_number
        ): array
	{
		$response = $this->getClient()->chat()->create([
		'model' => 'gpt-4o',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Generate a JSON object where keys are "day 1", "day 2", etc., and values are ordered arrays of place names.
                    Prioritize local restaurants.
                    Categories to include: ' . implode(', ', $categories) . '.
                    Transportation modes: ' . implode(', ', $transportation) . '.
                    Order places to minimize travel time for a group of ' . $people_number . ' people.'
            ],
            [
                'role' => 'user',
                'content' => "Plan a trip from {$origin} to {$destination}, starting on {$from} and ending on {$to}.
    Return only a JSON object with days as keys and lists of places per day."
            ],
        ],
        'response_format' => ['type' => 'json_object'],
        'temperature' => 0.2,
        'max_tokens' => 1000
	]);
		var_dump( $response['choices'][0]['message']['content']);

        return [];
	}
}
