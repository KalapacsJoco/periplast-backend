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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->dateTime('performed_at');
            $table->string('performed_by')->nullable();
            $table->timestamps();
        });

        Schema::create('maintainables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_record_id')->constrained()->cascadeOnDelete();
            $table->morphs('maintainable'); 
            // maintainable_id, maintainable_type (pl. Machine, Tool, Insert)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintainables');
        Schema::dropIfExists('maintenance_records');
    }
};
