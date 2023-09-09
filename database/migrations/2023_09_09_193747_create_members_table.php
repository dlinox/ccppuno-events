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
            $table->id(); // Esto crea un campo id con AUTO_INCREMENT
            $table->char('document', 8)->unique();
            $table->string('name', 80);
            $table->string('paternal_surname', 60);
            $table->string('maternal_surname', 60);
            $table->string('email', 100)->index()->unique(); // Indexado como indicado
            $table->char('phone', 9);
            $table->char('collegiate_code', 6)->nullable();
            $table->timestamps();
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
