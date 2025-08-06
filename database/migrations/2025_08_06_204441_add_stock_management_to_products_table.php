<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('manage_stock')->default(false)->after('status');
            $table->integer('stock_quantity')->nullable()->after('manage_stock');
            $table->boolean('allow_backorders')->default(false)->after('stock_quantity');
            $table->integer('low_stock_threshold')->nullable()->after('allow_backorders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['manage_stock', 'stock_quantity', 'allow_backorders', 'low_stock_threshold']);
        });
    }
};
