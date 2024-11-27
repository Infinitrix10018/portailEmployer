<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'id_fournisseurs' => 0,
            'name' => 'Test User2',
            'email' => 'test2@example.com',
        ]);
        
        $this->call(licencesRBQ::class);
        $this->call(RegionsAdministrativesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(parametreSeeder::class);
    }
}
