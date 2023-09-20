<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Lino',
            'last_name' => 'Puma', 
            'email' => 'ccppuno@admin.com', 
            'password' => 'test123***', 
            'role' => 'admin'
        ]);

        Event::create([
            'name' => 'GUBER 2023',
            'start_date' => '2023-10-26',
            'end_date' => '2023-10-28',
            'cost' => 100.00,
            'status' => true,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
