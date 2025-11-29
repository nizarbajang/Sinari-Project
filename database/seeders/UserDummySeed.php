<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Anda mengimpor Model User

class UserDummySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data akun dummy yang spesifik
        $users = [
            [
                'name' => 'Admin Utama',
                'email' => 'admin@test.com',
                'phone' => '081111111111',
                'role' => 'admin',
            ],
            [
                'name' => 'Investor Uji Coba',
                'email' => 'investor@test.com',
                'phone' => '082222222222',
                'role' => 'investor',
            ],
            [
                'name' => 'Peternak Uji Coba',
                'email' => 'farmer@test.com',
                'phone' => '083333333333',
                'role' => 'farmer',
            ],
        ];

        // Hapus data lama (opsional, untuk memastikan data bersih)
        User::whereIn('email', ['admin@test.com', 'investor@test.com', 'farmer@test.com'])->delete();


        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'password' => Hash::make('password'), // Semua akun menggunakan password: password
                'role' => $userData['role'],
                'address' => 'Dummy Address',
                'avatar' => null,
                'status' => 'active',
            ]);
        }
        
        $this->command->info('✅ 3 Akun Dummy (Admin, Investor, Farmer) berhasil dibuat!');
    }
}