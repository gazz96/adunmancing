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

        $data = collect($data['rajaongkir']['results']);

        return response()->json($data);
    }

    public function getCost(Request $request)
    {
 
        // $response = Http::asForm()->withHeaders([
        //     'key' => $this->rajaOngkirApiKey, // pastikan ini ada di .env
        // ])->post('https://pro.rajaongkir.com/api/cost', [
        //     'origin' => 501,
        //     'originType' => 'city',
        //     'destination' => 574,
        //     'destinationType' => 'subdistrict',
        //     'weight' => 1700,
        //     'courier' => 'jne',
        // ]);

        // $data = $response->json(); // hasil respons JSON

        // return response()->json($data); // atau sesuai kebutuhan
        $request->validate([
            //'destination' => 'required|numeric',
            //'weight' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        $originId  = Option::getByKey('store_regency_id');
        $origin = Regency::find($originId);
        $destination = UserAddress::where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();

        $cartItems = collect(Auth::check()
            ? $this->getCartFromDB(Auth::id())
            : $this->getCartFromSession());

        if (count($cartItems) === 0) {
            return back()->with('error', 'Cart is empty.');
        }

        $total_weight = 0;

        foreach($cartItems as $cartItem)
        {
            $product_weight = (double)Product::find($cartItem['product_id'])->weight ?? 0;
            $total_weight +=  $product_weight * (double)$cartItem['quantity'];
        }

        if($total_weight < 1000) {
            $total_weight = 1000;
        }
        
        $data = [
            'origin' => $originId,
            'originType' => 'city',
            'destination' => $destination->city_id,
            'destinationType' => 'city',
            'weight' => $total_weight, // dalam gram
            'courier' => $request->courier, // jne, tiki, pos, dll
        ];


        //dd($data);

        $response = Http::withHeaders([
            'key' => $this->rajaOngkirApiKey,
        ])->post('https://pro.rajaongkir.com/api/cost', $data);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal menghubungi RajaOngkir'], 500);
        }

        return response()->json($response->json()['rajaongkir']);
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
