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
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Author',
            'email' => 'author@example.com',
            'password' => bcrypt('author@example.com'),
            'role' => 'author',
        ]);

        User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => bcrypt('editor@example.com'),
            'role' => 'editor',
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

        DB::table('menu')->insert([
            'menuName' => 'Berita',
            'menuType' => 'page',
            'menuUrl' => '1',
            'menuTarget' => '_blank',
            'menuOrder' => 1,
        ]);

        DB::table('menu')->insert([
            'menuName' => 'Google',
            'menuType' => 'url',
            'menuUrl' => 'https://www.google.com',
            'menuTarget' => '_blank',
            'menuOrder' => 2,
        ]);

        DB::table('menu')->insert([
            'menuName' => 'Cloud Storage',
            'menuType' => 'url',
            'menuUrl' => '#',
            'menuTarget' => '_self',
            'menuOrder' => 3,
        ]);

        DB::table('menu')->insert([
            'menuName' => 'Google Cloud Platform',
            'menuType' => 'url',
            'menuUrl' => 'https://cloud.google.com',
            'menuTarget' => '_self',
            'menuOrder' => 1,
            'menuParent' => 3
        ]);

        DB::table('menu')->insert([
            'menuName' => 'Amazon Web Services',
            'menuType' => 'url',
            'menuUrl' => 'https://aws.amazon.com',
            'menuTarget' => '_self',
            'menuOrder' => 2,
            'menuParent' => 3
        ]);
    }
}
