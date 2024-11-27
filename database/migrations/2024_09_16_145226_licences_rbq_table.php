<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licences_rbq', function (Blueprint $table) {
            $table->id("id_licence_rbq");
            $table->string('categorie', length: 32);
            $table->string('sous_categorie', length: 250);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //
    }
};
