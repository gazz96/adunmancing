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
        Schema::table('product_attributes', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('product_attributes', 'attribute_name')) {
                $table->dropColumn(['attribute_name', 'attribute_value', 'show_in_product', 'use_as_variation']);
            }
            
            // Add new column for attribute values JSON
            if (!Schema::hasColumn('product_attributes', 'attribute_values')) {
                $table->json('attribute_values')->after('attribute_id');
            }
            
            // Ensure attribute_id is correct type
            $table->bigInteger('attribute_id')->unsigned()->change();
            
            // Add unique constraint if not exists
            try {
                $table->unique(['product_id', 'attribute_id']);
            } catch (\Exception $e) {
                // Constraint might already exist, ignore
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropColumn('attribute_values');
            $table->text('attribute_name')->nullable();
            $table->text('attribute_value')->nullable();
            $table->integer('show_in_product')->nullable();
            $table->integer('use_as_variation')->nullable();
        });
    }
};
