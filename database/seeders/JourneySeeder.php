<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JourneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Journey::factory(50)->create();
    }
}
