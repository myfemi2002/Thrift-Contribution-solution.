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
        Schema::create('deposit_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deposit_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action_type'); // 'created', 'approved', 'rejected', 'verified', 'appealed', 'appeal_approved', 'appeal_rejected'
            $table->decimal('amount', 15, 6)->default(0);
            $table->decimal('fee_amount', 15, 6)->default(0);
            $table->decimal('credited_amount', 15, 6)->default(0);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable(); // admin user ID who performed the action
            $table->timestamps();
            
            $table->foreign('deposit_id')->references('id')->on('crypto_deposits')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_transaction_logs');
    }
};
