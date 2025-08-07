<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    
    protected static ?string $navigationLabel = 'Atribut Produk';
    
    protected static ?string $modelLabel = 'Atribut';
    
    protected static ?string $pluralModelLabel = 'Atribut';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Atribut')
                    ->required()
                    ->maxLength(150),
                    
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->maxLength(150)
                    ->helperText('Biarkan kosong untuk generate otomatis dari nama'),
                    
                Forms\Components\Select::make('type')
                    ->label('Tipe Atribut')
                    ->required()
                    ->options([
                        'select' => 'Select (Dropdown)',
                        'color' => 'Color (Warna)',
                        'size' => 'Size (Ukuran)',
                        'radio' => 'Radio Button',
                    ])
                    ->default('select'),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->helperText('Angka kecil akan ditampilkan lebih dulu'),
                    
                Forms\Components\Toggle::make('is_required')
                    ->label('Wajib Dipilih')
                    ->helperText('Atribut ini wajib dipilih saat checkout'),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Atribut yang aktif akan ditampilkan di produk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Atribut')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'select',
                        'success' => 'color',
                        'warning' => 'size',
                        'info' => 'radio',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'select' => 'Select',
                        'color' => 'Color',
                        'size' => 'Size',
                        'radio' => 'Radio',
                        default => $state
                    }),
                    
                Tables\Columns\TextColumn::make('values_count')
                    ->label('Jumlah Value')
                    ->counts('values')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_required')
                    ->label('Wajib')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe Atribut')
                    ->options([
                        'select' => 'Select',
                        'color' => 'Color',
                        'size' => 'Size',
                        'radio' => 'Radio',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueLabel('Hanya yang aktif')
                    ->falseLabel('Hanya yang tidak aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
