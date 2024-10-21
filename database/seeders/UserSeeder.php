<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id_fournisseurs' => 0,
                'name' => 'John',
                'email' => 'John@Johnmail.john',
                'NEQ' => null,
                'password' => Hash::make('JohnIsAwsome'),
                'role' => '',
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
                'role' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'admin',
                'email' => null,
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
                'email' => null,
                'NEQ' => null,
                'password' => Hash::make('responsable'),
                'role' => 'Responsable',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'id_fournisseurs' => 0,
                'name' => 'commis',
                'email' => null,
                'NEQ' => null,
                'password' => Hash::make('commis'),
                'role' => 'Commis',
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ],

        ]);
    }
}
