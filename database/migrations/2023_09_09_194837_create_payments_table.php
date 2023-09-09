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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable()->index();
            $table->unsignedBigInteger('event_id')->index()->default('1');
            $table->char('series', 15);
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->tinyText('observations')->nullable();
            $table->string('voucher_image_path', 255);
            $table->enum('status', ['PENDIENTE', 'ACEPTADO', 'RECHAZADO', 'OBSERVADO'])->default('PENDIENTE');

            // Claves foráneas
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->foreign('event_id')->references('id')->on('events')
                ->onUpdate('no action')
                ->onDelete('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
