<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('loan_id')
                ->constrained('loans')
                ->cascadeOnDelete();

            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->restrictOnDelete();

            $table->string('condition_on_delivery', 100)
                ->nullable();

            $table->string('condition_on_return', 100)
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'loan_id',
                'equipment_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};