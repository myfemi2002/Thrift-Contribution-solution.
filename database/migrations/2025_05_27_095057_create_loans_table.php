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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('loan_wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->decimal('interest_rate', 5, 2)->default(10.00);
            $table->decimal('interest_amount', 15, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('amount_paid', 15, 2)->default(0.00);
            $table->decimal('outstanding_balance', 15, 2);
            $table->enum('status', ['pending', 'approved', 'disbursed', 'active', 'completed', 'overdue', 'defaulted', 'rejected'])->default('pending');
            $table->text('purpose');
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('repayment_start_date')->nullable();
            $table->integer('duration_days')->default(30);
            $table->string('credit_rating')->nullable();
            $table->decimal('custom_interest_rate', 5, 2)->nullable();
            $table->boolean('interest_overridden')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('loan_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
