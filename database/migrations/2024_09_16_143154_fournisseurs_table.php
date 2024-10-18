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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id("id_fournisseurs");
            $table->string('NEQ', length: 10)->nullable();
            $table->string('nom_entreprise', length: 64)->required();
            $table->string('email', length: 64)->required();
            $table->text('mdp')->required();
            $table->string('no_rue', length: 8)->required();
            $table->string('rue', length: 64)->required();
            $table->string('no_bureau', length: 8)->nullable();
            $table->string('ville', length: 64)->required();
            $table->string('province', length: 64)->required();
            $table->string('code_postal', length: 8)->required();
            $table->string('no_region_admin', length: 16)->required();
            $table->string('site_internet', length: 64)->nullable();
            $table->string('commentaire', length: 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
