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
            ['user_id' => 1, 'department_id' => 1, 'name' => 'Project Plan', 'type' => 'images' ,'path' => '/files/project_plan.pdf', 'size' => 2048, 'is_favorite' => false],
            ['user_id' => 2, 'department_id' => 2, 'name' => 'Employee Handbook', 'type' => 'images', 'path' => '/files/employee_handbook.pdf', 'size' => 1024, 'is_favorite' => true],
        ]);
    }
}
