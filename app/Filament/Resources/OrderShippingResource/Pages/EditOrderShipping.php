<?php

namespace App\Filament\Resources\OrderShippingResource\Pages;

use App\Filament\Resources\OrderShippingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderShipping extends EditRecord
{
    protected static string $resource = OrderShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
