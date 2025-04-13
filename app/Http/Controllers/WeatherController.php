<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;



class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->store();

        $all = Weather::all()->where('user_id', Auth::id());
        $last = Weather::where('user_id', Auth::id())->orderByDesc('weather_time')->first();

        return view('dashboard', ['all' => $all, 'last' => $last]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $lat = Auth::user()->latitude;
        $lon = Auth::user()->longitude;


        $response = Http::get("https://api.open-meteo.com/v1/forecast", [
            'latitude' => $lat,
            'longitude' => $lon,
            'current_weather' => true
        ]);

        if ($response->successful()) {
            $data = $response->json()['current_weather'];

            if (Weather::where('weather_time', $data['time'])->exists()) { {
                    return redirect()->back()->with('message', 'Weather data already exists for this time.');
                }
            }

            Weather::create([
                'user_id' => Auth::id(),
                'temperature' => $data['temperature'],
                'is_day' => $data['is_day'], // 1 or 0
                'wind_speed' => $data['windspeed'],
                'wind_direction' => $data['winddirection'],
                'weather_time' => $data['time'],
            ]);

            return redirect()->route('dashboard')->with('success', 'Weather data saved!');
        }

        return redirect()->back()->with('error', 'Failed to fetch weather data.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Weather $weather)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weather $weather)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weather $weather)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weather $weather)
    {
        //
    }
}
