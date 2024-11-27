<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('code_unspsc', function (Blueprint $table) {
            $table->index('code_unspsc');
            $table->index('categorie');
            $table->index('classe_categorie');
            $table->index('precision_categorie');
        });

        Schema::table('licences_rbq', function (Blueprint $table) {
            $table->index('categorie');
            $table->index('sous_categorie');
        });

        Schema::table('fournisseur_licence_rbq_liaison', function (Blueprint $table) {
            $table->index('id_fournisseurs');
            $table->index('id_licence_rbq');
        });

        Schema::table('fournisseur_code_unspsc_liaison', function (Blueprint $table) {
            $table->index('id_fournisseurs');
            $table->index('id_code_unspsc');
        });

        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->index('ville');
            $table->index('id_fournisseurs');
        });

        Schema::table('demandesFournisseurs', function (Blueprint $table) {
            $table->index('etat_demande');
        });

    }

    public function down(): void
    {
        //
    }
};
