<?php

use App\Models\Api\Cart;
use App\Models\Api\Menu;
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
        Schema::create('item_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Menu::class);
            $table->foreignIdFor(Cart::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_carts');
    }
};
