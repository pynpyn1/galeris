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
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('package_id')->constrained('package')->cascadeOnDelete();
            // $table->foreignId('feature_id')->constrained('features')->cascadeOnDelete();
            // $table->boolean('is_enabled')->default(true);
            // $table->timestamps();
            // $table->unique(['package_id', 'feature_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_features');
    }
};
