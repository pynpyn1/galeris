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
        Schema::create('package', function (Blueprint $table) {
            $table->id();
            $table->enum('plan', ['beginner','basic', 'pro', 'premium'])->index();
            $table->string('package_name');
            $table->text('package_desc');
            $table->json('feature');
            $table->integer('price');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->integer('storage_limit_gb')->nullable();
            $table->boolean('is_unlimited')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package');
    }
};
