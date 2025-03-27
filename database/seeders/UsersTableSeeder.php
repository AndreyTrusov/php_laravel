<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
//    public function run(): void
//    {
//        DB::table('users')->insert([
//            ['name' => 'Admin', 'email' => 'admin@ukf.sk', 'password' => Hash::make('123'), 'created_at' => now(), 'updated_at' => now()],
//            ['name' => 'David Držík', 'email' => 'david.drzik@ukf.sk', 'password' => Hash::make('456'), 'created_at' => now(), 'updated_at' => now()],
//            ['name' => 'Jozef Kapusta', 'email' => 'jkapusta@ukf.sk', 'password' => Hash::make('789'), 'created_at' => now(), 'updated_at' => now()],
//        ]);
//    }

    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::factory(5)->create();
    }
}
