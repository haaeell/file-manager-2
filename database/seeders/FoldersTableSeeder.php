<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('folders')->insert([
            ['user_id' => 1, 'department_id' => 1, 'name' => 'Reports', 'parent_id' => null],
            ['user_id' => 2, 'department_id' => 2, 'name' => 'Training', 'parent_id' => null],
        ]);
    }
}
