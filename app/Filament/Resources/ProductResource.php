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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Get;
use Filament\Forms\Set;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Product Management';

    public function mounted()
    {
        dd('testing');
    }

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
                        ->numeric(),

                    TextInput::make('compare_price')
                        ->label('Harga Coret')
                        ->numeric(),

                    Toggle::make('status')
                        ->label('Aktif')
                        ->default(true),

                    FileUpload::make('featured_image')
                        ->label('Gambar Unggulan')
                        ->image()
                        ->disk('public')
                        ->directory('product')
                        ->visibility('public')
                        ->columnSpanFull()
                        ->previewable(false)
                        ->nullable(),
                ]),

                Section::make('Kategori')
                    ->schema([
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->preload()
                            ->searchable()
                            ->label('Kategori')
                    ]),

               
                Repeater::make('attributes')
                    ->label('Atribut Produk')
                    ->relationship('attributes')
                    ->schema([
                        Select::make('attribute_id')
                            ->label('Atribut')
                            ->options(\App\Models\Attribute::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Toggle::make('show_in_product')
                            ->label('Tampilkan di Halaman Produk'),
                        Toggle::make('use_as_variation')
                            ->label('Gunakan sebagai Variasi'),
                    ])
                    ->columns(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->columnSpanFull(),

                // Section::make('Variasi Produk')
                //     ->schema([
                //         Repeater::make('variants')
                //             ->label('Variasi Produk')
                //             ->relationship('variants')
                //             ->schema([
                //                 TextInput::make('name')
                //                     ->label('Nama Variasi')
                //                     ->required(),
                //                 TextInput::make('sku')
                //                     ->label('SKU'),
                //                 TextInput::make('price')
                //                     ->label('Harga')
                //                     ->numeric(),
                //                 FileUpload::make('featured_image')
                //                     ->label('Gambar Variasi')
                //                     ->image()
                //                     ->disk('public')
                //                     ->directory('product/variants')
                //                     ->visibility('public'),
                //             ])
                //             ->columns(1)
                //             ->defaultItems(0)
                //             ->collapsible()
                //             ->columnSpanFull(),
                //     ]),

        ]);
    }

    public static function getAttributesForm($form)
    {


        $attributes = \App\Models\Attribute::all();
        $forms = [];

        foreach ($attributes as $attribute) {

            if(!$attribute->values) {
                continue; // Skip attributes without values
            }

            $values = [];

            foreach(explode('|', $attribute->values) as $value) {
                $values[trim($value)] = trim($value);
            }

            $forms[] = Select::make('attributes.' . $attribute->slug)
                ->label($attribute->name)
                ->options($values);
        }

        return $forms;
    }  

    public static function table(Table $table): Table
    {
        return  $table
        ->columns([
            Tables\Columns\ImageColumn::make('featured_image_url')
                ->square()
                ->label('Gambar'),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('price')->money('IDR', true),
            Tables\Columns\ToggleColumn::make('status')
                ->label('Aktif')
                ->sortable()
                ->toggleable(),
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
