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
    public function run()
    {
        User::create([
            'username' => 'debuguser',
            'email' => 'debug@example.com',
            'no_hp' => '08123456789',
            'pwd_hash' => Hash::make('password'),
            'password' => Hash::make('password'),
            'nomor_induk' => '999999',
            'nama_lengkap' => 'Debug User',
            'tahun_masuk' => 2023,
            'jenjang' => 5,
            'kode_prodi' => 7,
            'offering' => 'A',
            'jenis_kelamin' => 'L',
            'level' => 0,
            'status' => 1,
        ]);
    }
}
