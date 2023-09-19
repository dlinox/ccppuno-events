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
            $table->string('lastname', 100);
            $table->string('deparment', 100);
            $table->enum('modality', ['PRESENCIAL', 'VIRTUAL']);
            $table->enum('type', ['PLENO', 'OBSERVADOR', 'ESTUDIANTE', 'AGREMIADO']);
            $table->string('email', 100)->index()->unique();
            $table->char('phone', 9);
            $table->char('whatsapp', 9);
            $table->char('collegiate_code', 6)->nullable();
            $table->dateTime('pre_registration_date')->nullable();
            $table->boolean('state')->default(0);
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
