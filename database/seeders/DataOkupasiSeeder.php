<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DataOkupasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_okupasi')->insert([
            [
                'id' => 1,
                'nama_okupasi' => 'Rumah',
                'premi' => 0.3875,
            ],
            [
                'id' => 2,
                'nama_okupasi' => 'Ruko',
                'premi' => 0.5,
            ]


        ]);
    }
}
