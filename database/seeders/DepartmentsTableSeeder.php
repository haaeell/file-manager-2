<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'IT Department', 'head_id' => null],
            ['name' => 'HR Department', 'head_id' => null],
            ['name' => 'Finance Department', 'head_id' => null],
            ['name' => 'Marketing Department', 'head_id' => null],
        ]);
    }
}
