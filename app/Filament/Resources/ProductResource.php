<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductImageRelationManagerResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Info Produk')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get) {
                            // Set slug otomatis & unik
                            $slug = \Illuminate\Support\Str::slug($state);
                            $originalSlug = $slug;
                            $i = 1;

                            while (Product::where('slug', $slug)
                                ->when($get('id'), fn ($query, $id) => $query->where('id', '!=', $id))
                                ->exists()) {
                                $slug = $originalSlug . '-' . $i++;
                            }

                            $set('slug', $slug);
                        }),

                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated(),

                // TextInput::make('sku')
                //     ->label('SKU (Kode Produk)')
                //     ->nullable()
                //     ->maxLength(20),

                RichEditor::make('description')
                    ->label('Deskripsi Produk')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletList',
                        'numberList',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->columns(1),

                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required(),

                TextInput::make('compare_price')
                    ->label('Harga Coret')
                    ->numeric()
                    ->nullable(),
            ])->columns(1),

            Section::make('Kategori')
                ->schema([
                    Select::make('categories')
                        ->multiple()
                        ->relationship('categories', 'name')
                        ->preload()
                        ->searchable()
                        ->label('Kategori')
                ]),

            Repeater::make('variants')
                ->relationship('variants')
                ->label('Product Variants')
                ->schema([
                    TextInput::make('sku')       
                        ->disabled()
                        ->dehydrated(false)
                        ->hint('Auto-generated on save'),
                    TextInput::make('price')->numeric()->required(),

                    // Options
                    Repeater::make('options')
                        ->relationship('options')
                        ->schema([
                            TextInput::make('option_name')->required(),  // e.g. "Color"
                            TextInput::make('option_value')->required(), // e.g. "Red"
                        ])
                        ->columns(2),

                    // Images
                    // FileUpload::make('images')
                    //     ->label('Variant Images')
                    //     ->multiple()
                    //     ->directory('variants')
                    //     ->relationship('images', 'image_path'),
                ])
                ->itemLabel('Add Variant')
                ->collapsible()
                ->columnSpanFull()

        ]);
    }

    public static function table(Table $table): Table
    {
        return  $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('price')->money('IDR', true),
            Tables\Columns\ToggleColumn::make('is_active'),
            Tables\Columns\TextColumn::make('categories.name')->label('Kategori')->badge()->limit(2),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])
        ->filters([
            //Tables\Filters\TrashedFilter::make(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
