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

    public function getRegencies($cityId = null, $provinceId = null)
    {

        $curl = curl_init();

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
