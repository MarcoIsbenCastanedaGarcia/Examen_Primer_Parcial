<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('inventory_code', 50)
                ->unique();

            $table->string('name', 150);

            $table->string('brand', 100)
                ->nullable();

            $table->string('model', 100)
                ->nullable();

            $table->string('serial_number', 120)
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->enum('availability_status', [
                'disponible',
                'reservado',
                'prestado',
                'no_disponible',
            ])->default('disponible');

            $table->enum('physical_state', [
                'bueno',
                'regular',
                'danado',
                'mantenimiento',
                'baja',
            ])->default('bueno');

            $table->string('location', 150)
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index('availability_status');
            $table->index('physical_state');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};