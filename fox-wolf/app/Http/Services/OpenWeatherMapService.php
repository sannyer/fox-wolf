<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class OpenWeatherMapService
{

    private $apiKey;
    private $apiUrl;
    private $geoApiUrl;

    public function __construct()
    {
        $this->apiKey = env('OWM_API_KEY');
        $this->apiUrl = env('OWM_API_URL');
        $this->geoApiUrl = env('OWM_API_GEO_URL');
    }

    public function queryWeatherData($lat, $lon)
    {
        $client = new Client();
        $url = $this->apiUrl . "?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric";

        $response = $client->get($url);
        $weatherData = json_decode($response->getBody());

        return $weatherData;
    }

    public function queryCityCoordinates($cityName)
    {
        $cityName = urldecode(trim($cityName));
        $client = new Client();
        $url = $this->geoApiUrl . "?q={$cityName}&appid={$this->apiKey}";

        $response = $client->get($url);
        $responseBody = json_decode($response->getBody());

        if (count($responseBody) === 0) {
            throw new \Exception('City not found');
        }

        $cityData = [
            'lat' => $responseBody[0]->lat,
            'lon' => $responseBody[0]->lon,
        ];

        return $cityData;
    }
}