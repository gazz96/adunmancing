<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YouTubeVideoResource\Pages;
use App\Filament\Resources\YouTubeVideoResource\RelationManagers;
use App\Models\YouTubeVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YouTubeVideoResource extends Resource
{
    protected static ?string $model = YouTubeVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'YouTube Videos';
    protected static ?string $modelLabel = 'Video YouTube';
    protected static ?string $pluralModelLabel = 'Video YouTube';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Video')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Video')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('youtube_id')
                            ->label('YouTube ID atau URL')
                            ->required()
                            ->helperText('Masukkan ID YouTube (contoh: dQw4w9WgXcQ) atau URL lengkap')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $id = self::extractYouTubeId($state);
                                    $set('youtube_id', $id);
                                }
                            }),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail Kustom (Opsional)')
                            ->image()
                            ->directory('youtube/thumbnails')
                            ->helperText('Kosongkan untuk menggunakan thumbnail otomatis dari YouTube'),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Detail Video')
                    ->schema([
                        Forms\Components\TextInput::make('views_count')
                            ->label('Jumlah Views')
                            ->numeric()
                            ->default(0),
                        Forms\Components\DatePicker::make('published_date')
                            ->label('Tanggal Publish'),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka kecil akan muncul lebih dulu'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Video Utama')
                            ->helperText('Hanya satu video yang bisa menjadi video utama'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(3),
            ]);
    }
    
    private static function extractYouTubeId($url)
    {
        // If it's already just an ID, return it
        if (strlen($url) == 11 && !str_contains($url, '/')) {
            return $url;
        }

        // Extract ID from various YouTube URL formats
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return $url;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->height(60)
                    ->width(100)
                    ->defaultImageUrl(fn (YouTubeVideo $record): string => 
                        'https://img.youtube.com/vi/' . $record->youtube_id . '/maxresdefault.jpg'
                    ),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('youtube_id')
                    ->label('YouTube ID')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('ID berhasil disalin'),
                Tables\Columns\TextColumn::make('views_formatted')
                    ->label('Views')
                    ->sortable('views_count'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Utama')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('published_date_formatted')
                    ->label('Dipublikasi')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->native(false),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Video Utama')
                    ->boolean()
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (YouTubeVideo $record): string => $record->youtube_url)
                    ->openUrlInNewTab(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
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
            'index' => Pages\ListYouTubeVideos::route('/'),
            'create' => Pages\CreateYouTubeVideo::route('/create'),
            'edit' => Pages\EditYouTubeVideo::route('/{record}/edit'),
        ];
    }
}
