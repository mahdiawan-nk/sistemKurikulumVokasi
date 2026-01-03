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
        Schema::create('rps_cpmks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_id')
                ->constrained('rps')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('cpmk_id')
                ->constrained('capaian_pembelajaran_matakuliahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('weight', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps_cpmks');
    }
};
