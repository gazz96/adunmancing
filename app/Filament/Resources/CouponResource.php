<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    
    protected static ?string $navigationGroup = 'Sales & Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kupon')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Kupon')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder('Contoh: FISHING20'),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kupon')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Diskon 20% Semua Produk'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(500)
                            ->placeholder('Deskripsi singkat tentang kupon ini')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Diskon')
                    ->schema([
                        Forms\Components\Select::make('discount_type')
                            ->label('Jenis Diskon')
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'fixed' => 'Nominal Tetap (Rp)'
                            ])
                            ->default('percentage')
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('discount_percent')
                            ->label('Persentase Diskon (%)')
                            ->numeric()
                            ->min(0)
                            ->max(100)
                            ->suffix('%')
                            ->visible(fn ($get) => $get('discount_type') === 'percentage'),
                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Nominal Diskon (Rp)')
                            ->numeric()
                            ->min(0)
                            ->prefix('Rp')
                            ->visible(fn ($get) => $get('discount_type') === 'fixed'),
                        Forms\Components\TextInput::make('minimum_amount')
                            ->label('Minimal Belanja (Rp)')
                            ->numeric()
                            ->min(0)
                            ->prefix('Rp')
                            ->placeholder('0 = Tanpa minimal'),
                    ])->columns(2),

                Forms\Components\Section::make('Periode & Penggunaan')
                    ->schema([
                        Forms\Components\DatePicker::make('valid_from')
                            ->label('Berlaku Dari')
                            ->displayFormat('d/m/Y'),
                        Forms\Components\DatePicker::make('valid_until')
                            ->label('Berlaku Sampai')
                            ->displayFormat('d/m/Y'),
                        Forms\Components\TextInput::make('usage_limit')
                            ->label('Batas Penggunaan')
                            ->numeric()
                            ->min(0)
                            ->placeholder('0 = Tidak terbatas'),
                        Forms\Components\TextInput::make('usage_count')
                            ->label('Sudah Digunakan')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->badge(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kupon')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('discount_display')
                    ->label('Diskon')
                    ->getStateUsing(function ($record) {
                        if ($record->discount_type === 'percentage') {
                            return $record->discount_percent . '%';
                        } else {
                            return 'Rp ' . number_format($record->discount_amount, 0, ',', '.');
                        }
                    }),
                Tables\Columns\TextColumn::make('minimum_amount')
                    ->label('Min. Belanja')
                    ->money('IDR')
                    ->placeholder('Tidak ada minimal'),
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Berlaku Dari')
                    ->date('d/m/Y')
                    ->placeholder('Tidak terbatas'),
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Berlaku Sampai')
                    ->date('d/m/Y')
                    ->placeholder('Tidak terbatas'),
                Tables\Columns\TextColumn::make('usage_status')
                    ->label('Penggunaan')
                    ->getStateUsing(function ($record) {
                        if ($record->usage_limit) {
                            return $record->usage_count . '/' . $record->usage_limit;
                        }
                        return $record->usage_count . '/∞';
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
