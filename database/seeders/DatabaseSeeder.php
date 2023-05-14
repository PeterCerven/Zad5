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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'is_teacher' => true,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Student1',
            'email' => 'student1@example.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Student2',
            'email' => 'student2@example.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Student3',
            'email' => 'student3@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
