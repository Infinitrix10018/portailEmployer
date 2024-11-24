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
        Schema::create('model_courriel', function (Blueprint $table) {
            $table->id("id_model_courriel");
            $table->string('nom_courriel', length: 250);
            $table->string('objet', length: 64);
            $table->string('message', length: 512);
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
