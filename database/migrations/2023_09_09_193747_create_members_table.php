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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->char('document', 8)->unique();
            $table->string('name', 80);
            $table->string('paternal_surname', 100);
            $table->string('maternal_surname', 100);
            $table->string('degree', 20)->nullable();
            $table->string('deparment', 100)->nullable();
            $table->enum('modality', ['PRESENCIAL', 'VIRTUAL'])->nullable();
            $table->enum('type', ['PLENO', 'OBSERVADOR', 'ESTUDIANTE', 'AGREMIADO'])->nullable();
            $table->char('phone', 9);
            $table->char('whatsapp', 9)->nullable();
            $table->char('collegiate_code', 6)->nullable();
            $table->dateTime('pre_registration_date')->nullable();
            $table->string('email', 100)->index()->unique();
            $table->string('password', 120)->nullable();
            $table->boolean('state')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            // $table->string('paternal_surname', 60);
            // $table->string('maternal_surname', 60);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
