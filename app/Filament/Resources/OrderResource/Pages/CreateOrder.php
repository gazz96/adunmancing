<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
        // Ensure items are properly formatted before creating the order
        if (isset($data['items'])) {
            foreach ($data['items'] as &$item) {
                $item['subtotal'] = (float) $item['price'] * (int) $item['quantity'];
            }
        }

        return $data;
    }
}
