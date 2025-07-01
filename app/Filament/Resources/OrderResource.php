<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('coupon_id')
                            ->label('Coupon')
                            ->relationship('coupon', 'code')
                            ->searchable()
                            ->nullable(),

                        Repeater::make('items')
                            ->label('Order Items')
                            ->relationship()
                            ->schema([
                                Select::make('product_variant_id')
                                    ->label('Variant')
                                    ->relationship('variant', 'sku')
                                    ->searchable()
                                    ->required(),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->afterStateHydrated(
                                        fn($state, callable $set, callable $get) =>
                                        $set('subtotal', (float) $get('price') * (int) $get('quantity'))
                                    ),
                            ])
                            ->columns(4)
                            ->itemLabel('Add Item'),

                        TextInput::make('total')
                            ->disabled()
                            ->dehydrated()
                            ->numeric()
                            ->label('Total'),
                    ]),

                Section::make('Shipping Information')
                    ->schema([
                        TextInput::make('shipping.recipient_name')->required(),
                        TextInput::make('shipping.phone')->required(),
                        TextInput::make('shipping.address')->required(),
                        TextInput::make('shipping.city')->required(),
                        TextInput::make('shipping.postal_code')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('Customer')->searchable(),
                TextColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'paid',
                        'warning' => 'shipped',
                        'danger' => 'cancelled',
                    ])
                    ->badge(),
                TextColumn::make('total')->money('IDR')->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
