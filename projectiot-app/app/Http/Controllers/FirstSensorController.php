<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class FirstSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $firebaseUrl = 'https://tes-iot-9e4d4-default-rtdb.asia-southeast1.firebasedatabase.app/sensor1.json';
        $client = new Client();

        try {
            // Fetch data dari Firebase
            $response = $client->get($firebaseUrl, ['verify' => false]);
            $data = json_decode($response->getBody(), true);
    
            $sensors = [];
            $history = [];
            $latestTemperature = null;
            $condition = null;
            $description = null;
            $latestTimestamp = null;
    
            if (is_array($data)) {
                // Urutkan data berdasarkan suhu terkecil
                uasort($data, function($a, $b) {
                    return $a['temperature_celsius'] - $b['temperature_celsius']; // Mengurutkan suhu dari terkecil ke terbesar
                });
    
                // Ambil data dengan suhu terendah dan suhu tertinggi untuk grafik
                foreach ($data as $key => $value) {
                    $history[] = [
                        'time' => date('H:i:s', strtotime($value['timestamp'] ?? '')),
                        'temperature' => $value['temperature_celsius'] ?? null,
                    ];
                }
    
                // Tentukan kondisi air berdasarkan suhu
                $latestData = end($data); // Ambil data terakhir (tertinggi)
                if ($latestData) {
                    $latestTemperature = $latestData['temperature_celsius'] ?? null;
                    $latestTimestamp = $latestData['timestamp'] ?? null;
    
                    if ($latestTemperature < 20) {
                        $condition = 'Dingin';
                        $description = 'Air terlalu dingin';
                    } elseif ($latestTemperature <= 30) {
                        $condition = 'Normal';
                        $description = 'Air dalam kondisi baik';
                    } else {
                        $condition = 'Panas';
                        $description = 'Air terlalu panas';
                    }
                }
            }
    
            return view('firstsensor.index', compact('user', 'history', 'latestTemperature', 'condition', 'description', 'latestTimestamp'));
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
