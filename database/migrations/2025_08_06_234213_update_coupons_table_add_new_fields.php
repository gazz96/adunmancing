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
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('name')->after('code');
            $table->text('description')->nullable()->after('name');
            $table->enum('discount_type', ['fixed', 'percentage'])->default('percentage')->after('description');
            $table->decimal('minimum_amount', 10, 2)->nullable()->after('discount_percent');
            $table->boolean('is_active')->default(true)->after('usage_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'discount_type', 'minimum_amount', 'is_active']);
        });
    }
};
