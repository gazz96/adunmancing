<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        TextInput::make('discount_amount')
                            ->numeric()
                            ->label('Discount Amount (Rp)')
                            ->default(0),

                        TextInput::make('discount_percent')
                            ->numeric()
                            ->label('Discount Percent (%)')
                            ->default(0),

                        DatePicker::make('valid_from')
                            ->label('Valid From')
                            ->required(),

                        DatePicker::make('valid_until')
                            ->label('Valid Until')
                            ->nullable(),

                        TextInput::make('usage_limit')
                            ->numeric()
                            ->nullable()
                            ->label('Max Usages'),

                        TextInput::make('usage_count')
                            ->numeric()
                            ->label('Used')
                            ->disabled()
                            ->default(0)
                            ->dehydrated(false),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('discount_amount')
                    ->label('Rp')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('discount_percent')
                    ->label('%')
                    ->sortable(),

                TextColumn::make('valid_from')
                    ->label('Start')
                    ->date()
                    ->sortable(),

                TextColumn::make('valid_until')
                    ->label('End')
                    ->date()
                    ->sortable(),

                TextColumn::make('usage_count')
                    ->label('Used')
                    ->sortable(),

                TextColumn::make('usage_limit')
                    ->label('Limit')
                    ->sortable(),
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
