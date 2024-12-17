<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('code_unspsc', function (Blueprint $table) {
            $table->id("id_code_unspsc");
            $table->string('categorie', length: 250);
            $table->string('code_unspsc', length: 8);
            $table->string('classe_categorie', length: 128);
            $table->string('precision_categorie', length: 256);
        });
    }

    public function down(): void
    {
        //
    }
};
