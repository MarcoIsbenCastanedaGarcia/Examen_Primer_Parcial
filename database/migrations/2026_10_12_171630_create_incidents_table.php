<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->restrictOnDelete();

            $table->foreignId('reported_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->enum('type', [
                'dano',
                'falla',
                'perdida',
                'otro',
            ]);

            $table->text('description');

            $table->enum('status', [
                'reportada',
                'en_revision',
                'atendida',
                'cerrada',
            ])->default('reportada');

            $table->text('follow_up')
                ->nullable();

            $table->foreignId('attended_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reported_at')
                ->useCurrent();

            $table->timestamp('resolved_at')
                ->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};