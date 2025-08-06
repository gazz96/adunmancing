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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status'); // bank_transfer, midtrans
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('payment_method');
            $table->string('payment_status')->default('pending')->after('payment_method_id'); // pending, paid, failed
            $table->string('payment_proof')->nullable()->after('payment_status'); // File upload path
            $table->timestamp('paid_at')->nullable()->after('payment_proof');
            $table->text('payment_notes')->nullable()->after('paid_at');
            
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null');
        });
    }

    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn([
                'payment_method',
                'payment_method_id', 
                'payment_status',
                'payment_proof',
                'paid_at',
                'payment_notes'
            ]);
        });
    }
};