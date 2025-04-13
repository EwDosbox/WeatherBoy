<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;

class FetchWeatherData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $lat = $user->latitude;
            $lon = $user->longitude;


            $response = Http::get("https://api.open-meteo.com/v1/forecast", [
                'latitude' => $lat,
                'longitude' => $lon,
                'current_weather' => true
            ]);

            if ($response->successful()) {
                $data = $response->json()['current_weather'];

                if (Weather::where('weather_time', $data['time'])->exists()) {
                    continue; // Skip if data already exists                  
                }


                Weather::create([
                    'user_id' =>  $user->id,
                    'temperature' => $data['temperature'],
                    'is_day' => $data['is_day'], // 1 or 0
                    'wind_speed' => $data['windspeed'],
                    'wind_direction' => $data['winddirection'],
                    'weather_time' => $data['time'],
                ]);
            }
        }
    }
}
