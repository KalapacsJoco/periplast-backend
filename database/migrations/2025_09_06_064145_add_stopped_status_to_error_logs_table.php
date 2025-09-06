<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('error_logs', function (Blueprint $table) {
            $table->timestamp('stopped_at')->nullable()->after('fixed_at');
            $table->timestamp('resumed_at')->nullable()->after('stopped_at');
        });

        // Use a raw statement to alter the enum column reliably
        DB::statement("ALTER TABLE `error_logs` MODIFY COLUMN `status` ENUM('actual', 'fixed', 'stopped') NOT NULL DEFAULT 'actual'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('error_logs', function (Blueprint $table) {
            $table->dropColumn(['stopped_at', 'resumed_at']);
        });

        // Use a raw statement to revert the enum column
        DB::statement("ALTER TABLE `error_logs` MODIFY COLUMN `status` ENUM('actual', 'fixed') NOT NULL DEFAULT 'actual'");
    }
};