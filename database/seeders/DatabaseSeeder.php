<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Click;
use App\Models\Link;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Yasine Benaid',
            'email' => 'ysbenaid@gmail.com',
        ]);

        $links = Link::factory(50)->create(['user_id' => $user->id]);

        $links->each(fn ($link) => Click::factory(rand(100, 200))->create([
            'model_type' => Link::class,
            'model_id' => $link->id,
        ]));
    }
}
