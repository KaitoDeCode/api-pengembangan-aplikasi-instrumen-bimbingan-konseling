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
        Schema::disableForeignKeyConstraints();

        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('criteria_id')->constrained();
            $table->decimal('point');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};
