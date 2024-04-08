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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->json('body_items');
            $table->string('name', 60);
            $table->string('background_image');
            $table->string('splash_path')->nullable(true)->default(null);
            $table->string('logo_path')->nullable(true)->default(null);
            $table->string('color');
            $table->unsignedBigInteger('opacity_bg')->default('100');
            $table->boolean('is_template')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
