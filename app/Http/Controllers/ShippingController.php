<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use App\Models\Regency;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    //https://api.collaborator.komerce.id/

    protected $rajaOngkirApiKey = "c598aad3a535dd0da4da14fb4d8b3508";

    public function getProvinces(Request $request)
    {
        $provinceId = $request->provinceId;
        $cacheKey = 'rajaongkir_province_' . now()->format('Y_m_d'); // unique key per day

        // Set expiration to midnight
        $expiresAt = Carbon::tomorrow();

        $data = Cache::remember($cacheKey, $expiresAt, function () use ($provinceId) {
            $response = Http::withHeaders([
                'Key' => $this->rajaOngkirApiKey,
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

        return response()->json($data);
    }

    public function getRegencies(Request $request)
    {
        $cityId = $request->cityId;
        $provinceId = $request->province_id ?? $request->provinceId;
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
                'Key' => $this->rajaOngkirApiKey,
            ])->get($url);

            if ($response->successful()) {
                $result = $response->json();
                // Return only the cities data array
                return $result['data'] ?? [];
            }

            // Optional: throw error or return null if API fails
            throw new \Exception('Failed to fetch data from RajaOngkir: ' . $response->body());
        });

        return response()->json($data);
    }

    public function getCost(Request $request)
    {
        $request->validate([
            'courier' => 'required|string', // Optional karena kita akan kirim semua courier
        ]);

        $originId = Option::getByKey('store_regency_id');
        
        // Ambil alamat tujuan berdasarkan user yang login
        $destination = UserAddress::where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();

        if (!$destination) {
            return response()->json(['error' => 'Alamat tujuan tidak ditemukan'], 400);
        }

        // Hitung total berat dari cart
        $cartItems = collect(Auth::check()
            ? $this->getCartFromDB(Auth::id())
            : $this->getCartFromSession());

        if (count($cartItems) === 0) {
            return response()->json(['error' => 'Cart kosong'], 400);
        }

        $total_weight = 0;
        foreach($cartItems as $cartItem) {
            $product_weight = (double)Product::find($cartItem['product_id'])->weight ?? 0;
            $total_weight += $product_weight * (double)$cartItem['quantity'];
        }

        // Minimum weight 1000 gram
        if($total_weight < 1000) {
            $total_weight = 1000;
        }

        // Daftar kurir yang didukung
        //$couriers = 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse';
        $couriers = $request->courier ?? 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse'; 
        // Data yang akan dikirim ke API
        $requestData = [
            'origin' => $originId,
            'destination' => $destination->city_id, // Menggunakan city_id dari alamat
            'weight' => $total_weight, // dalam gram
            'courier' => $couriers,
            'price' => 'lowest' // Ambil harga terendah
        ];

        // Log untuk debugging
        \Log::info('RajaOngkir Cost Request:', $requestData);

        try {
            $response = Http::asForm()->withHeaders([
                'Key' => $this->rajaOngkirApiKey,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', $requestData);

            if ($response->failed()) {
                \Log::error('RajaOngkir API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json(['error' => 'Gagal menghubungi RajaOngkir: ' . $response->body()], 500);
            }

            $result = $response->json();
            \Log::info('RajaOngkir Cost Response:', $result);

            // Return response dengan format yang lebih bersih
            return response()->json([
                'success' => true,
                'data' => $result,
                'request_info' => [
                    'origin' => $originId,
                    'destination' => $destination->city_id,
                    'weight' => $total_weight,
                    'couriers' => $couriers
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('RajaOngkir Cost Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghitung ongkos kirim',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function waybill(Request $request)
    {

    }

    private function getCartFromSession()
    {
        $cart = session('cart', []);
        return array_map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'variation' => $item['variation'],
                'quantity' => $item['quantity'],
                'product_attributes' => $item['product_attributes'] ?? null
            ];
        }, $cart);
    }

    private function getCartFromDB($userId)
    {
        return DB::table('cart_items')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'variation' => json_decode($item->variation, true),
                    'quantity' => $item->quantity,
                    'product_attributes' => $item->product_attributes
                ];
            })->toArray();
    }

}
