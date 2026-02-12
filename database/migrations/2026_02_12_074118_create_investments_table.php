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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            // Share Information
            $table->integer('share_count')->default(1);
            $table->decimal('per_share_price', 12,0);
            $table->decimal('total_amount', 15,2);
            
            // payment information
            $table->enum('payment_method', ['stripe', 'bank_transfer', 'cash'])->default('cash');
            $table->enum('payment_type', ['full', 'installment'])->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('cash_reciept_no')->nullable();

            //
            $table->integer('installments_paid')->default(0);
            $table->date('next_installment_due')->nullable();
            $table->decimal('late_fee_accumulated', 12,2)->default(0.00);

            // Status
            $table->enum('status', ['active', 'completed', 'cancelled'])->nullable();
            $table->boolean('approved_by_admin')->default(false);
            $table->decimal('down_payment_amount', 12,2)->default(0.00);
            $table->foreignId('time_id')->constrained();
            $table->timestamp('investment_date')->useCurrent();

            $table->timestamps();

            // INdexing
            $table->index(['user_id', 'property_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
