<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            NotesTableSeeder::class,
            NoteCategoryTableSeeder::class,
        ]);

        $categories = Category::factory(10)->create();
    }
}
