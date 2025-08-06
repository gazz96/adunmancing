<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'recipient_name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'province_id' => 'required|string|max:100',
            'province_name' => 'required|string|max:100',
            'city_id' => 'required|string|max:100',
            'city_name' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string',
            'destination_type' => 'required|string|max:100',
            'is_default' => 'sometimes|boolean'
        ]);

        // If setting as default, unset other defaults
        if ($request->is_default) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        $address = UserAddress::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'recipient_name' => $request->recipient_name,
            'phone_number' => $request->phone_number,
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,
            'city_id' => $request->city_id,
            'city_name' => $request->city_name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'destination_type' => $request->destination_type,
            'is_default' => $request->is_default ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil disimpan.',
            'address' => $address
        ]);
    }
    
    public function setDefault(Request $request)
    {
        $request->validate([
            'address_id' => 'required|integer|exists:user_addresses,id'
        ]);
        
        $addressId = $request->address_id;
        
        // Pastikan alamat milik user yang sedang login
        $address = UserAddress::where('id', $addressId)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan atau bukan milik Anda.'
            ], 404);
        }
        
        // Set semua alamat user menjadi tidak default
        UserAddress::where('user_id', Auth::id())
            ->update(['is_default' => false]);
            
        // Set alamat yang dipilih sebagai default
        $address->update(['is_default' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dijadikan alamat utama.',
            'address' => $address
        ]);
    }
}
