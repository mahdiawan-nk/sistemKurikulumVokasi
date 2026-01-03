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
        Schema::create('rps_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_id')
                ->constrained('rps')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('dosen_id')
                ->constrained('dosens')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('approved')->default(false);
            $table->string('role');
            $table->date('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps_approvals');
    }
};
