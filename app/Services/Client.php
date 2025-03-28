<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

final class Client
{
    final public static function getClientRegion(Request $request): array
    {
        $ip = $request->ip();
        $cache_key = "ip_geolocation_{$ip}";
        $cache_duration = now()->addDays(7);
        $error = false;

        $data = Cache::remember($cache_key, $cache_duration, function () use ($ip, &$error) {
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");
                $data = $response->json();

                if (empty($data['country']) || empty($data['continent'])) {
                    Log::error("Invalid response data from IP-API for IP: {$ip}", $data);
                    $error = true;
                }

                return $data;
            } catch (\Exception $e) {
                Log::error("IP-API request failed for IP: {$ip}", ['exception' => $e->getMessage()]);
                $error = true;
                return null;
            }
        });

        return [
            'country' => $error || empty($data['country']) ? 'US' : $data['country'],
            'continent' => $error || empty($data['continent']) ? 'North America' : $data['continent'],
            'currency' => $error || empty($data['currency']) ? 'USD' : $data['currency']
        ];
    }
}
