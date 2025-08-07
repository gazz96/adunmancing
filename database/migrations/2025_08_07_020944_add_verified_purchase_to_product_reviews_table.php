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
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->boolean('is_verified_purchase')->default(false)->after('review');
            $table->boolean('is_approved')->default(true)->after('is_verified_purchase');
            $table->text('admin_reply')->nullable()->after('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropColumn(['is_verified_purchase', 'is_approved', 'admin_reply']);
        });
    }
};
