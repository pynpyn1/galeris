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
        Schema::create('role_group_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_group_id')->constrained('role_group')->onDelete('cascade');
            $table->foreignId('role_permission_id')->constrained('role_permission')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_group_permission');
    }
};
