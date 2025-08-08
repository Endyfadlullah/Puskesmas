<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loket;

class LoketSeeder extends Seeder
{
    public function run(): void
    {
        $lokets = [
            ['nama_loket' => 'Loket 1'],
            ['nama_loket' => 'Loket 2'],
            ['nama_loket' => 'Loket 3'],
        ];

        foreach ($lokets as $loket) {
            Loket::create($loket);
        }
    }
}
