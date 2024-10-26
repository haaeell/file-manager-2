<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('files')->insert([
            ['user_id' => 1, 'department_id' => 1, 'name' => 'Project Plan', 'path' => '/files/project_plan.pdf', 'size' => 2048, 'favorite' => false],
            ['user_id' => 2, 'department_id' => 2, 'name' => 'Employee Handbook', 'path' => '/files/employee_handbook.pdf', 'size' => 1024, 'favorite' => true],
        ]);
    }
}
