<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login

        // URL Firebase untuk sensor1 dan sensor2
        $firebaseUrlSensor1 = 'https://tes-iot-9e4d4-default-rtdb.asia-southeast1.firebasedatabase.app/sensor1.json';
        $firebaseUrlSensor2 = 'https://tes-iot-9e4d4-default-rtdb.asia-southeast1.firebasedatabase.app/sensor2.json';

        $client = new Client();
        try {
            // Mengambil data dari Firebase
            $responseSensor1 = $client->get($firebaseUrlSensor1, ['verify' => false]);
            $dataSensor1 = json_decode($responseSensor1->getBody(), true);

            $responseSensor2 = $client->get($firebaseUrlSensor2, ['verify' => false]);
            $dataSensor2 = json_decode($responseSensor2->getBody(), true);

            // Gabungkan data dari kedua sensor
            $historyData = [];
            if (is_array($dataSensor1)) {
                foreach ($dataSensor1 as $entry) {
                    $historyData[] = [
                        'time' => $entry['timestamp'] ?? '',
                        'sensor' => 'Sensor 1',
                        'temperature' => $entry['temperature_celsius'] ?? 0,
                    ];
                }
            }

            if (is_array($dataSensor2)) {
                foreach ($dataSensor2 as $entry) {
                    $historyData[] = [
                        'time' => $entry['timestamp'] ?? '',
                        'sensor' => 'Sensor 2',
                        'temperature' => $entry['temperature_celsius'] ?? 0,
                    ];
                }
            }

            // Urutkan data berdasarkan timestamp
            usort($historyData, function ($a, $b) {
                return strtotime($a['time']) - strtotime($b['time']);
            });

            return view('dashboard', compact('user', 'historyData'));
        } catch (\Exception $e) {
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
