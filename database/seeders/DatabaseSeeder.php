<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test@example.com'),
        ]);

        DB::table('category')->insert([
            'nameCategory' => 'Politik',
        ]);

        DB::table('news')->insert([
            'newsTitle' => 'Berita Politik',
            'newsContent' => 'Berita tentang politik',
            'newsImage' => 'berita_politik.jpg',
            'idCategory' => 1,
        ]);

        DB::table('page')->insert([
            'pageTitle' => 'Berita Politik',
            'pageContent' => 'Berita tentang politik',
            'isActive' => 1,
        ]);
    }
}
