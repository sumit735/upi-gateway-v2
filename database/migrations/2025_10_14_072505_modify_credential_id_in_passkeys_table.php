<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table exists and has data
        if (!Schema::hasTable('passkeys')) {
            return;
        }
        
        // Drop unique constraint if it exists
        $indexes = DB::select("SHOW INDEXES FROM passkeys WHERE Key_name = 'passkeys_credential_id_unique' OR Column_name = 'credential_id'");
        
        foreach ($indexes as $index) {
            if ($index->Key_name !== 'PRIMARY') {
                DB::statement("ALTER TABLE passkeys DROP INDEX `{$index->Key_name}`");
            }
        }
        
        // Change to text type using raw SQL
        DB::statement('ALTER TABLE passkeys MODIFY credential_id TEXT NOT NULL');
        
        // Add unique index on first 255 characters
        DB::statement('ALTER TABLE passkeys ADD UNIQUE KEY passkeys_credential_id_unique (credential_id(255))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the partial unique index
        DB::statement('ALTER TABLE passkeys DROP INDEX passkeys_credential_id_unique');
        
        // Change back to string
        DB::statement('ALTER TABLE passkeys MODIFY credential_id VARCHAR(255) NOT NULL');
        
        Schema::table('passkeys', function (Blueprint $table) {
            $table->unique('credential_id');
        });
    }
};
