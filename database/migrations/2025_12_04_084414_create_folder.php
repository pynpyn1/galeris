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
        Schema::create('folder', function (Blueprint $table) {
            $table->id();
                $table->string('public_code', 10)->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('thumbnail')->default('https://kycacontent.s3.eu-central-1.amazonaws.com/guestgallery/landing-page/4.webp');
            $table->enum('visibility', ['private', 'public'])->default('private');
            $table->boolean('is_trial')->default(0);
            $table->date('date_event');
            $table->date('date_event_end');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder');
    }
};
