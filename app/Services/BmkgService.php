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
                'forecast_days' => 2,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('bmkg_weather', $data, now()->addMinutes(30));
                return $data;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
