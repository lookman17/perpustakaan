<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_id' => 'U001',
            'user_nama' => 'Admin',
            'user_alamat' => 'Jl. Contoh Alamat 1',
            'user_username' => 'admin',
            'user_email' => 'admin@example.com',
            'user_notelp' => '08123456789',
            'user_password' => 'password', 
            'user_level' => 'admin',
            'user_pict_url' => null,
        ]);
    }
}
