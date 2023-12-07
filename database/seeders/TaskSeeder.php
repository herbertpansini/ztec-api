<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            'user_id' => 1,
            'company_id' => 1,
            'scheduled_datetime' => '2023-11-28 09:00:00',
            'description' => 'Instalar rastreador',
            'value' => 10.0,
        ]);

        DB::table('tasks')->insert([
            'user_id' => 2,
            'company_id' => 2,
            'scheduled_datetime' => '2023-11-28 09:00:00',
            'description' => 'Instalar tacom',
            'value' => 20.0,
        ]);

        DB::table('tasks')->insert([
            'user_id' => 3,
            'company_id' => 3,
            'scheduled_datetime' => '2023-11-29 10:00:00',
            'description' => 'Instalar Led',
            'value' => 15.0,
        ]);

        DB::table('tasks')->insert([
            'user_id' => 2,
            'company_id' => 4,
            'scheduled_datetime' => '2023-11-30 11:00:00',
            'description' => 'Instalar USB',
            'value' => 25.0,
        ]);

        DB::table('tasks')->insert([
            'user_id' => 1,
            'company_id' => 5,
            'scheduled_datetime' => '2023-11-30 14:00:00',
            'description' => 'Instalar Led',
            'value' => 30.0,
        ]);
    }
}