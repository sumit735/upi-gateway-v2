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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Monthly Plan", "Quarterly Plan"
            $table->enum('duration_type', ['days', 'months', 'years'])->default('months');
            $table->integer('duration_value'); // e.g., 1 for monthly, 3 for quarterly
            $table->decimal('price', 10, 2); // Original price
            $table->decimal('discount_percentage', 5, 2)->default(0); // Discount %
            $table->decimal('final_price', 10, 2); // Price after discount
            $table->text('description')->nullable(); // Plan description
            $table->json('features')->nullable(); // Array of features
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false); // Highlight as popular
            $table->integer('sort_order')->default(0); // Display order
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
