<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ProductStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get current date info
        $thisWeek = now()->startOfWeek();
        $lastWeek = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();

        // Total products
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();

        // New products this week
        $newProductsThisWeek = Product::where('created_at', '>=', $thisWeek)->count();
        $newProductsLastWeek = Product::whereBetween('created_at', [$lastWeek, $lastWeekEnd])->count();
        $productsChange = $newProductsLastWeek > 0 ? 
            round((($newProductsThisWeek - $newProductsLastWeek) / $newProductsLastWeek) * 100, 1) : 0;

        // Low stock products
        $lowStockProducts = Product::where('manage_stock', true)
            ->where('stock_quantity', '<=', DB::raw('low_stock_threshold'))
            ->count();

        // New users this week
        $newUsersThisWeek = User::where('created_at', '>=', $thisWeek)->count();
        $newUsersLastWeek = User::whereBetween('created_at', [$lastWeek, $lastWeekEnd])->count();
        $usersChange = $newUsersLastWeek > 0 ? 
            round((($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100, 1) : 0;

        return [
            Stat::make('Total Products', $totalProducts)
                ->description("{$activeProducts} active products")
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
                
            Stat::make('New Products This Week', $newProductsThisWeek)
                ->description($productsChange >= 0 ? "+{$productsChange}% from last week" : "{$productsChange}% from last week")
                ->descriptionIcon($productsChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($productsChange >= 0 ? 'success' : 'danger'),

            Stat::make('Low Stock Alert', $lowStockProducts)
                ->description('Products running low')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'danger' : 'success'),

            Stat::make('New Users This Week', $newUsersThisWeek)
                ->description($usersChange >= 0 ? "+{$usersChange}% from last week" : "{$usersChange}% from last week")
                ->descriptionIcon($usersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($usersChange >= 0 ? 'success' : 'danger'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_dashboard') ?? false;
    }
}