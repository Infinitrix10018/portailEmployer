<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fournisseur_a_contacter', function (Blueprint $table) {
            $table->id('id_fournisseur_a_contacter');
            $table->foreignId('id_user')
                ->constrained('users', 'id')
                ->onDelete('cascade');
            $table->foreignId('id_fournisseurs')
                ->constrained('fournisseurs', 'id_fournisseurs')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //
    }
};
