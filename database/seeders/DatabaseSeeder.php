<?php

namespace Database\Seeders;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@cents.test',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@cents.test',
        ]);
        \App\Models\Lista::factory()->hasProducts(5)->count(5)->create([
            'user_id' => 1,
        ]);
        \App\Models\Lista::factory()->hasProducts(3)->count(2)->create([
            'user_id' => 2,
        ]);
    }
}
