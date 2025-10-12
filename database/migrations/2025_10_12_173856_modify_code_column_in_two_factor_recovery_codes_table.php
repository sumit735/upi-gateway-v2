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
        Schema::table('two_factor_recovery_codes', function (Blueprint $table) {
            // Drop the unique constraint first
            $table->dropUnique(['code']);
        });
        
        Schema::table('two_factor_recovery_codes', function (Blueprint $table) {
            // Change code column from string to text for encrypted values
            $table->text('code')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('two_factor_recovery_codes', function (Blueprint $table) {
            // Revert back to string
            $table->string('code', 20)->change();
        });
        
        Schema::table('two_factor_recovery_codes', function (Blueprint $table) {
            // Re-add unique constraint
            $table->unique('code');
        });
    }
};
