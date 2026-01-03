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
        Schema::create('rps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')
                ->constrained('program_studis')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('mata_kuliah_id')
                ->constrained('matakuliahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('academic_year', 9);
            $table->string('class', 10);
            $table->integer('revision')->default(1);

            $table->foreignId('compiled_by')
                ->constrained('dosens')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->json('learning_method')->nullable();
            $table->json('learning_experience')->nullable();

            $table->integer('total_minutes');
            $table->timestamps();

            $table->unique(['program_studi_id', 'mata_kuliah_id', 'academic_year', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps');
    }
};
