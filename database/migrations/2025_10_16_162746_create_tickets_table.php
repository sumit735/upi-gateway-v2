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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // e.g., TKT-2025-0001
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Can be null if guest
            $table->foreignId('category_id')->constrained('ticket_categories')->cascadeOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->string('status')->default('open'); // open, in_progress, resolved, closed
            $table->string('name')->nullable(); // For guest users
            $table->string('email')->nullable(); // For guest users
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // Admin who will resolve
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'priority']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
