<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DEBUG ANTRIAN ===\n";
echo "Tanggal hari ini: " . now()->toDateString() . "\n";
echo "Total antrian di database: " . DB::table('antrians')->count() . "\n";
echo "Total antrian hari ini: " . DB::table('antrians')->whereDate('created_at', today())->count() . "\n";

echo "\n=== ANTRIAN TERBARU ===\n";
$antrians = DB::table('antrians')->orderBy('created_at', 'desc')->limit(5)->get();
foreach($antrians as $antrian) {
    echo "ID: {$antrian->id}, Tanggal: {$antrian->created_at}, Status: {$antrian->status}\n";
}

echo "\n=== POLI DI DATABASE ===\n";
$polis = DB::table('polis')->get();
foreach($polis as $poli) {
    echo "ID: {$poli->id}, Nama: {$poli->nama_poli}\n";
}

echo "\n=== ANTRIAN HARI INI DENGAN POLI ===\n";
$antrianToday = DB::table('antrians')
    ->join('polis', 'antrians.poli_id', '=', 'polis.id')
    ->whereDate('antrians.created_at', today())
    ->select('antrians.*', 'polis.nama_poli')
    ->get();

if($antrianToday->count() > 0) {
    foreach($antrianToday as $antrian) {
        echo "ID: {$antrian->id}, No: {$antrian->no_antrian}, Status: {$antrian->status}, Poli: {$antrian->nama_poli}\n";
    }
} else {
    echo "Tidak ada antrian hari ini\n";
}

echo "\n=== ANTRIAN MENUNGGU HARI INI ===\n";
$waitingToday = DB::table('antrians')
    ->join('polis', 'antrians.poli_id', '=', 'polis.id')
    ->where('antrians.status', 'menunggu')
    ->whereDate('antrians.created_at', today())
    ->select('antrians.*', 'polis.nama_poli')
    ->get();

if($waitingToday->count() > 0) {
    foreach($waitingToday as $antrian) {
        echo "ID: {$antrian->id}, No: {$antrian->no_antrian}, Poli: {$antrian->nama_poli}\n";
    }
} else {
    echo "Tidak ada antrian menunggu hari ini\n";
}

echo "\n=== ANTRIAN MENUNGGU (SEMUA TANGGAL) ===\n";
$waitingAll = DB::table('antrians')
    ->join('polis', 'antrians.poli_id', '=', 'polis.id')
    ->where('antrians.status', 'menunggu')
    ->select('antrians.*', 'polis.nama_poli')
    ->get();

if($waitingAll->count() > 0) {
    foreach($waitingAll as $antrian) {
        echo "ID: {$antrian->id}, No: {$antrian->no_antrian}, Tanggal: {$antrian->created_at}, Poli: {$antrian->nama_poli}\n";
    }
} else {
    echo "Tidak ada antrian menunggu sama sekali\n";
}
