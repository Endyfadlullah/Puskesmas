<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Poli;

class DisplayController extends Controller
{
    public function index()
    {
        // Current: sedang dipanggil per poli
        $poliUmumCurrent = Antrian::where('poli_id', 1)
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliGigiCurrent = Antrian::where('poli_id', 2)
            ->where('status', 'dipanggil')
            ->whereDate('created_at', today())
            ->orderByDesc('updated_at')
            ->first();

        $poliJiwaCurrent = Antrian::where('poli_id', 3)
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
        $poliUmumNext = Antrian::where('poli_id', 1)
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliGigiNext = Antrian::where('poli_id', 2)
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(3)
            ->get();

        $poliJiwaNext = Antrian::where('poli_id', 3)
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
}
