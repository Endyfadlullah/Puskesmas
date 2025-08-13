<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AntrianPuskesmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin data is seeded in AdminSeeder to avoid duplication

        // Seed polis table with upsert to avoid duplicates
        $polis = [
            ['id' => 1, 'nama_poli' => 'umum'],
            ['id' => 2, 'nama_poli' => 'gigi'],
            ['id' => 3, 'nama_poli' => 'kesehatan jiwa'],
            ['id' => 4, 'nama_poli' => 'kesehatan tradisional'],
        ];
        foreach ($polis as $poli) {
            DB::table('polis')->updateOrInsert(
                ['id' => $poli['id']],
                ['nama_poli' => $poli['nama_poli'], 'updated_at' => now()]
            );
        }



        // Seed users table with upsert
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No.1',
                'jenis_kelamin' => 'laki-laki',
                'no_hp' => '08123456789',
                'no_ktp' => '1234567890123456',
                'pekerjaan' => 'Petani',
                'password' => Hash::make('password'),
                'updated_at' => now(),
            ]
        );

        // Seed antrians table with upsert
        DB::table('antrians')->updateOrInsert(
            ['id' => 1],
            [
                'user_id' => 1,
                'poli_id' => 1,
                'no_antrian' => 'U1',
                'tanggal_antrian' => now()->toDateString(),
                'is_call' => 0,
                'status' => 'menunggu',
                'waktu_panggil' => null,
                'updated_at' => now(),
            ]
        );

        // Add more antrian data for testing
        DB::table('antrians')->updateOrInsert(
            ['id' => 2],
            [
                'user_id' => 1,
                'poli_id' => 2,
                'no_antrian' => 'G1',
                'tanggal_antrian' => now()->toDateString(),
                'is_call' => 0,
                'status' => 'menunggu',
                'waktu_panggil' => null,
                'updated_at' => now(),
            ]
        );

        DB::table('antrians')->updateOrInsert(
            ['id' => 3],
            [
                'user_id' => 1,
                'poli_id' => 3,
                'no_antrian' => 'J1',
                'tanggal_antrian' => now()->toDateString(),
                'is_call' => 0,
                'status' => 'dipanggil',
                'waktu_panggil' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('antrians')->updateOrInsert(
            ['id' => 4],
            [
                'user_id' => 1,
                'poli_id' => 4,
                'no_antrian' => 'T1',
                'tanggal_antrian' => now()->toDateString(),
                'is_call' => 0,
                'status' => 'menunggu',
                'waktu_panggil' => null,
                'updated_at' => now(),
            ]
        );
    }
}
