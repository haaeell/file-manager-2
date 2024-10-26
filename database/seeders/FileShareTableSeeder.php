<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileShareTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_share')->insert([
            ['file_id' => 1, 'shared_with_id' => 2, 'permission' => 'view'],
            ['file_id' => 2, 'shared_with_id' => 3, 'permission' => 'edit'],
        ]);
    }
}
