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
        Schema::create('daily_contributions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('contribution_date');
            $table->enum('status', ['paid', 'unpaid', 'pending'])->default('paid');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money', 'card'])->default('cash');
            $table->text('notes')->nullable();
            $table->string('receipt_number')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'contribution_date']);
            $table->index(['user_id', 'contribution_date']);
            $table->index(['agent_id', 'contribution_date']);
            $table->index(['status', 'contribution_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_contributions');
    }
};
