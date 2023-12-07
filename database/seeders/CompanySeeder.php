<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('companies')->insert([
            'name' => 'Trimble',
        ]);

        DB::table('companies')->insert([
            'name' => 'Cobli',
        ]);

        DB::table('companies')->insert([
            'name' => 'Creare',
        ]);

        DB::table('companies')->insert([
            'name' => 'Ituran',
        ]);

        DB::table('companies')->insert([
            'name' => 'Maxtrack',
        ]);

        DB::table('companies')->insert([
            'name' => 'Águia Branca',
        ]);

        DB::table('companies')->insert([
            'name' => 'GolFleet',
        ]);

        DB::table('companies')->insert([
            'name' => 'X-Itech',
        ]);

        DB::table('companies')->insert([
            'name' => 'Gauss Fleet',
        ]);

        DB::table('companies')->insert([
            'name' => 'LogSat',
        ]);
    }
}
