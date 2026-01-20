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
        if(!Schema::hasTable('warehouses')){
            Schema::create('warehouses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('inventory_items')){
            Schema::create('inventory_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->unique();
                $table->decimal('quantity', 15, 3)->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
