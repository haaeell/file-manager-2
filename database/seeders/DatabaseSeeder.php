<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentsTableSeeder::class,
            PegawaiTableSeeder::class,
            UsersTableSeeder::class,
            FilesTableSeeder::class,
            FoldersTableSeeder::class,
            FileShareTableSeeder::class,
        ]);
    }
}
