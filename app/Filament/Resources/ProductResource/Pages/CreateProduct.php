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
        // Remove product_attributes from main data as we'll handle it separately
        $productAttributes = $data['product_attributes'] ?? [];
        unset($data['product_attributes']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $data = $this->form->getState();
        $product = $this->record;
        $productAttributes = $data['product_attributes'] ?? [];

        // Save product attributes
        foreach ($productAttributes as $attr) {
            if (!empty($attr['attribute_id']) && !empty($attr['attribute_values'])) {
                \App\Models\ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attr['attribute_id'],
                    'attribute_values' => $attr['attribute_values']
                ]);
            }
        }
    }
}
