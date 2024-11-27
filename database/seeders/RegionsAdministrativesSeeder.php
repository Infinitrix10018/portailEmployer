<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsAdministrativesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('regions_administratives')->insert([
            [
                'no_region' => '00',
                'nom_region' => 'hors du québec',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '01',
                'nom_region' => 'Bas-Saint-Laurent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '02',
                'nom_region' => 'Saguenay-Lac-Saint-Jean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '03',
                'nom_region' => 'Capitale-Nationale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '04',
                'nom_region' => 'Mauricie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '05',
                'nom_region' => 'Estrie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '06',
                'nom_region' => 'Montréal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '07',
                'nom_region' => 'Outaouais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '08',
                'nom_region' => 'Abitibi-Témiscamingue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '09',
                'nom_region' => 'Côte-Nord',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '10',
                'nom_region' => 'Nord-du-Québec',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '11',
                'nom_region' => 'Gaspésie-Îles-de-la-Madeleine',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '12',
                'nom_region' => 'Chaudière-Appalaches',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '13',
                'nom_region' => 'Laval',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '14',
                'nom_region' => 'Lanaudière',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '15',
                'nom_region' => 'Laurentides',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '16',
                'nom_region' => 'Montérégie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_region' => '17',
                'nom_region' => 'Centre-du-Québec',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
