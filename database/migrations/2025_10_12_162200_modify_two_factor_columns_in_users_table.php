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
        Schema::table('users', function (Blueprint $table) {
            // Change two_factor_secret from string to text
            $table->text('two_factor_secret')->nullable()->change();
            
            // Drop two_factor_recovery_codes column as we're using separate table now
            $table->dropColumn('two_factor_recovery_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert two_factor_secret back to string
            $table->string('two_factor_secret')->nullable()->change();
            
            // Add back two_factor_recovery_codes column
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
        });
    }
};
