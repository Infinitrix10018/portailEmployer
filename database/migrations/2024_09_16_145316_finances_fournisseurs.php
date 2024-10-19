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
        Schema::create('financesFournisseurs', function (Blueprint $table) {
            $table->id('id_finance');
            $table->foreignId('id_fournisseurs');
            $table->string('no_TPS');
            $table->string('no_TVQ');
            $table->string('condition_paiement', 255);
            $table->string('devise', 25);
            $table->string('mode_communication', 25);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financesFournisseurs');
    }
};
