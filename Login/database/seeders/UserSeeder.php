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
            'name' => 'admin',
            'nomor_rekening' => '0000000000001',
            'email' => 'admin@gmail.com',
            'status' => 'active',
            'role' => 'admin',
            'password' => 'admin'
        ]);

        User::create([
            'name' => 'nasabah',
            'nomor_rekening' => '0000000000002',
            'email' => 'nasabah@gmail.com',
            'status' => 'active',
            'role' => 'nasabah',
            'password' => 'nasabah'
        ]);

        User::create([
            'name' => 'sachras',
            'nomor_rekening' => '0000000000003',
            'email' => 'sachras@gmail.com',
            'status' => 'active',
            'role' => 'nasabah',
            'password' => 'sachras'
        ]);
    }
}