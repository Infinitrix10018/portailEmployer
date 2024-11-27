<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('licences_rbq', function (Blueprint $table) {
            $table->index('categorie');
            $table->index('sous_categorie');
        });
    }

    public function down(): void
    {
        Schema::table('licences_rbq', function (Blueprint $table) {
            $table->dropIndex(['categorie']);
            $table->dropIndex(['sous_categorie']);
        });
    }
};
