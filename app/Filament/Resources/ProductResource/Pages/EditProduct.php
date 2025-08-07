<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing product attributes for editing
        $productAttributes = [];
        $productAttributeRecords = $this->record->productAttributes()->with('attribute')->get();
        
        foreach ($productAttributeRecords as $productAttribute) {
            $productAttributes[] = [
                'attribute_id' => $productAttribute->attribute_id,
                'attribute_values' => $productAttribute->attribute_values ?? []
            ];
        }
        
        $data['product_attributes'] = $productAttributes;
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove product_attributes from main data as we'll handle it separately
        $productAttributes = $data['product_attributes'] ?? [];
        unset($data['product_attributes']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $product = $this->record;
        $productAttributes = $data['product_attributes'] ?? [];

        // Remove existing product attributes
        $product->productAttributes()->delete();

        // Save new product attributes
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
