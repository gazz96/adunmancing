<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Size attribute
        $sizeAttribute = \App\Models\Attribute::create([
            'name' => 'Ukuran',
            'slug' => 'ukuran',
            'type' => 'size',
            'description' => 'Ukuran produk pancing',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true
        ]);

        // Create size values
        $sizeValues = [
            ['value' => 'S', 'label' => 'Small', 'sort_order' => 1],
            ['value' => 'M', 'label' => 'Medium', 'sort_order' => 2],
            ['value' => 'L', 'label' => 'Large', 'sort_order' => 3],
            ['value' => 'XL', 'label' => 'Extra Large', 'price_adjustment' => 25000, 'sort_order' => 4],
        ];

        foreach ($sizeValues as $value) {
            \App\Models\AttributeValue::create(array_merge($value, [
                'attribute_id' => $sizeAttribute->id,
                'is_active' => true
            ]));
        }

        // Create Color attribute
        $colorAttribute = \App\Models\Attribute::create([
            'name' => 'Warna',
            'slug' => 'warna', 
            'type' => 'color',
            'description' => 'Warna produk pancing',
            'sort_order' => 2,
            'is_required' => false,
            'is_active' => true
        ]);

        // Create color values
        $colorValues = [
            ['value' => 'merah', 'label' => 'Merah', 'color_code' => '#dc3545', 'sort_order' => 1],
            ['value' => 'biru', 'label' => 'Biru', 'color_code' => '#0d6efd', 'sort_order' => 2],
            ['value' => 'hijau', 'label' => 'Hijau', 'color_code' => '#198754', 'sort_order' => 3],
            ['value' => 'hitam', 'label' => 'Hitam', 'color_code' => '#000000', 'price_adjustment' => 15000, 'sort_order' => 4],
            ['value' => 'putih', 'label' => 'Putih', 'color_code' => '#ffffff', 'sort_order' => 5],
        ];

        foreach ($colorValues as $value) {
            \App\Models\AttributeValue::create(array_merge($value, [
                'attribute_id' => $colorAttribute->id,
                'is_active' => true
            ]));
        }

        // Create Material attribute
        $materialAttribute = \App\Models\Attribute::create([
            'name' => 'Material',
            'slug' => 'material',
            'type' => 'select',
            'description' => 'Jenis material produk',
            'sort_order' => 3,
            'is_required' => false,
            'is_active' => true
        ]);

        // Create material values
        $materialValues = [
            ['value' => 'carbon-fiber', 'label' => 'Carbon Fiber', 'price_adjustment' => 50000, 'sort_order' => 1],
            ['value' => 'fiberglass', 'label' => 'Fiberglass', 'price_adjustment' => 25000, 'sort_order' => 2],
            ['value' => 'bamboo', 'label' => 'Bambu', 'sort_order' => 3],
            ['value' => 'composite', 'label' => 'Composite', 'price_adjustment' => 35000, 'sort_order' => 4],
        ];

        foreach ($materialValues as $value) {
            \App\Models\AttributeValue::create(array_merge($value, [
                'attribute_id' => $materialAttribute->id,
                'is_active' => true
            ]));
        }
    }
}
