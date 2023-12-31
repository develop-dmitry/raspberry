<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Clothes;
use App\Models\Event;
use App\Models\Look;
use App\Models\Style;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $events = Event::factory(30)->create();
        $styles = Style::factory(15)->create();

        $clothes = Clothes::factory(100)
            ->create()
            ->each(fn (Clothes $clothes) => $clothes->styles()->attach($styles->random(3)));

        User::factory(10)
            ->create()
            ->each(fn (User $user) => $user->clothes()->attach($clothes->random(5)));

        Look::factory(10)
            ->create()
            ->each(fn (Look $look) => $look->clothes()->attach($clothes->random(5)))
            ->each(fn (Look $look) => $look->events()->attach($events->random(3)));

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
