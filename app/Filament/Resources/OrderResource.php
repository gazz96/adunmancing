<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
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
                            ->label('Kupon')
                            ->relationship('coupon', 'code')
                            ->searchable()
                            ->nullable()
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}"),

                        Repeater::make('items')
                            ->label('Order Items')
                            ->relationship('items')
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function($state, callable $set, callable $get){
                                        $product = \App\Models\Product::find($state);
                                        if ($product) {
                                            $set('price', $product->price);
                                            $set('subtotal', $product->price * ($get('quantity') ?? 1));
                                        }
                                    }),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->required()
                                    ->afterStateUpdated(
                                        fn($state, callable $set, callable $get) =>
                                        $set('subtotal', (float) $state * (int) $get('quantity'))
                                    )
                                    ->visible(fn($get) => $get('product_id') !== null),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function($state, callable $set, callable $get) {
                                        $set('subtotal', (float) $get('price') * (int)$state);
                                    }),

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

                        TextInput::make('subtotal')
                            ->disabled()
                            ->dehydrated()
                            ->numeric()
                            ->label('Subtotal')
                            ->afterStateHydrated(function($state, callable $set, callable $get) {
                                $total = collect($get('items'))->sum('subtotal');
                                $set('subtotal', $total);
                            }),
                        
                        TextInput::make('coupon_code')
                            ->label('Kode Kupon')
                            ->disabled()
                            ->placeholder('Tidak ada kupon'),
                            
                        TextInput::make('coupon_discount')
                            ->label('Diskon Kupon')
                            ->disabled()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('0'),
                            
                        TextInput::make('total_amount')
                            ->disabled()
                            ->dehydrated()
                            ->numeric()
                            ->label('Total Akhir')
                            ->prefix('Rp'),
                    ]),

                Section::make('Shipping Information')
                    ->schema([
                        TextInput::make('recepient_name')->disabled(),
                        TextInput::make('recepient_phone_number')->disabled(),
                        TextInput::make('address')->disabled(),
                        TextInput::make('destination_name')->disabled(),
                        TextInput::make('postal_code')->disabled(),
                        TextInput::make('courier')->disabled(),
                        TextInput::make('delivery_price')->disabled(),
                    ]),

                Section::make('Payment Information')
                    ->schema([
                        TextInput::make('payment_method')
                            ->disabled()
                            ->label('Payment Method'),

                        Select::make('payment_status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid', 
                                'failed' => 'Failed',
                            ])
                            ->default('pending'),

                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Payment Proof (Bukti Bayar)')
                            ->image()
                            ->directory('payment-proofs')
                            ->visibility('private')
                            ->downloadable()
                            ->openable()
                            ->hidden(fn($get) => ($get('payment_method') ?? '') !== 'bank_transfer'),

                        DatePicker::make('paid_at')
                            ->label('Paid At'),

                        Forms\Components\Textarea::make('payment_notes')
                            ->label('Payment Notes')
                            ->rows(3),
                    ]),

                Section::make('Status')
                    ->schema([
                        TextInput::make('awb')->label('Nomor Resi'),
                        DatePicker::make('send_date')->label('Send Date'),
                        Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'shipped' => 'Shipped',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                            ])
                            ->default('pending')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('Customer')->searchable(),
                TextColumn::make('payment_method')
                    ->label('Payment')
                    ->formatStateUsing(fn ($state) => $state ?? 'Not Set')
                    ->color(fn ($state) => $state ? 'primary' : 'gray'),
                    
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->formatStateUsing(fn ($state) => $state ?? 'pending')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'gray' => null,
                    ])
                    ->badge(),
                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti Bayar')
                    ->size(50)
                    ->visibility('private')
                    ->visible(fn($record) => $record && $record->payment_method === 'bank_transfer' && $record->payment_proof),
                TextColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'paid',
                        'warning' => 'shipped',
                        'danger' => 'cancelled',
                    ])
                    ->badge(),
                TextColumn::make('coupon_code')
                    ->label('Kupon')
                    ->badge()
                    ->color('success')
                    ->placeholder('Tidak ada kupon')
                    ->toggleable(),
                TextColumn::make('coupon_discount')
                    ->label('Diskon')
                    ->money('IDR')
                    ->placeholder('Rp 0')
                    ->visible(fn($record) => $record && $record->coupon_discount > 0)
                    ->toggleable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('total_amount')->money('IDR')->sortable()->label('Total'),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'midtrans' => 'Midtrans',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),
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
