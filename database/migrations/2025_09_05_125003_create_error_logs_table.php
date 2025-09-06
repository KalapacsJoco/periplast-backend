<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['actual', 'fixed'])->default('actual');
            $table->text('solution')->nullable();
            $table->timestamp('fixed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('error_loggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('error_log_id')->constrained()->onDelete('cascade');
            $table->morphs('error_loggable'); // Creates error_loggable_id and error_loggable_type
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('error_loggables');
        Schema::dropIfExists('error_logs');
    }
};