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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Megrendelői szám (pl. ERP-ből jön)
            $table->string('customer_order_number')->unique();

            // Kapcsolatok
            // $table->foreignId('machine_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();

            // Opcionálisan insert, ha kell
            $table->foreignId('insert_id')->nullable()->constrained()->nullOnDelete();

            // Anyagok
            $table->string('material');
            $table->string('additives')->nullable(); // pl. színezőanyag, üvegszál, stb.

            // Súly adatok
            $table->decimal('gross_weight_has_to_be', 8, 3); // gramm vagy kg, 8 számjegy, 3 tizedes
            $table->decimal('gross_weight', 8, 3)->nullable();
            $table->decimal('net_weight_has_to_be', 8, 3);
            $table->decimal('net_weight', 8, 3)->nullable();

            // Ciklusidő másodpercben
            $table->decimal('cycle_time', 6, 2)->nullable();
            $table->decimal('cycle_time_has_to_be', 6, 2);

            // Termék neve
            $table->string('product_name');

            // Meleg vizes hűtés
            $table->boolean('hot_water_cooling')->default(false);

            // Megrendelt darabszám
            $table->unsignedInteger('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
