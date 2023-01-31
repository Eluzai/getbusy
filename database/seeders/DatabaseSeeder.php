<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(5)->create();
        $user = User::factory()->create([
            'name' => 'Ebuka Bukas',
            'email' => 'bucks@gigs.com',
        ]);
        Listing::factory(6)->create([
            'user_id' => $user->id
        ]);

        // Listing::create([
        //     'title' => 'Senior frontend enginerr',
        //     'tags' => 'react, angular, javascript',
        //     'company' => 'R&D Corp',
        //     'location' => 'Rivers, PH',
        //     'email' => 'hr@rnd.net',
        //     'website' => 'http://www.rnd.net',
        //     'description' => 'A perfect description for the role at hand. It should be succint.'
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
