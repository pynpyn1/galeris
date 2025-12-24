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
        Schema::create('qr_template_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_template_id')->constrained('qr_template')->cascadeOnDelete();
            $table->string('path_template');
            $table->string('file_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_template_files');
    }
};
