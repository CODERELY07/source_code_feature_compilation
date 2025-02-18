<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        $agent = User::create([
           'name' => 'Agent User',
            'email' => 'agent@example.com',
            'password' => Hash::make('123456'),
            'role' => 'agent'
        ]);

        $user = User::create([
            'name' => ' User',
             'email' => 'user@example.com',
             'password' => Hash::make('123456'),
             'role' => 'user'
        ]);
    }
}
