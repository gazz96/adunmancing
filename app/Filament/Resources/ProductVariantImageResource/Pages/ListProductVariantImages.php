<?php

namespace App\Filament\Resources\ProductVariantImageResource\Pages;

use App\Filament\Resources\ProductVariantImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductVariantImages extends ListRecords
{
    protected static string $resource = ProductVariantImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
