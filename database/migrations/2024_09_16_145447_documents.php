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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('id_document');
            $table->foreignId('id_fournisseurs');
            $table->string('nomDocument', 64);//nom du document
            $table->string('cheminDocument', 128);//emplacement ou il est savegarder
            $table->string('extension_document', 10);//nom de l'extention du document
            $table->string('taille_document', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
