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
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('couverture')->default('default.webp');
            $table->text('description')->nullable()->default('Pas de description');
            $table->string('auteur')->nullable()->default('inconnu(e)');
            $table->string('categorie')->nullable()->default('inconnu(e)');
            $table->string('editeur')->nullable()->default('inconnu(e)');
            $table->string('statut')->default('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};
