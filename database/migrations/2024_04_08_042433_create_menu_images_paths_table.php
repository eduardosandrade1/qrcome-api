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
        Schema::create('menu_images_paths', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('menu_id');
            $table->enum('type', ['bg', 'template'])->default('bg')->comment('Bg - background. template - Image Template');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_images_paths');
    }
};
