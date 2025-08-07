<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewResource\Pages;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'Product Reviews';
    
    protected static ?string $modelLabel = 'Product Review';
    
    protected static ?string $pluralModelLabel = 'Product Reviews';
    
    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Forms\Components\Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star',
                                2 => '2 Stars',
                                3 => '3 Stars',
                                4 => '4 Stars',
                                5 => '5 Stars',
                            ])
                            ->required(),
                            
                        Forms\Components\Textarea::make('review')
                            ->label('Review Text')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Status & Admin Response')
                    ->schema([
                        Forms\Components\Toggle::make('is_verified_purchase')
                            ->label('Verified Purchase')
                            ->helperText('Mark if this review is from a verified purchase'),
                            
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Approved')
                            ->helperText('Approve this review to show it publicly')
                            ->default(false),
                            
                        Forms\Components\Textarea::make('admin_reply')
                            ->label('Admin Reply')
                            ->rows(3)
                            ->helperText('Optional response from admin to this review')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('review')
                    ->label('Review')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                    
                Tables\Columns\IconColumn::make('is_verified_purchase')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
                    
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars', 
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->boolean()
                    ->trueLabel('Approved only')
                    ->falseLabel('Pending only')
                    ->native(false),
                    
                Tables\Filters\TernaryFilter::make('is_verified_purchase')
                    ->label('Purchase Status')
                    ->boolean()
                    ->trueLabel('Verified only')
                    ->falseLabel('Unverified only')
                    ->native(false),
                    
                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (ProductReview $record) => $record->update(['is_approved' => true]))
                    ->visible(fn (ProductReview $record): bool => !$record->is_approved)
                    ->requiresConfirmation()
                    ->modalHeading('Approve Review')
                    ->modalDescription('Are you sure you want to approve this review? It will be visible to all customers.')
                    ->modalSubmitActionLabel('Yes, approve it'),
                    
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn (ProductReview $record) => $record->update(['is_approved' => false]))
                    ->visible(fn (ProductReview $record): bool => $record->is_approved)
                    ->requiresConfirmation()
                    ->modalHeading('Reject Review')
                    ->modalDescription('Are you sure you want to reject this review? It will be hidden from customers.')
                    ->modalSubmitActionLabel('Yes, reject it'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('approve_bulk')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['is_approved' => true])))
                        ->requiresConfirmation()
                        ->modalHeading('Approve Reviews')
                        ->modalDescription('Are you sure you want to approve all selected reviews?')
                        ->modalSubmitActionLabel('Yes, approve all'),
                        
                    Tables\Actions\BulkAction::make('reject_bulk')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['is_approved' => false])))
                        ->requiresConfirmation()
                        ->modalHeading('Reject Reviews')
                        ->modalDescription('Are you sure you want to reject all selected reviews?')
                        ->modalSubmitActionLabel('Yes, reject all'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('review');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Review Information')
                    ->schema([
                        TextEntry::make('product.name')
                            ->label('Product'),
                            
                        TextEntry::make('user.name')
                            ->label('Customer'),
                            
                        TextEntry::make('user.email')
                            ->label('Customer Email'),
                            
                        TextEntry::make('rating')
                            ->label('Rating')
                            ->formatStateUsing(fn ($state) => $state . '/5 (' . str_repeat('⭐', $state) . ')'),
                            
                        IconEntry::make('is_verified_purchase')
                            ->label('Verified Purchase')
                            ->boolean(),
                            
                        IconEntry::make('is_approved')
                            ->label('Approved Status')
                            ->boolean(),
                            
                        TextEntry::make('created_at')
                            ->label('Review Date')
                            ->dateTime(),
                    ])
                    ->columns(2),
                    
                Section::make('Review Content')
                    ->schema([
                        TextEntry::make('review')
                            ->label('Customer Review')
                            ->prose(),
                    ]),
                    
                Section::make('Admin Response')
                    ->schema([
                        TextEntry::make('admin_reply')
                            ->label('Admin Reply')
                            ->prose()
                            ->placeholder('No admin reply yet'),
                    ])
                    ->visible(fn ($record) => $record->admin_reply),
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
            'index' => Pages\ListProductReviews::route('/'),
            'create' => Pages\CreateProductReview::route('/create'),
            'view' => Pages\ViewProductReview::route('/{record}'),
            'edit' => Pages\EditProductReview::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() ?: null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : null;
    }
}
