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
        Schema::table('chat_conversations', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['user_id']);
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['user_id', 'admin_id']);
            
            // Add new participant columns
            $table->foreignId('participant_one_id')->after('id')->constrained('users')->onDelete('cascade');
            $table->foreignId('participant_two_id')->after('participant_one_id')->constrained('users')->onDelete('cascade');
            
            // Add unique constraint to prevent duplicate conversations
            $table->unique(['participant_one_id', 'participant_two_id'], 'unique_participants');
            
            // Add index for lookups
            $table->index(['participant_one_id', 'participant_two_id']);
        });
    }

    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->dropForeign(['participant_one_id']);
            $table->dropForeign(['participant_two_id']);
            $table->dropUnique('unique_participants');
            $table->dropColumn(['participant_one_id', 'participant_two_id']);
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }
};
