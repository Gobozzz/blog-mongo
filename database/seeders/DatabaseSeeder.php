<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Goboz',
            'email' => 'gobozovbogdan@gmail.com',
            'password' => Hash::make('qwerty'),
        ]);

        User::factory(1)->create();

        User::factory(1)->moderator()->create([
            'name' => 'Moderator',
            'email' => 'moderator@gmail.com',
            'password' => Hash::make('qwerty'),
        ]);

        Tag::factory(10)->create();

        Post::factory(5)->create();

        Post::factory(25)->withComments(10)->withTags(3)->create();

    }
}
