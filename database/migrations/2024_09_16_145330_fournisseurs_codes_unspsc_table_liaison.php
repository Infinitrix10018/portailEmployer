<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fournisseur_code_unspsc_liaison', function (Blueprint $table) {
            $table->id("id_fournisseur_code_unspsc_liaison");
            $table->foreignId('id_fournisseurs');
            $table->foreignId('id_code_unspsc');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //
    }
};
