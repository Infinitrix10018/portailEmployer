<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personne_ressource', function (Blueprint $table) {
            $table->id("id_personne_ressource");
            $table->foreignId('id_fournisseurs');
            $table->foreignId('id_telephone');
            $table->string('prenom_contact', length: 32);
            $table->string('nom_contact', length: 32);
            $table->string('fonction', length: 64)->nullable();
            $table->string('email_contact', length: 64);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //
    }
};
