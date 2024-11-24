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
        Schema::create('fournisseur_licence_rbq_liaison', function (Blueprint $table) {
            $table->id("id_fournisseur_licence_rbq_liaison");
            $table->foreignId('id_fournisseurs')
                ->constrained('fournisseurs', 'id_fournisseurs') // Custom foreign key
                ->onDelete('cascade');
            $table->foreignId('id_licence_rbq')
                ->constrained('licences_rbq', 'id_licence_rbq') // Custom foreign key
                ->onDelete('cascade');
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
