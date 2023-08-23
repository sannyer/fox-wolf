<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\WeatherData;
use App\Http\Services\OpenWeatherMapService;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    
    public function getWeatherByCity(Request $request, $cityName)
    {
        $city = City::where('name', $cityName)->first();
        if (!$city) {
            return response()->json(['error' => 'City not found'], 404);
        }
        // fetch last 24 hours of weather data for the city
        $weatherData = WeatherData::where('city_id', $city->id)->orderBy('created_at', 'desc')->take(24)->get();
      
        $result = [];
        foreach ($weatherData as $wd) {
            $result[] = [
                'city' => $city->name,
                'location_name' => $wd->location_name,
                'lat' => $wd->lat,
                'lon' => $wd->lon,
                'temperature' => $wd->temperature,
                'pressure' => $wd->pressure,
                'humidity' => $wd->humidity,
                'min_temp' => $wd->min_temp,
                'max_temp' => $wd->max_temp,
                'timestamp' => $wd->created_at,
            ];
        }
        return response()->json($result);
    }

    public function getLiveWeatherByCity(Request $request, $cityName)
    {
        $weatherData = $this->queryWeatherByCity($cityName);
        return response()->json($weatherData);
    }
    
    private function queryWeatherByCity($cityName)
    {
        $cityName = urldecode($cityName);
        $city = City::where('name', $cityName)->first();

        $owm = new OpenWeatherMapService();
        if (!$city) {
            $cityCoordinates = $owm->queryCityCoordinates($cityName);
            $city = City::create([
                'name' => $cityName,
                'lat' => $cityCoordinates['lat'],
                'lon' => $cityCoordinates['lon'],
            ]);
        }

        $weatherData = $owm->queryWeatherData($city->lat, $city->lon);

        return $weatherData;
    }

    public function updateWeatherData()
    {
        $cities = City::all();
        $count = 0;
        foreach ($cities as $city) {
            try {
                $weatherData = $this->queryWeatherByCity($city->name);
                WeatherData::create([
                    'city_id' => $city->id,
                    'location_name' => $weatherData->name,
                    'temperature' => $weatherData->main->temp,
                    'pressure' => $weatherData->main->pressure,
                    'humidity' => $weatherData->main->humidity,
                    'lat' => $weatherData->coord->lat,
                    'lon' => $weatherData->coord->lon,
                    'min_temp' => $weatherData->main->temp_min,
                    'max_temp' => $weatherData->main->temp_max,
                ]);
                $count++;
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        return response()->json(['message' => "Updated {$count} cities"]);
    }

    public function getWeatherSchema(Request $request)
    {
        $schema = [
            'city' => 'string',
            'location_name' => 'string',
            'lat' => 'float',
            'lon' => 'float',
            'temperature' => 'float',
            'pressure' => 'integer',
            'humidity' => 'integer',
            'min_temp' => 'float',
            'max_temp' => 'float',
            'timestamp' => 'timestamp',
        ];

        return response()->json($schema);
    }

}
