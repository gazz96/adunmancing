<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Rajaongkir
{
    
    public static $instance = null;
    protected $rajaOngkirApiKey = "c598aad3a535dd0da4da14fb4d8b3508";
    public $couriers = [
        'jne'       => 'JNE Express',
        'pos'       => 'POS Indonesia',
        'tiki'      => 'TIKI',
        'rpx'       => 'RPX Express',
        'pandu'     => 'Pandu Logistics',
        'wahana'    => 'Wahana Prestasi Logistik',
        'sicepat'   => 'SiCepat Ekspres',
        'jnt'       => 'J&T Express',
        'pahala'    => 'Pahala Kencana Express',
        'sap'       => 'SAP Express',
        'jet'       => 'J-Express (JET)',
        'indah'     => 'Indah Cargo',
        'dse'       => '21 Express (DSE)',
        'slis'      => 'Solusi Ekspres (SLIS)',
        'first'     => 'First Logistics',
        'ncs'       => 'Nusantara Card Semesta (NCS)',
        'star'      => 'Star Cargo',
        'ninja'     => 'Ninja Xpress',
        'lion'      => 'Lion Parcel',
        'idl'       => 'IDL Cargo',
        'rex'       => 'REX Kiriman Express',
        'ide'       => 'ID Express',
        'sentral'   => 'Sentral Cargo',
        'anteraja'  => 'AnterAja',
        'jtl'       => 'JTL Express',
    ];


    public static function new() 
    {
        if(!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getCouriers()
    {
        return $this->couriers;
    }

    public function getProvinces($provinceId = null)
    {
        $cacheKey = 'rajaongkir_province_' . now()->format('Y_m_d'); // unique key per day

        // Set expiration to midnight
        $expiresAt = Carbon::tomorrow();

        $data = Cache::remember($cacheKey, $expiresAt, function () use ($provinceId) {
            $response = Http::withHeaders([
                'Key' => $this->rajaOngkirApiKey, // Updated header key
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province', [
                'id' => $provinceId,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                // Return only the provinces data array
                return $result['data'] ?? [];
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch data from RajaOngkir: ' . $response->body());
        });

        return $data; // Return data directly, not as JSON response
    }

    public function getRegencies($cityId = null, $provinceId = null)
    {
        $cacheKey = 'rajaongkir_city_' . $cityId . '_' . $provinceId . '_' . now()->format('Y_m_d'); // unique key per day

        // Set expiration to midnight
        $expiresAt = Carbon::tomorrow();

        $data = Cache::remember($cacheKey, $expiresAt, function () use ($provinceId, $cityId) {
            $url = 'https://rajaongkir.komerce.id/api/v1/destination/city';
            
            // If specific city requested, use ID in URL path
            if ($cityId) {
                $url .= '/' . $cityId;
            } else if ($provinceId) {
                // If only province, use province ID in URL path
                $url .= '/' . $provinceId;
            }
            
            $response = Http::withHeaders([
                'Key' => $this->rajaOngkirApiKey, // Updated header key
            ])->get($url);

            if ($response->successful()) {
                $result = $response->json();
                // Return only the cities data array
                return $result['data'] ?? [];
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch data from RajaOngkir: ' . $response->body());
        });

        return $data; // Return data directly, not as JSON response
    }
    
    public function getCost($origin, $destination, $weight, $couriers = null)
    {
        $cacheKey = 'rajaongkir_cost_' . $origin . '_' . $destination . '_' . $weight . '_' . now()->format('Y_m_d_H');
        
        // Cache untuk 1 jam
        $expiresAt = now()->addHour();
        
        $data = Cache::remember($cacheKey, $expiresAt, function () use ($origin, $destination, $weight, $couriers) {
            // Default couriers jika tidak diset
            if (!$couriers) {
                $couriers = 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse';
            }
            
            $requestData = [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $couriers,
                'price' => 'lowest'
            ];
            
            $response = Http::asForm()->withHeaders([
                'Key' => $this->rajaOngkirApiKey,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', $requestData);

            if ($response->successful()) {
                $result = $response->json();
                // Return only the data array
                return $result['data'] ?? $result;
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch cost from RajaOngkir: ' . $response->body());
        });

        return $data;
    }

}
