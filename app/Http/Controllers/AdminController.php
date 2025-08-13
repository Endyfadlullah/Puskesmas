<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Admin;
use App\Models\Antrian;
use App\Models\Poli;
use App\Models\RiwayatPanggilan;
use App\Services\AudioService;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $totalUsers = User::count();
        $totalAntrian = Antrian::count();
        $antrianHariIni = Antrian::whereDate('created_at', today())->count();
        $polis = Poli::count();

        // Get counts for each poli (all waiting queues - not just today)
        // Using direct queries for better performance and debugging
        $poliUmumCount = DB::table('antrians')
            ->join('polis', 'antrians.poli_id', '=', 'polis.id')
            ->where('polis.nama_poli', 'umum')
            ->where('antrians.status', 'menunggu')
            ->count();

        $poliGigiCount = DB::table('antrians')
            ->join('polis', 'antrians.poli_id', '=', 'polis.id')
            ->where('polis.nama_poli', 'gigi')
            ->where('antrians.status', 'menunggu')
            ->count();

        $poliJiwaCount = DB::table('antrians')
            ->join('polis', 'antrians.poli_id', '=', 'polis.id')
            ->where('polis.nama_poli', 'kesehatan jiwa')
            ->where('antrians.status', 'menunggu')
            ->count();

        $poliTradisionalCount = DB::table('antrians')
            ->join('polis', 'antrians.poli_id', '=', 'polis.id')
            ->where('polis.nama_poli', 'kesehatan tradisional')
            ->where('antrians.status', 'menunggu')
            ->count();

        // Temporary debug: Check if there are any antrian at all today
        $totalAntrianToday = DB::table('antrians')
            ->whereDate('created_at', today())
            ->count();
        
        $totalWaitingToday = DB::table('antrians')
            ->where('status', 'menunggu')
            ->whereDate('created_at', today())
            ->count();

        // Debug: Check all polis in database
        $allPolis = DB::table('polis')->get();
        
        // Debug: Check all antrian today with poli info
        $allAntrianToday = DB::table('antrians')
            ->join('polis', 'antrians.poli_id', '=', 'polis.id')
            ->whereDate('antrians.created_at', today())
            ->select('antrians.*', 'polis.nama_poli')
            ->get();

        // Log debug info
        Log::info('Dashboard Debug:', [
            'totalAntrianToday' => $totalAntrianToday,
            'totalWaitingToday' => $totalWaitingToday,
            'poliUmumCount' => $poliUmumCount,
            'poliGigiCount' => $poliGigiCount,
            'poliJiwaCount' => $poliJiwaCount,
            'poliTradisionalCount' => $poliTradisionalCount,
            'today' => today()->toDateString(),
            'allPolis' => $allPolis->pluck('nama_poli', 'id')->toArray(),
            'allAntrianToday' => $allAntrianToday->map(function($antrian) {
                return [
                    'id' => $antrian->id,
                    'no_antrian' => $antrian->no_antrian,
                    'status' => $antrian->status,
                    'poli_nama' => $antrian->nama_poli,
                    'created_at' => $antrian->created_at
                ];
            })->toArray()
        ]);

        // Get recent antrian
        $antrianTerbaru = Antrian::with(['user', 'poli'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAntrian',
            'antrianHariIni',
            'polis',
            'poliUmumCount',
            'poliGigiCount',
            'poliJiwaCount',
            'poliTradisionalCount',
            'antrianTerbaru'
        ));
    }

    public function manageUsers(Request $request)
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $query = User::with(['antrians.poli']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_ktp', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load(['antrians.poli']);
        return view('admin.users.show', compact('user'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:20',
            'no_ktp' => 'required|string|size:16|unique:users|regex:/^[0-9]+$/',
            'pekerjaan' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'no_ktp.size' => 'Nomor KTP harus tepat 16 digit.',
            'no_ktp.regex' => 'Nomor KTP hanya boleh berisi angka.',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = User::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'no_ktp' => $request->no_ktp,
                'pekerjaan' => $request->pekerjaan,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan user.'])->withInput();
        }
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:20',
            'no_ktp' => 'required|string|max:50|unique:users,no_ktp,' . $user->id,
            'pekerjaan' => 'required|string|max:100',
        ]);

        try {
            $user->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'no_ktp' => $request->no_ktp,
                'pekerjaan' => $request->pekerjaan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetUserPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password user berhasil direset!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function laporan(Request $request)
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $query = Antrian::with(['user', 'poli']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan poli
        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $antrian = $query->orderBy('created_at', 'desc')->get();
        $polis = Poli::all();

        // Statistik
        $totalAntrian = $antrian->count();
        $antrianSelesai = $antrian->where('status', 'selesai')->count();
        $antrianMenunggu = $antrian->where('status', 'menunggu')->count();
        $antrianDipanggil = $antrian->where('status', 'dipanggil')->count();
        $antrianBatal = $antrian->where('status', 'batal')->count();

        return view('admin.laporan.index', compact(
            'antrian', 
            'polis', 
            'totalAntrian', 
            'antrianSelesai', 
            'antrianMenunggu', 
            'antrianDipanggil', 
            'antrianBatal'
        ));
    }

    public function exportPDF(Request $request)
    {
        $query = Antrian::with(['user', 'poli']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan poli
        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $antrian = $query->orderBy('created_at', 'desc')->get();

        // Statistik untuk PDF
        $totalAntrian = $antrian->count();
        $antrianSelesai = $antrian->where('status', 'selesai')->count();
        $antrianMenunggu = $antrian->where('status', 'menunggu')->count();
        $antrianDipanggil = $antrian->where('status', 'dipanggil')->count();
        $antrianSedang = $antrian->where('status', 'sedang')->count();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('antrian', 'totalAntrian', 'antrianSelesai', 'antrianMenunggu', 'antrianDipanggil', 'antrianSedang'));
        return $pdf->download('laporan-antrian-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Antrian::with(['user', 'poli']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan poli
        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $antrian = $query->orderBy('created_at', 'desc')->get();

        // Statistik untuk Excel
        $totalAntrian = $antrian->count();
        $antrianSelesai = $antrian->where('status', 'selesai')->count();
        $antrianMenunggu = $antrian->where('status', 'menunggu')->count();
        $antrianDipanggil = $antrian->where('status', 'dipanggil')->count();
        $antrianSedang = $antrian->where('status', 'sedang')->count();

        $filename = 'laporan-antrian-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($antrian) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'No Antrian',
                'Nama Pasien',
                'No KTP',
                'Jenis Kelamin',
                'Poli',
                'Status',
                'Tanggal Daftar',
                'Waktu Daftar',
                'Waktu Panggil'
            ]);

            // Data CSV
            foreach ($antrian as $item) {
                fputcsv($file, [
                    $item->no_antrian,
                    $item->user->nama,
                    $item->user->no_ktp,
                    $item->user->jenis_kelamin,
                    $item->poli->nama_poli,
                    ucfirst($item->status),
                    $item->created_at ? $item->created_at->format('d/m/Y') : '-',
                    $item->created_at ? $item->created_at->format('H:i') : '-',
                    $item->waktu_panggil ? $item->waktu_panggil->format('H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function poliUmum()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $antrians = Antrian::with(['user', 'poli'])
            ->whereHas('poli', function ($query) {
                $query->where('nama_poli', 'umum');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $title = 'Poli Umum';
        return view('admin.poli.index', compact('antrians', 'title'));
    }

    public function poliGigi()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $antrians = Antrian::with(['user', 'poli'])
            ->whereHas('poli', function ($query) {
                $query->where('nama_poli', 'gigi');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $title = 'Poli Gigi';
        return view('admin.poli.index', compact('antrians', 'title'));
    }

    public function poliJiwa()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $antrians = Antrian::with(['user', 'poli'])
            ->whereHas('poli', function ($query) {
                $query->where('nama_poli', 'kesehatan jiwa');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $title = 'Poli Jiwa';
        return view('admin.poli.index', compact('antrians', 'title'));
    }

    public function poliTradisional()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $antrians = Antrian::with(['user', 'poli'])
            ->whereHas('poli', function ($query) {
                $query->where('nama_poli', 'kesehatan tradisional');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $title = 'Poli Tradisional';
        return view('admin.poli.index', compact('antrians', 'title'));
    }

    public function panggilAntrian(Request $request)
    {
        try {
            // Get the next waiting queue
            $antrian = Antrian::where('status', 'menunggu')
                ->orderBy('created_at', 'asc')
                ->first();

            if (!$antrian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada antrian yang menunggu'
                ]);
            }

            // Update status to 'dipanggil' and set call time
            $antrian->update([
                'status' => 'dipanggil',
                'waktu_panggil' => now()
            ]);

            // Record call history
            RiwayatPanggilan::create([
                'antrian_id' => $antrian->id,
                'waktu_panggilan' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrian->no_antrian . ' dipanggil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function panggilAntrianById(Antrian $antrian)
    {
        try {
            // Load relasi yang diperlukan
            $antrian->load(['user', 'poli']);
            
            if ($antrian->status !== 'menunggu') {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian ini tidak dalam status menunggu'
                ]);
            }

            // Update status to 'dipanggil' and set call time
            $antrian->update([
                'status' => 'dipanggil',
                'waktu_panggil' => now()
            ]);

            // Record call history
            RiwayatPanggilan::create([
                'antrian_id' => $antrian->id,
                'waktu_panggilan' => now()
            ]);

            // Broadcast event for display page
            event(new \App\Events\AntrianDipanggil($antrian));

            // Refresh data antrian setelah update
            $antrian->refresh();
            $antrian->load(['user', 'poli']);

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrian->no_antrian . ' dipanggil',
                'poli_name' => $antrian->poli->nama_poli,
                'queue_number' => $antrian->no_antrian,
                'antrian' => [
                    'id' => $antrian->id,
                    'no_antrian' => $antrian->no_antrian,
                    'poli_name' => $antrian->poli->nama_poli,
                    'user_name' => $antrian->user->nama,
                    'status' => $antrian->status
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in panggilAntrianById: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function selesaiAntrian(Request $request)
    {
        try {
            $request->validate([
                'antrian_id' => 'required|exists:antrians,id'
            ]);

            $antrian = Antrian::findOrFail($request->antrian_id);

            if ($antrian->status !== 'dipanggil') {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian ini tidak dalam status dipanggil'
                ]);
            }

            // Update status to 'selesai'
            $antrian->update(['status' => 'selesai']);

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrian->no_antrian . ' selesai'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function batalAntrian(Request $request)
    {
        try {
            $request->validate([
                'antrian_id' => 'required|exists:antrians,id'
            ]);

            $antrian = Antrian::findOrFail($request->antrian_id);

            if ($antrian->status === 'selesai') {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian yang sudah selesai tidak dapat dibatalkan'
                ]);
            }

            // Update status to 'batal'
            $antrian->update(['status' => 'batal']);

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrian->no_antrian . ' dibatalkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function tambahAntrian()
    {
        $polis = Poli::all();
        return view('admin.antrian.tambah', compact('polis'));
    }

    public function cariUser(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:3'
        ]);

        $users = User::where('nama', 'like', "%{$request->search}%")
            ->orWhere('no_ktp', 'like', "%{$request->search}%")
            ->orWhere('no_hp', 'like', "%{$request->search}%")
            ->limit(10)
            ->get(['id', 'nama', 'no_ktp', 'no_hp', 'jenis_kelamin', 'alamat']);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function storeAntrianAdmin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'poli_id' => 'required|exists:polis,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $poli = Poli::findOrFail($request->poli_id);

            // Check if user already has active queue in this poli today
            $existingQueue = Antrian::where('user_id', $request->user_id)
                ->where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->first();

            if ($existingQueue) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ini sudah memiliki antrian aktif di ' . $poli->nama_poli . ' hari ini.'
                ]);
            }

            // Get poli prefix
            $prefix = $this->getPoliPrefix($poli->nama_poli);

            // Get next queue number for the poli
            $lastQueue = Antrian::where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();

            // Extract number from last queue (remove prefix)
            $lastNumber = 0;
            if ($lastQueue && $lastQueue->no_antrian) {
                $lastNumber = (int) preg_replace('/^[A-Z]+/', '', $lastQueue->no_antrian);
            }

            $nextNumber = $lastNumber + 1;
            $nextQueueNumber = $prefix . $nextNumber;

            // Create new queue
            $antrian = Antrian::create([
                'user_id' => $request->user_id,
                'poli_id' => $request->poli_id,
                'no_antrian' => $nextQueueNumber,
                'tanggal_antrian' => now()->toDateString(),
                'status' => 'menunggu'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dibuat untuk ' . $user->nama . ' di ' . $poli->nama_poli . ' dengan nomor ' . $nextQueueNumber,
                'antrian' => [
                    'id' => $antrian->id,
                    'no_antrian' => $nextQueueNumber,
                    'poli_name' => $poli->nama_poli,
                    'user_name' => $user->nama,
                    'status' => 'menunggu'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getPoliPrefix($namaPoli)
    {
        $prefixMap = [
            'umum' => 'U',
            'gigi' => 'G',
            'kesehatan jiwa' => 'J',
            'kesehatan tradisional' => 'T'
        ];

        return $prefixMap[strtolower($namaPoli)] ?? 'A';
    }

    /**
     * Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
     * tanpa dikonfirmasi selesai oleh admin
     */
    private function autoBatalkanAntrianLama()
    {
        try {
            // Cari antrian yang sudah dipanggil lebih dari 5 menit
            $antrianLama = Antrian::where('status', 'dipanggil')
                ->where('waktu_panggil', '<=', now()->subMinutes(5))
                ->get();

            $count = 0;
            foreach ($antrianLama as $antrian) {
                // Update status menjadi 'batal'
                $antrian->update(['status' => 'batal']);
                $count++;

                // Log untuk tracking
                \Log::info("Antrian {$antrian->no_antrian} otomatis dibatalkan karena lewat 5 menit sejak dipanggil");
            }

            // Jika ada antrian yang dibatalkan, log jumlahnya
            if ($count > 0) {
                \Log::info("Total {$count} antrian otomatis dibatalkan karena timeout");
            }
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            \Log::error("Error saat auto-batalkan antrian: " . $e->getMessage());
        }
    }

    public function cetakAntrian(Antrian $antrian)
    {
        try {
            $antrian->load(['user', 'poli']);

            $pdf = Pdf::loadView('admin.antrian.print', compact('antrian'));
            return $pdf->stream('antrian-' . $antrian->no_antrian . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Play audio for queue call
     */
    public function playQueueCallAudio(Request $request)
    {
        try {
            $request->validate([
                'poli_name' => 'required|string'
            ]);

            $poliName = $request->input('poli_name');
            
            // Get audio sequence from AudioService
            $audioService = app(AudioService::class);
            $result = $audioService->getQueueCallAudio($poliName);

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error playing audio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Panggil antrian selanjutnya berdasarkan poli
     */
    public function panggilSelanjutnya(Request $request)
    {
        try {
            $request->validate([
                'poli_name' => 'required|string'
            ]);

            $poliName = $request->input('poli_name');

            // Cari antrian berikutnya yang status 'menunggu'
            $antrianSelanjutnya = Antrian::whereHas('poli', function($query) use ($poliName) {
                    $query->where('nama_poli', $poliName);
                })
                ->where('status', 'menunggu')
                ->whereDate('created_at', today())
                ->orderBy('created_at', 'asc')
                ->first();

            if (!$antrianSelanjutnya) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada antrian yang menunggu untuk ' . $poliName
                ]);
            }

            // Update status menjadi 'dipanggil'
            $antrianSelanjutnya->update([
                'status' => 'dipanggil',
                'waktu_panggil' => now()
            ]);

            // Catat di riwayat panggilan
            \App\Models\RiwayatPanggilan::create([
                'antrian_id' => $antrianSelanjutnya->id,
                'waktu_panggilan' => now(),
                'admin_id' => auth()->id()
            ]);

            // Get audio sequence
            $audioService = app(AudioService::class);
            $audioResult = $audioService->getQueueCallAudio($poliName);

            return response()->json([
                'success' => true,
                'message' => 'Antrian ' . $antrianSelanjutnya->no_antrian . ' berhasil dipanggil',
                'antrian' => [
                    'id' => $antrianSelanjutnya->id,
                    'no_antrian' => $antrianSelanjutnya->no_antrian,
                    'poli_name' => $poliName,
                    'user_name' => $antrianSelanjutnya->user->nama,
                    'status' => 'dipanggil'
                ],
                'audio_sequence' => $audioResult['audio_sequence']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cekStatusAntrianSebelumnya(Request $request)
    {
        try {
            $request->validate([
                'poli_name' => 'required|string'
            ]);

            $poliName = $request->input('poli_name');

            // Cari antrian yang sedang dipanggil (status 'dipanggil') untuk poli tertentu
            $antrianSedangDipanggil = Antrian::whereHas('poli', function($query) use ($poliName) {
                    $query->where('nama_poli', $poliName);
                })
                ->where('status', 'dipanggil')
                ->whereDate('created_at', today())
                ->with(['user', 'poli']) // Pastikan relasi di-load
                ->first();

            if ($antrianSedangDipanggil) {
                return response()->json([
                    'success' => true,
                    'ada_antrian_sebelumnya' => true,
                    'antrian' => [
                        'id' => $antrianSedangDipanggil->id,
                        'no_antrian' => $antrianSedangDipanggil->no_antrian,
                        'user_name' => $antrianSedangDipanggil->user->nama,
                        'poli_name' => $poliName,
                        'waktu_panggil' => $antrianSedangDipanggil->waktu_panggil ? $antrianSedangDipanggil->waktu_panggil->format('H:i:s') : null
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'ada_antrian_sebelumnya' => false
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in cekStatusAntrianSebelumnya: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
