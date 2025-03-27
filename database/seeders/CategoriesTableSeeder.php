<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Work',
            'Personal',
            'Study',
            'Projects',
            'Ideas',
            'Shopping',
            'Health',
            'Finance',
            'Travel',
            'Family'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Category::factory(5)->create();
    }
}
