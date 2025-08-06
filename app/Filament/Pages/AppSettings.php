<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;

class AppSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationLabel = 'App Settings';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.app-settings';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = [];
        $settingsData = Setting::all();
        
        foreach ($settingsData as $setting) {
            $value = $setting->value;
            
            // Handle different data types
            $settings[$setting->key] = match($setting->type) {
                'boolean' => (bool) $value,
                'number' => is_numeric($value) ? (float) $value : 0,
                'json' => is_string($value) ? json_decode($value, true) : $value,
                'image' => is_string($value) ? $value : null,
                default => is_string($value) ? $value : (string) $value,
            };
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required(),
                                
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email(),
                                
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Contact Phone'),
                                
                                Forms\Components\Textarea::make('contact_address')
                                    ->label('Contact Address')
                                    ->rows(3),
                            ]),

                        Forms\Components\Tabs\Tab::make('Appearance')
                            ->schema([
                                Forms\Components\FileUpload::make('site_logo')
                                    ->label('Site Logo')
                                    ->image()
                                    ->directory('settings')
                                    ->visibility('public'),
                                
                                Forms\Components\FileUpload::make('site_favicon')
                                    ->label('Site Favicon')
                                    ->image()
                                    ->directory('settings')
                                    ->visibility('public'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Payment')
                            ->schema([
                                Forms\Components\Toggle::make('bank_transfer_enabled')
                                    ->label('Enable Bank Transfer'),
                                
                                Forms\Components\Toggle::make('midtrans_enabled')
                                    ->label('Enable Midtrans')
                                    ->live(),
                                
                                Forms\Components\TextInput::make('midtrans_server_key')
                                    ->label('Midtrans Server Key')
                                    ->password()
                                    ->visible(fn ($get) => $get('midtrans_enabled')),
                                
                                Forms\Components\TextInput::make('midtrans_client_key')
                                    ->label('Midtrans Client Key')
                                    ->visible(fn ($get) => $get('midtrans_enabled')),
                                
                                Forms\Components\Toggle::make('midtrans_is_production')
                                    ->label('Midtrans Production Mode')
                                    ->visible(fn ($get) => $get('midtrans_enabled')),
                            ]),

                        Forms\Components\Tabs\Tab::make('Shipping')
                            ->schema([
                                Forms\Components\TextInput::make('default_shipping_cost')
                                    ->label('Default Shipping Cost')
                                    ->numeric()
                                    ->prefix('Rp'),
                                
                                Forms\Components\TextInput::make('free_shipping_threshold')
                                    ->label('Free Shipping Threshold')
                                    ->numeric()
                                    ->prefix('Rp'),
                                
                                Forms\Components\TextInput::make('origin_city_id')
                                    ->label('Origin City ID')
                                    ->helperText('City ID for shipping cost calculation'),
                            ]),
                    ])
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                if ($setting) {
                    // Skip null or empty values that shouldn't be saved
                    if ($value === null && $setting->type !== 'image') {
                        continue;
                    }

                    // Handle different value types for storage
                    $storageValue = match($setting->type) {
                        'boolean' => $value ? '1' : '0',
                        'json' => is_array($value) ? json_encode($value) : $value,
                        'number' => $value !== null ? (string) $value : $setting->value,
                        'image' => is_array($value) ? (isset($value[0]) ? $value[0] : null) : $value,
                        default => $value !== null ? (is_array($value) ? json_encode($value) : (string) $value) : $setting->value,
                    };

                    $setting->update(['value' => $storageValue]);
                }
            }

            Notification::make()
                ->title('Settings saved successfully!')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error saving settings')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('manage_settings') ?? false;
    }
}
