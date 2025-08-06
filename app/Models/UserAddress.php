<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'recipient_name',
        'phone_number',
        'province_id',
        'province_name',
        'regency_id',
        'city_id',
        'city_name',
        'district_id',
        'postal_code',
        'destination_type',
        'address',
        'is_default',
    ];
    
    protected $appends = [
        'full_address',
        'shipping_label',
        'complete_shipping_info',
        'checkout_display'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
    /**
     * Get full address with complete location info
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        
        if ($this->address) {
            $parts[] = $this->address;
        }
        
        if ($this->city_name) {
            $parts[] = $this->city_name;
        }
        
        if ($this->province_name) {
            $parts[] = $this->province_name;
        }
        
        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }
        
        return implode(', ', $parts);
    }
    
    /**
     * Get shipping label with name and address
     */
    public function getShippingLabelAttribute()
    {
        $label = '';
        
        if ($this->name) {
            $label .= $this->name;
        }
        
        if ($this->address) {
            $label .= ($label ? ' | ' : '') . $this->address;
            
            if ($this->city_name) {
                $label .= ', ' . $this->city_name;
            }
            
            if ($this->province_name) {
                $label .= ', ' . $this->province_name;
            }
            
            if ($this->postal_code) {
                $label .= ' ' . $this->postal_code;
            }
        }
        
        return $label;
    }
    
    /**
     * Get complete shipping information including recipient details
     */
    public function getCompleteShippingInfoAttribute()
    {
        $info = [];
        
        // Nama alamat
        if ($this->name) {
            $info['address_name'] = $this->name;
        }
        
        // Detail penerima
        if ($this->recipient_name) {
            $info['recipient'] = $this->recipient_name;
        }
        
        if ($this->phone_number) {
            $info['phone'] = $this->phone_number;
        }
        
        // Alamat lengkap
        $info['full_address'] = $this->full_address;
        
        // Format untuk tampilan
        $display_parts = [];
        
        if (isset($info['address_name'])) {
            $display_parts[] = "📍 {$info['address_name']}";
        }
        
        if (isset($info['recipient'])) {
            $display_parts[] = "👤 {$info['recipient']}";
        }
        
        if (isset($info['phone'])) {
            $display_parts[] = "📞 {$info['phone']}";
        }
        
        if (isset($info['full_address'])) {
            $display_parts[] = "🏠 {$info['full_address']}";
        }
        
        return [
            'data' => $info,
            'display' => implode("\n", $display_parts),
            'html' => '<div class="shipping-info">' . 
                     '<div><strong>' . ($info['address_name'] ?? 'Alamat') . '</strong></div>' .
                     (isset($info['recipient']) ? '<div>Penerima: ' . $info['recipient'] . '</div>' : '') .
                     (isset($info['phone']) ? '<div>Telepon: ' . $info['phone'] . '</div>' : '') .
                     '<div class="text-muted">' . $info['full_address'] . '</div>' .
                     '</div>'
        ];
    }
    
    /**
     * Get formatted address for checkout display
     */
    public function getCheckoutDisplayAttribute()
    {
        $display = '';
        
        if ($this->recipient_name) {
            $display .= $this->recipient_name;
        }
        
        if ($this->phone_number) {
            $display .= ($display ? ' • ' : '') . $this->phone_number;
        }
        
        if ($this->address) {
            $display .= ($display ? "\n" : '') . $this->address;
            
            if ($this->city_name || $this->province_name || $this->postal_code) {
                $location_parts = array_filter([
                    $this->city_name,
                    $this->province_name,
                    $this->postal_code
                ]);
                $display .= ', ' . implode(', ', $location_parts);
            }
        }
        
        return $display;
    }
}
