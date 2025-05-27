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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0.00);
            $table->decimal('net_amount', 15, 2); // Amount - fee
            $table->enum('payment_method', ['cash', 'bank_transfer'])->default('cash');
            
            // Bank details (for bank transfer)
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            
            $table->enum('status', [
                'pending', 
                'approved', 
                'processing', 
                'completed', 
                'rejected', 
                'cancelled'
            ])->default('pending');
            
            $table->text('reason')->nullable(); // User's reason for withdrawal
            $table->text('admin_notes')->nullable(); // Admin notes
            $table->text('rejection_reason')->nullable();
            
            // Approval tracking
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // Balance tracking
            $table->decimal('wallet_balance_before', 15, 2);
            $table->decimal('wallet_balance_after', 15, 2)->nullable();
            
            // Metadata and tracking
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index(['approved_by', 'approved_at']);
            $table->index(['payment_method', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
