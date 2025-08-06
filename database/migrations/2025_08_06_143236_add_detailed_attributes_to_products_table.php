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
            // Product specifications
            $table->json('features')->nullable()->after('description');
            $table->text('specifications')->nullable()->after('features');
            $table->decimal('length', 8, 2)->nullable()->after('weight');
            $table->decimal('width', 8, 2)->nullable()->after('length');
            $table->decimal('height', 8, 2)->nullable()->after('width');
            
            // Warranty information
            $table->text('warranty_info')->nullable()->after('height');
            $table->integer('warranty_months')->nullable()->after('warranty_info');
            
            // Delivery & shipping
            $table->integer('processing_days')->default(1)->after('warranty_months');
            $table->text('shipping_info')->nullable()->after('processing_days');
            $table->boolean('fragile')->default(false)->after('shipping_info');
            $table->boolean('cold_chain')->default(false)->after('fragile');
            
            // Additional product info
            $table->string('material')->nullable()->after('cold_chain');
            $table->string('color')->nullable()->after('material');
            $table->text('usage_instructions')->nullable()->after('color');
            $table->text('storage_instructions')->nullable()->after('usage_instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'features',
                'specifications',
                'length',
                'width',
                'height',
                'warranty_info',
                'warranty_months',
                'processing_days',
                'shipping_info',
                'fragile',
                'cold_chain',
                'material',
                'color',
                'usage_instructions',
                'storage_instructions'
            ]);
        });
    }
};
