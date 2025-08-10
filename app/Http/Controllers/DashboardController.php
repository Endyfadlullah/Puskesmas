<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        // Get user's own queues
        $antrianSaya = Antrian::with(['user', 'poli'])
            ->where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.index', compact('antrianSaya'));
    }

    public function addQueue(Request $request)
    {
        // Auto-batalkan antrian yang sudah dipanggil lebih dari 5 menit
        $this->autoBatalkanAntrianLama();

        $request->validate([
            'poli_id' => 'required|exists:polis,id'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $poli = Poli::find($request->poli_id);
            $poliName = $poli->nama_poli;

            // Check if user already has a queue today for the same poli
            $existingQueue = Antrian::where('user_id', $user->id)
                ->where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->first();

            if ($existingQueue) {
                // Check if request wants JSON response
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'type' => 'existing_queue',
                        'message' => 'Anda sudah memiliki antrian di ' . $poliName . ' hari ini.',
                        'existing_queue' => [
                            'id' => $existingQueue->id,
                            'no_antrian' => $existingQueue->no_antrian,
                            'status' => $existingQueue->status,
                            'created_at' => $existingQueue->created_at->format('H:i'),
                            'poli_name' => $poliName
                        ]
                    ]);
                }

                // Fallback to redirect for non-AJAX requests
                return redirect()->back()->with('error', 'Anda sudah memiliki antrian di ' . $poliName . ' hari ini.');
            }

            // Note: User CAN have multiple queues in different polis
            // We only prevent duplicate queues in the same poli (checked above)
            // Multi-queue cross-poli is allowed and encouraged

            // Get poli info for prefix
            $prefix = $this->getPoliPrefix($poli->nama_poli);

            // Get next queue number for the poli - perbaikan logika
            $lastQueue = Antrian::where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();

            // Extract number from last queue (remove prefix)
            $lastNumber = 0;
            if ($lastQueue && $lastQueue->no_antrian) {
                // Extract only the numeric part after the prefix
                $lastNumber = (int) preg_replace('/^[A-Z]+/', '', $lastQueue->no_antrian);

                // Debug log
                \Log::info("Last queue: {$lastQueue->no_antrian}, Extracted number: {$lastNumber}");
            }

            $nextNumber = $lastNumber + 1;
            $nextQueueNumber = $prefix . $nextNumber;

            // Debug log
            \Log::info("Generated next queue number: {$nextQueueNumber} for poli: {$poliName}");

            // Create new queue using current user's data
            $antrian = Antrian::create([
                'user_id' => $user->id,
                'poli_id' => $request->poli_id,
                'no_antrian' => $nextQueueNumber,
                'tanggal_antrian' => now()->toDateString(),
                'status' => 'menunggu'
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Antrian berhasil diambil! Nomor antrian Anda di ' . $poliName . ': ' . $nextQueueNumber,
                    'antrian' => [
                        'id' => $antrian->id,
                        'no_antrian' => $nextQueueNumber,
                        'poli_name' => $poliName,
                        'status' => 'menunggu'
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Antrian berhasil diambil! Nomor antrian Anda di ' . $poliName . ': ' . $nextQueueNumber);

        } catch (\Exception $e) {
            DB::rollback();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil antrian: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil antrian: ' . $e->getMessage());
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'no_ktp' => 'required|string|max:16',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100'
        ]);

        try {
            $user = Auth::user();

            // Check if KTP number is already used by another user
            $existingUser = User::where('no_ktp', $request->no_ktp)
                ->where('id', '!=', $user->id)
                ->first();

            if ($existingUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor KTP sudah digunakan oleh user lain.'
                ]);
            }

            $user->nama = $request->nama;
            $user->no_hp = $request->no_hp;
            $user->no_ktp = $request->no_ktp;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->alamat = $request->alamat;
            $user->pekerjaan = $request->pekerjaan;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Data diri berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ]);
        }
    }

    private function getPoliPrefix($namaPoli)
    {
        switch (strtolower($namaPoli)) {
            case 'umum':
                return 'U';
            case 'gigi':
                return 'G';
            case 'kesehatan jiwa':
                return 'J';
            case 'kesehatan tradisional':
                return 'T';
            default:
                return 'A'; // Default prefix
        }
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

            foreach ($antrianLama as $antrian) {
                // Update status menjadi 'batal'
                $antrian->update(['status' => 'batal']);

                // Log untuk tracking (optional)
                \Log::info("Antrian {$antrian->no_antrian} otomatis dibatalkan karena lewat 5 menit sejak dipanggil");
            }

            // Jika ada antrian yang dibatalkan, log jumlahnya
            if ($antrianLama->count() > 0) {
                \Log::info("Total {$antrianLama->count()} antrian otomatis dibatalkan karena timeout");
            }
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            \Log::error("Error saat auto-batalkan antrian: " . $e->getMessage());
        }
    }

    public function batalAntrian(Request $request)
    {
        try {
            $request->validate([
                'antrian_id' => 'required|exists:antrians,id'
            ]);

            $antrian = Antrian::findOrFail($request->antrian_id);

            // Check if the antrian belongs to the authenticated user
            if ($antrian->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk membatalkan antrian ini'
                ], 403);
            }

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
                'message' => 'Antrian ' . $antrian->no_antrian . ' berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cetakAntrian(Antrian $antrian)
    {
        try {
            // Check if the antrian belongs to the authenticated user
            if ($antrian->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk mencetak antrian ini');
            }

            // Check if antrian can be printed (only 'menunggu' status can be printed)
            if ($antrian->status !== 'menunggu') {
                abort(400, 'Antrian dengan status "' . ucfirst($antrian->status) . '" tidak dapat dicetak');
            }

            $antrian->load(['user', 'poli']);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.antrian.print', compact('antrian'));
            return $pdf->stream('antrian-' . $antrian->no_antrian . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
