<?php

namespace App\Filament\Resources\ProductVariantImageResource\Pages;

use App\Filament\Resources\ProductVariantImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariantImage extends EditRecord
{
    protected static string $resource = ProductVariantImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
