<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class NoteCategoryTableSeeder extends Seeder
{
    public function run()
    {
        // Get all notes and categories
        $notes = Note::all();
        $categories = Category::all();
        $categoryCount = $categories->count();

        // Assign 1-3 random categories to each note
        foreach ($notes as $note) {
            // Generate 1-3 random unique category IDs
            $randomCategoryIds = [];
            $numCategories = rand(1, 3);

            for ($i = 0; $i < $numCategories; $i++) {
                $randomCategoryId = $categories->random()->id;

                // Make sure we don't add duplicate categories
                if (!in_array($randomCategoryId, $randomCategoryIds)) {
                    $randomCategoryIds[] = $randomCategoryId;

                    // Insert into pivot table
                    DB::table('note_category')->insert([
                        'note_id' => $note->id,
                        'category_id' => $randomCategoryId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}