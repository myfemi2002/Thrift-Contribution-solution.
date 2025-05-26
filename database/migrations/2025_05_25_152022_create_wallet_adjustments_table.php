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
        Schema::create('wallet_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('adjustment_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_before', 10, 2);
            $table->decimal('balance_after', 10, 2);
            $table->enum('reason', [
                'omitted_contribution',
                'correction_error',
                'admin_adjustment',
                'system_error',
                'duplicate_payment',
                'refund',
                'bonus',
                'penalty',
                'other'
            ]);
            $table->text('description');
            $table->string('reference_number')->nullable();
            $table->date('reference_date')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'type']);
            $table->index(['admin_id', 'created_at']);
            $table->index(['status', 'created_at']);
            $table->index(['reason', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_adjustments');
    }
};
