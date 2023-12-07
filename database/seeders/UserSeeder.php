<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Herbert',
            'email' => 'herbertpansini@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'ROLE_ADMIN',
            'device' => '',
        ]);

        DB::table('users')->insert([
            'name' => 'Danielle',
            'email' => 'daniellepansini@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'ROLE_USER',
            'device' => '',
        ]);

        DB::table('users')->insert([
            'name' => 'Roberto',
            'email' => 'robertoclarindoandrade@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'ROLE_USER',
            'device' => '',
        ]);
    }
}