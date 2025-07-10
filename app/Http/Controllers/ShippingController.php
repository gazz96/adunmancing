<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    //

    protected $rajaOngkirApiKey = "c598aad3a535dd0da4da14fb4d8b3508";

    public function getProvinces(Request $request)
    {
        $provinceId = $request->provinceId;
        $cacheKey = 'rajaongkir_province_' . now()->format('Y_m_d'); // unique key per day

        // Set expiration to midnight
        $expiresAt = Carbon::tomorrow();

        $data = Cache::remember($cacheKey, $expiresAt, function () use ($provinceId) {
            $response = Http::withHeaders([
                'key' => $this->rajaOngkirApiKey,
            ])->get('https://pro.rajaongkir.com/api/province', [
                'id' => $provinceId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch data from RajaOngkir: ' . $response->body());
        });

        return response()->json($data);
    }

    public function getRegencies(Request $request)
    {

        $curl = curl_init();

        $cityId = $request->cityId;
        $provinceId = $request->provinceId;
        $cacheKey = 'rajaongkir_city_' . $cityId . '_' . $provinceId . '_' . now()->format('Y_m_d'); // unique key per day

        // Set expiration to midnight
        $expiresAt = Carbon::tomorrow();

        $data = Cache::remember($cacheKey, $expiresAt, function () use ($provinceId, $cityId) {
            $response = Http::withHeaders([
                'key' => $this->rajaOngkirApiKey,
            ])->get('https://pro.rajaongkir.com/api/city', [
                'province' => $provinceId,
                'id' => $cityId
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch data from RajaOngkir: ' . $response->body());
        });

        return response()->json($data);
    }

}
