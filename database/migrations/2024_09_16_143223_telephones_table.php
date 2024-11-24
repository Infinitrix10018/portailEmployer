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
        Schema::create('telephone', function (Blueprint $table) {
            $table->id("id_telephone");
            $table->foreignId('id_fournisseurs');
            $table->string('type_tel', length: 32);
            $table->string('no_tel', length: 16);
            $table->string('poste_tel', length: 6)->nullable();
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
