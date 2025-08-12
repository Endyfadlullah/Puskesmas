<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Poli;

class DisplayController extends Controller
{
    public function index()
    {
        // Get all available polis
        $polis = Poli::all();
        
        // Current: sedang dipanggil per poli
        $poliUmumCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'umum');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliGigiCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'gigi');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliJiwaCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan jiwa');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliTradisionalCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan tradisional');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        // Next: menunggu per poli (maks 3)
        $poliUmumNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'umum');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliGigiNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'gigi');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliJiwaNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan jiwa');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliTradisionalNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan tradisional');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        return view('display.index', compact(
            'poliUmumCurrent',
            'poliGigiCurrent',
            'poliJiwaCurrent',
            'poliTradisionalCurrent',
            'poliUmumNext',
            'poliGigiNext',
            'poliJiwaNext',
            'poliTradisionalNext'
        ));
    }

    public function checkNewCalls(Request $request)
    {
        $lastCheck = $request->get('last_check', 0);
        $lastCheckTime = date('Y-m-d H:i:s', $lastCheck / 1000);

        // Check for new calls since last check
        $newCall = \App\Models\RiwayatPanggilan::with(['antrian.poli'])
            ->where('waktu_panggilan', '>', $lastCheckTime)
            ->whereDate('waktu_panggilan', today())
            ->orderBy('waktu_panggilan', 'desc')
            ->first();

        if ($newCall) {
            return response()->json([
                'has_new_call' => true,
                'antrian' => [
                    'poli_name' => $newCall->antrian->poli->nama_poli,
                    'queue_number' => $newCall->antrian->no_antrian,
                    'antrian_id' => $newCall->antrian->id
                ]
            ]);
        }

        return response()->json([
            'has_new_call' => false
        ]);
    }

    public function getDisplayData()
    {
        // Current: sedang dipanggil per poli
        $poliUmumCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'umum');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliGigiCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'gigi');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliJiwaCurrent = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan jiwa');
            })
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliTradisionalCurrent = Antrian::where('poli_id', 4)
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        // Next: menunggu per poli (maks 3)
        $poliUmumNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'umum');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliGigiNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'gigi');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        $poliJiwaNext = Antrian::whereHas('poli', function($query) {
                $query->where('nama_poli', 'kesehatan jiwa');
            })
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliTradisionalNext = Antrian::where('poli_id', 4)
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        return response()->json([
            'poliUmumCurrent' => $poliUmumCurrent,
            'poliGigiCurrent' => $poliGigiCurrent,
            'poliJiwaCurrent' => $poliJiwaCurrent,
            'poliTradisionalCurrent' => $poliTradisionalCurrent,
            'poliUmumNext' => $poliUmumNext,
            'poliGigiNext' => $poliGigiNext,
            'poliJiwaNext' => $poliJiwaNext,
            'poliTradisionalNext' => $poliTradisionalNext
        ]);
    }
}
