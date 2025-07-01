<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate SKU for each variant if not provided
        if (isset($data['variants']) && is_array($data['variants'])) {
            $base = strtoupper(\Illuminate\Support\Str::slug($data['name'] ?? 'product'));

            foreach ($data['variants'] as $i => &$variant) {
                if (empty($variant['sku'])) {
                    $optionPart = '';

                    if (isset($variant['options']) && is_array($variant['options'])) {
                        $optionPart = collect($variant['options'])
                            ->pluck('value')
                            ->map(fn($val) => strtoupper(\Illuminate\Support\Str::slug($val)))
                            ->implode('-');
                    }

                    $sku = $base . ($optionPart ? '-' . $optionPart : '');

                    // Make sure SKU is unique (optional)
                    $originalSku = $sku;
                    $suffix = 1;
                    while (\App\Models\ProductVariant::where('sku', $sku)->exists()) {
                        $sku = $originalSku . '-' . $suffix++;
                    }

                    $variant['sku'] = $sku;
                }
            }

            $data['variants'] = $variant;
        }

        return $data;
    }
}
