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
        Schema::create('rps_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_id')
                ->constrained('rps')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('meeting_number');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps_meetings');
    }
};
