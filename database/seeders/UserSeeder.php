<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('123456789'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        User::insert($data);
    }
}
