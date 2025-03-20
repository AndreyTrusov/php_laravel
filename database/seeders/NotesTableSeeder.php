<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notes')->insert([
            ['user_id' => 1, 'title' => 'Laravel Seeder', 'body' => 'Ako vytvoriť seeder v Laraveli?', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'title' => 'Shopping List', 'body' => 'Mlieko, chlieb, vajcia', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'title' => 'Project Idea', 'body' => 'Nápad na nový startup...', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
