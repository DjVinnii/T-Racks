<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class HardwareTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hardware_types')->insert(['name' => 'Server']);
        DB::table('hardware_types')->insert(['name' => 'Switch']);
        DB::table('hardware_types')->insert(['name' => 'Router']);
        DB::table('hardware_types')->insert(['name' => 'Patch Panel']);
        DB::table('hardware_types')->insert(['name' => 'Cable Management']);
    }
}



