<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id_fournisseurs' => 0,
                'name' => 'John',
                'email' => 'John@Johnmail.john',
                'NEQ' => null,
                'password' => Hash::make('JohnIsAwsome'),
                'role' => 'Fournisseur',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'Bob',
                'email' => null,
                'NEQ' => '1234567891',
                'password' => Hash::make('BobIsBald'),
                'role' => 'Fournisseur',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'admin',
                'email' => 'admin',
                'NEQ' => null,
                'password' => Hash::make('admin'),
                'role' => 'Administrateur',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'responsable',
                'email' => 'responsable',
                'NEQ' => null,
                'password' => Hash::make('Responsable'),
                'role' => 'Responsable',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'commise',
                'email' => 'commis',
                'NEQ' => null,
                'password' => Hash::make('Commis'),
                'role' => 'Commis',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],

        ]);
    }
}
