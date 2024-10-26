<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin', 'pegawai_id' => null],
            ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password'), 'role' => 'pegawai', 'pegawai_id' => 1],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => Hash::make('password'), 'role' => 'pegawai', 'pegawai_id' => 2],
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => Hash::make('password'), 'role' => 'pegawai', 'pegawai_id' => 3],
            ['name' => 'Bob Brown', 'email' => 'bob@example.com', 'password' => Hash::make('password'), 'role' => 'pegawai', 'pegawai_id' => 4],
        ]);
    }
}
