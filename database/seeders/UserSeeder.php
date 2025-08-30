<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'manager']
        );


        // Sample team
        foreach ([
                     ['name' => 'Alex Housekeeping', 'email' => 'alex@example.com'],
                     ['name' => 'Sam Maintenance', 'email' => 'sam@example.com'],
                     ['name' => 'Riley Frontdesk', 'email' => 'riley@example.com'],
                 ] as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password'), 'is_available' => true]
            );
        }
    }
}
