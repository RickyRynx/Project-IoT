<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class SecondSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $firebaseUrl = 'https://tes-iot-9e4d4-default-rtdb.asia-southeast1.firebasedatabase.app/sensor2.json';
        $client = new Client();

        try {
            // Fetch data dari Firebase
            $response = $client->get($firebaseUrl, ['verify' => false]);
            $data = json_decode($response->getBody(), true);

            // Data olahan untuk Blade
            $temperature = $data['temperature'] ?? null;
            $condition = $temperature < 20 ? 'Dingin' : ($temperature <= 30 ? 'Normal' : 'Panas');
            $description = $condition == 'Dingin' ? 'Air terlalu dingin' : ($condition == 'Normal' ? 'Air dalam kondisi baik' : 'Air terlalu panas');

            return view('secondsensor.index', compact('user', 'temperature', 'condition', 'description'));
        } catch (\Exception $e) {
            // Tangani error
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
