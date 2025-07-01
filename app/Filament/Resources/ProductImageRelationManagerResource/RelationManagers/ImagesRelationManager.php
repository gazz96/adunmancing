<?php

namespace App\Filament\Resources\ProductImageRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('path')
                    ->label('Image URL')
                    ->required()
                    ->image()
                    ->visibility('public')
                    ->disk('public') // Specify the disk if needed
                    ->preserveFilenames()
                    ->maxSize(1024) // 1MB
                    ->directory('product-images')
                    ->previewable(false)
                    ->acceptedFileTypes(['image/*'])
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->disk('public') // Specify the disk if needed
                    ->url(fn ($record) => $record->getImageUrlAttribute()) // Use accessor
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('path'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
