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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('property_id');
            $table->integer('installment_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('charge', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_type')->nullable();
            $table->string('trx_id')->nullable();            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
