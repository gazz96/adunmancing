<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Details')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($context) => $context === 'edit'),

                        Forms\Components\Select::make('group')
                            ->options([
                                'general' => 'General',
                                'appearance' => 'Appearance', 
                                'payment' => 'Payment',
                                'shipping' => 'Shipping',
                                'permissions' => 'Permissions',
                                'social_media' => 'Social Media',
                                'footer' => 'Footer',
                            ])
                            ->required()
                            ->default('general'),

                        Forms\Components\Select::make('type')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'image' => 'Image',
                                'json' => 'JSON',
                            ])
                            ->required()
                            ->default('text')
                            ->live(),

                        Forms\Components\TextInput::make('description')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Value')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->label('Value')
                            ->maxLength(255)
                            ->visible(fn ($get) => in_array($get('type'), ['text', 'number'])),

                        Forms\Components\Textarea::make('value')
                            ->label('Value')
                            ->rows(4)
                            ->visible(fn ($get) => $get('type') === 'textarea'),

                        Forms\Components\Toggle::make('value')
                            ->label('Value')
                            ->visible(fn ($get) => $get('type') === 'boolean'),

                        Forms\Components\FileUpload::make('value')
                            ->label('Image')
                            ->image()
                            ->directory('settings')
                            ->visibility('public')
                            ->visible(fn ($get) => $get('type') === 'image'),

                        Forms\Components\Textarea::make('value')
                            ->label('JSON Value')
                            ->rows(6)
                            ->helperText('Enter valid JSON format')
                            ->visible(fn ($get) => $get('type') === 'json'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'gray',
                        'appearance' => 'info',
                        'payment' => 'warning',
                        'shipping' => 'success',
                        'permissions' => 'danger',
                        'social_media' => 'purple',
                        'footer' => 'indigo',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->formatStateUsing(function ($state, $record) {
                        return match($record->type) {
                            'boolean' => $state ? 'Yes' : 'No',
                            'image' => $state ? 'Image uploaded' : 'No image',
                            'json' => 'JSON data',
                            default => $state,
                        };
                    }),

                Tables\Columns\TextColumn::make('description')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'appearance' => 'Appearance', 
                        'payment' => 'Payment',
                        'shipping' => 'Shipping',
                        'permissions' => 'Permissions',
                        'social_media' => 'Social Media',
                        'footer' => 'Footer',
                    ]),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'image' => 'Image',
                        'json' => 'JSON',
                    ]),
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
            ->defaultSort('group')
            ->groups([
                Tables\Grouping\Group::make('group')
                    ->label('Group')
                    ->collapsible(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('manage_settings') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('manage_settings') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('manage_settings') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('manage_settings') ?? false;
    }
}
