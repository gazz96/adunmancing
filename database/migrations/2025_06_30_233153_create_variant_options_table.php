<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('variant_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->string('option_name');  // e.g. Color, Size
            $table->string('option_value'); // e.g. Red, M
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_options');
    }
};
