<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Poli Umum'],
            ['nama_poli' => 'Poli Gigi'],
            ['nama_poli' => 'Poli Jiwa'],
            ['nama_poli' => 'Poli Tradisional'],
        ];

        foreach ($polis as $poli) {
            Poli::create($poli);
        }
    }
}
