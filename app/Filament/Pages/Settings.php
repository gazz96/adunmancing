<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $title = 'Settings';

    public $data = [];

    public $options = [];

    //public $store_country = 'ID'; // Default to Indonesia

    public function mount(): void
    {
        $this->options = \App\Models\Option::all()->pluck('option_value', 'option_name')->toArray();
    }

    protected function getFormSchema(): array
    {

        return [
            Tabs::make('Settings')
                ->tabs([
                    Tabs\Tab::make('General')
                        ->schema([
                            // FileUpload::make('options.site_logo')
                            //     ->label('Site Logo')
                            //     ->image()
                            //     ->disk('public')
                            //     ->directory('site_logos')
                            //     ->visibility(true)
                            //     ->columnSpanFull()
                            //     ->previewable(false),
                            TextInput::make('options.site_name')->label('Site Name'),
                            TextInput::make('options.contact')->label('Site Contact'),
                            Textarea::make('options.site_description')->label('Description'),
                            TextInput::make('options.site_copyright')->label('Copyright')
                        ]),
                    Tabs\Tab::make('Product')
                        ->schema([
                            // Toggle::make('enable_reviews')->label('Enable Reviews'),
                            // TextInput::make('default_stock')->label('Default Stock'),
                        ]),
                    // Tabs\Tab::make('Shipping')
                    //     ->schema([
                    //         // TextInput::make('shipping_cost')->label('Flat Shipping Cost'),
                    //     ]),
                    Tabs\Tab::make('Payment')
                        ->schema([
                            Section::make('Take offline payments')
                                ->description('Accept payments via cash on delivery, bank transfer, etc.')
                                ->schema([
                                    Toggle::make('options.enable_cod')
                                        ->label('Enable Cash on Delivery')
                                        ->default(true),
                                    Toggle::make('options.enable_bank_transfer')
                                        ->label('Enable Bank Transfer')
                                        ->default(true),
                                    Toggle::make('options.enable_credit_card')
                                        ->label('Enable Credit Card Payment')
                                        ->default(false),
                                    Toggle::make('options.enable_paypal')
                                        ->label('Enable PayPal Payment')
                                        ->default(false),
                                ]),
                        ]),
                    
                    Tabs\Tab::make('Emails')
                        ->schema([
                            Textarea::make('options.email_new_order_template')
                                ->label('New Order')
                                ->rows(10),

                            Textarea::make('options.email_cancel_order_template')
                                ->label('Cancelled Order')
                                ->rows(10),
                        
                            Textarea::make('options.email_failed_order_template')
                                ->label('Failed Order')
                                ->rows(10),
                            Textarea::make('options.email_failed_order_template')
                                ->label('Failed Order')
                                ->rows(10),
                        ]),
                    Tabs\Tab::make('E-commerce')
                        ->schema([
                            Section::make('Store address')
                                ->description('Configure your e-commerce settings here.')
                                ->schema([
                                    TextInput::make('options.store_name')->label('Store Name')->required(),
                                    TextInput::make('options.store_address_1')->label('Address Line 1')->required(),
                                    TextInput::make('options.store_address_2')->label('Address Line 2'),
                                    Select::make('options.store_regency_id')
                                        ->label('City/Regency')
                                        ->options(\App\Models\Regency::get()->pluck('relation_name', 'id'))
                                        ->searchable(),
                                    TextInput::make('options.store_postcode')->label('Postcode')->required(),
                                    TextInput::make('options.store_phone')->label('Phone Number'),
                                    TextInput::make('options.store_email')->label('Store Email'),
                                ]),

                            Section::make('Checkout')
                                ->description('This section controls the display of your website privacy policy. The privacy notices below will not show up unless a privacy page is set.')
                                ->schema([
                                    Toggle::make('options.enable_guest_checkout')->label('Enable guest checkout')->default(true),
                                    Toggle::make('options.enable_login_during_checkout')->label('Enable Log-in during checkout')->default(true),

                                    RichEditor::make('options.registration_privacy_policy')
                                        ->label('Privacy Policy')
                                        ->helperText('This will be shown during registration.'),

                                    RichEditor::make('options.checkout_privacy_policy')
                                        ->label('Privacy Policy')
                                        ->helperText('This will be shown during checkout.'),
                                ]),
                        ]),
                ]),
        ];
    }

    protected function getFormModel(): string
    {
        return ''; // Optional if you're not binding to a model
    }

    public function save(): void
    {
        // Save the $this->form->getState() to DB or config
        $data = $this->form->getState();

        foreach ($data['options'] as $key => $value) {
            $option = \App\Models\Option::updateByKey($key, $value);
        }


        Notification::make()
            ->title('Settings saved successfully!')
            ->success() // jenis: success, warning, danger, info
            ->duration(3000) // durasi dalam milidetik (opsional)
            ->send();

        //$this->form->reset();
        
    }

}
