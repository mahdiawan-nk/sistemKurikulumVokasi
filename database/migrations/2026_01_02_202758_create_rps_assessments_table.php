<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rps_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_id')
                ->constrained('rps')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('meeting_number');
            $table->enum('type', ['quiz', 'tugas', 'uts', 'uas'])->default('quiz');
            $table->string('title');
            $table->decimal('weight', 5, 2)->nullable();
            $table->json('rubrics')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps_assessments');
    }
};
