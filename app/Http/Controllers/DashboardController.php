<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
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
        $request->validate([
            'poli_id' => 'required|exists:polis,id'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            // Check if user already has a queue today for the same poli
            $existingQueue = Antrian::where('user_id', $user->id)
                ->where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->first();

            if ($existingQueue) {
                // Get poli name for error message
                $poliName = Poli::find($request->poli_id)->nama_poli;
                return redirect()->back()->with('error', 'Anda sudah memiliki antrian di ' . $poliName . ' hari ini.');
            }

            // Get poli info for prefix
            $poli = Poli::find($request->poli_id);
            $prefix = $this->getPoliPrefix($poli->nama_poli);

            // Get next queue number for the poli
            $lastQueue = Antrian::where('poli_id', $request->poli_id)
                ->whereDate('created_at', today())
                ->max('no_antrian');

            // Extract number from last queue (remove prefix)
            $lastNumber = 0;
            if ($lastQueue) {
                $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastQueue);
            }

            $nextNumber = $lastNumber + 1;
            $nextQueueNumber = $prefix . $nextNumber;

            // Create new queue using current user's data
            $antrian = Antrian::create([
                'user_id' => $user->id,
                'poli_id' => $request->poli_id,
                'no_antrian' => $nextQueueNumber,
                'tanggal_antrian' => now()->toDateString(),
                'status' => 'menunggu'
            ]);

            DB::commit();

            // Get poli name for success message
            $poliName = $poli->nama_poli;
            return redirect()->back()->with('success', 'Antrian berhasil diambil! Nomor antrian Anda di ' . $poliName . ': ' . $nextQueueNumber);

        } catch (\Exception $e) {
            DB::rollback();
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
