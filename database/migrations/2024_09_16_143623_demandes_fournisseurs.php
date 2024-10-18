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
        Schema::create('demandesFournisseurs', function (Blueprint $table) {
            $table->id('id_demande');
            $table->foreignId('id_fournisseurs');
            $table->string('etat_demande', 32)->default('en attente');
            $table->string('raison_refus', 255)->nullable();
            $table->string('commentaire', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandesFournisseurs');
    }
};
