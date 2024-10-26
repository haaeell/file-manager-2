<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawai')->insert([
            ['name' => 'John Doe', 'department_id' => 1, 'phone_number' => '123456789', 'address' => '123 Main St', 'position' => 'Staf'],
            ['name' => 'Jane Smith', 'department_id' => 2, 'phone_number' => '987654321', 'address' => '456 Elm St', 'position' => 'Ketua Departemen'],
            ['name' => 'Alice Johnson', 'department_id' => 3, 'phone_number' => '555123456', 'address' => '789 Maple St', 'position' => 'Staf'],
            ['name' => 'Bob Brown', 'department_id' => 4, 'phone_number' => '444987654', 'address' => '321 Oak St', 'position' => 'Staf'],
        ]);
    }
}
