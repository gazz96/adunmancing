<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OrderStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get current date info
        $today = now();
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        // Orders today
        $ordersToday = Order::whereDate('created_at', $today)->count();
        
        // Orders this month
        $ordersThisMonth = Order::where('created_at', '>=', $thisMonth)->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();
        $ordersChange = $ordersLastMonth > 0 ? 
            round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1) : 0;

        // Pending orders
        $pendingOrders = Order::where('status', 'pending')->count();

        // Revenue this month
        $revenueThisMonth = Order::where('created_at', '>=', $thisMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $revenueLastMonth = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $revenueChange = $revenueLastMonth > 0 ? 
            round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1) : 0;

        return [
            Stat::make('Orders Today', $ordersToday)
                ->description('New orders received today')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
                
            Stat::make('Orders This Month', $ordersThisMonth)
                ->description($ordersChange >= 0 ? "+{$ordersChange}% from last month" : "{$ordersChange}% from last month")
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger'),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Orders awaiting processing')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),

            Stat::make('Revenue This Month', 'Rp ' . number_format($revenueThisMonth, 0, ',', '.'))
                ->description($revenueChange >= 0 ? "+{$revenueChange}% from last month" : "{$revenueChange}% from last month")
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_dashboard') ?? false;
    }
}