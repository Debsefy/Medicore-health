<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('doctor_id')->unique();
            $table->string('specialization');
            $table->string('qualification');
            $table->integer('experience_years')->default(0);
            $table->string('license_number')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->json('available_days')->nullable(); // ["Monday","Wednesday","Friday"]
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('doctors'); }
};
