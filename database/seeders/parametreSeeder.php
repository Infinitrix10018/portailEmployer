<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class parametreSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('parametre_site')->insert([
            [
                'nom_parametre' => 'Taille maximale des fichiers joints (Mo)',
                'valeur_parametre' => '70',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_parametre' => 'Courriel approvisionnement',
                'valeur_parametre' => 'unCourrielExemple@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_parametre' => 'Courriel des finances',
                'valeur_parametre' => 'unCourrielExemple@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_parametre' => 'Délai avant révision en mois',
                'valeur_parametre' => '48',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
        
    }
}
