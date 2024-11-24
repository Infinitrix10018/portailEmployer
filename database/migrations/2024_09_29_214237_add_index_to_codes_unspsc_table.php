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
        Schema::table('code_unspsc', function (Blueprint $table) {
            $table->index('code_unspsc');
            $table->index('categorie');
            $table->index('classe_categorie');
            $table->index('precision_categorie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('code_unspsc', function (Blueprint $table) {
            $table->dropIndex(['code_unspsc']);
            $table->dropIndex(['categorie']);
            $table->dropIndex(['classe_categorie']);
            $table->dropIndex(['precision_categorie']);
        });
    }
};
