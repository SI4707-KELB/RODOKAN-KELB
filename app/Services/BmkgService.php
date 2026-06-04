<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BmkgService
{
    public function getLatestEarthquake(): ?array
    {
        $cached = Cache::get('bmkg_earthquake');
        if ($cached !== null && is_array($cached)) {
            return $cached;
        }

        try {
            $response = Http::timeout(8)->get('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');

            if ($response->successful()) {
                $data = $response->json();
                $gempa = $data['Infogempa']['gempa'] ?? null;
                if ($gempa) {
                    Cache::put('bmkg_earthquake', $gempa, now()->addMinutes(5));
                }
                return $gempa;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    public function getWeather(): ?array
    {
        $cached = Cache::get('bmkg_weather');
        if ($cached !== null && is_array($cached)) {
            return $cached;
        }

        try {
            $response = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m',
                'hourly' => 'temperature_2m,weather_code,precipitation_probability,wind_speed_10m',
                'daily' => 'temperature_2m_max,temperature_2m_min,weather_code',
                'timezone' => 'Asia/Jakarta',
                'forecast_days' => 5,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('bmkg_weather', $data, now()->addMinutes(30));
                return $data;
            }
        } catch (\Exception $e) {
            // Proceed to fallback
        }

        return $this->getMockWeather();
    }

    public function getMockWeather(): array
    {
        $tz = 'Asia/Jakarta';
        $today = \Carbon\Carbon::today($tz);
        
        $hourlyTimes = [];
        $hourlyTemp = [];
        $hourlyCode = [];
        $hourlyRain = [];
        $hourlyWind = [];

        // Generate 5 days * 24 hours of mock data
        for ($day = 0; $day < 5; $day++) {
            $date = $today->copy()->addDays($day);
            for ($hour = 0; $hour < 24; $hour++) {
                $timeStr = $date->copy()->hour($hour)->format('Y-m-d\TH:00');
                $hourlyTimes[] = $timeStr;
                
                // Typical temp cycle: coolest at 5am (20°C), warmest at 1pm (30°C)
                $temp = 25 + 5 * sin((($hour - 7) / 24) * 2 * M_PI);
                $hourlyTemp[] = round($temp, 1);
                
                // Weather code: rain in afternoon, clear/cloudy elsewhere
                if ($hour >= 13 && $hour <= 17) {
                    $code = 61; // Rain
                    $rain = 80;
                } elseif ($hour >= 18 || $hour <= 6) {
                    $code = 2; // Berawan
                    $rain = 10;
                } else {
                    $code = 1; // Cerah berawan
                    $rain = 20;
                }
                
                $hourlyCode[] = $code;
                $hourlyRain[] = $rain;
                $hourlyWind[] = rand(5, 15);
            }
        }

        return [
            'current' => [
                'temperature_2m' => 28.5,
                'relative_humidity_2m' => 75,
                'apparent_temperature' => 30.2,
                'weather_code' => 1,
                'wind_speed_10m' => 12.5,
            ],
            'hourly' => [
                'time' => $hourlyTimes,
                'temperature_2m' => $hourlyTemp,
                'weather_code' => $hourlyCode,
                'precipitation_probability' => $hourlyRain,
                'wind_speed_10m' => $hourlyWind,
            ],
            'daily' => [
                'time' => array_map(fn($d) => $today->copy()->addDays($d)->format('Y-m-d'), range(0, 4)),
                'temperature_2m_max' => [31.2, 30.5, 31.0, 29.8, 30.2],
                'temperature_2m_min' => [21.5, 22.0, 21.8, 20.5, 21.0],
                'weather_code' => [1, 2, 61, 1, 61],
            ]
        ];
    }
}
