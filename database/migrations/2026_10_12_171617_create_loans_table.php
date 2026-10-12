<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('start_at');

            $table->dateTime('end_at');

            $table->text('purpose');

            $table->enum('status', [
                'pendiente',
                'aprobado',
                'rechazado',
                'entregado',
                'devuelto',
                'cancelado',
            ])->default('pendiente');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->text('rejection_reason')
                ->nullable();

            $table->foreignId('delivered_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('delivered_at')
                ->nullable();

            $table->foreignId('returned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('returned_at')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamp('requested_at')
                ->useCurrent();

            $table->timestamps();

            $table->index('status');
            $table->index(['start_at', 'end_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};