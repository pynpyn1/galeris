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
        Schema::create('purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nulrestrictOnDeletelOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('package')->nullOnDelete();
            $table->foreignId('discount_code_id')->nullable()->constrained('discount_code')->nullOnDelete();
            $table->string('invoice_number')->unique();
            $table->integer('original_price');
            $table->integer('discount_amount')->default(0);
            $table->integer('final_price');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->timestamp('subscription_start')->nullable();
            $table->timestamp('subscription_end')->nullable();
            $table->enum('subscription_status', ['active', 'nonactive'])->default('nonactive');
            $table->enum('payment_method', ['manual', 'midtrans'])->default('manual');
            $table->string('snap_token')->nullable();
            $table->string('snap_status')->nullable();
            $table->integer('snap_amount')->nullable();
            $table->enum('payment_status', [ 'noaction','unpaid','waiting_verification','paid','expired', 'rejected'])->default('unpaid');
            $table->string('payment_reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_proof')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
};
