<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use App\Models\MenuItem;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Menu Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                Repeater::make('items')
                    ->label('Menu Items')
                    ->relationship('items')
                    ->schema([

                        Select::make('parent_id')
                            ->options(
                                MenuItem::query()
                                    ->whereNull('parent_id')
                                    ->pluck('label', 'id')
                            )
                            ->label('Parent'),

                        TextInput::make('label')
                            ->label('Item Title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('url')
                            ->label('Item URL')
                            ->required()
                            ->maxLength(255),

                        

                        // TextInput::make('order')
                        //     ->label('Order')
                        //     ->numeric()
                        //     ->default(0)
                        //     ->required()
                        //     ->maxValue(1000)
                        //     ->minValue(0),
                    ])
                    ->columns(1)
                    ->required()
                    ->minItems(0)
                    ->columnSpanFull()
                    ->reorderableWithDragAndDrop(true)
                    ->collapsible()
                    ->orderColumn('order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Menu Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('items.label')
                    ->label('Items')
                    ->badge()
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
