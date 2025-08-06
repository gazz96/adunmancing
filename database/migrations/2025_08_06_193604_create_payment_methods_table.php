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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // BCA, Mandiri, BNI, etc.
            $table->string('type')->default('bank_transfer'); // bank_transfer, midtrans, etc.
            $table->string('account_number')->nullable(); // Bank account number
            $table->string('account_name')->nullable(); // Account holder name
            $table->text('instructions')->nullable(); // Payment instructions
            $table->string('logo')->nullable(); // Bank logo file path
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};