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
        Schema::table('attributes', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('attributes', 'type')) {
                $table->string('type')->default('select')->after('slug');
            }
            if (!Schema::hasColumn('attributes', 'description')) {
                $table->text('description')->nullable()->after('type');
            }
            if (!Schema::hasColumn('attributes', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('description');
            }
            if (!Schema::hasColumn('attributes', 'is_required')) {
                $table->boolean('is_required')->default(false)->after('sort_order');
            }
            if (!Schema::hasColumn('attributes', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_required');
            }
            
            // Make slug unique if not already
            if (!DB::select("SHOW INDEX FROM attributes WHERE Key_name = 'attributes_slug_unique'")) {
                $table->unique('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn(['type', 'description', 'sort_order', 'is_required', 'is_active']);
            $table->dropUnique(['slug']);
        });
    }
};
