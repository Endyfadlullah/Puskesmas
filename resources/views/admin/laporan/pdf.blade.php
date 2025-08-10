<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Antrian Puskesmas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .status-menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-sedang {
            background-color: #e9d5ff;
            color: #7c3aed;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-batal {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }

        .summary p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN ANTRIAN PUSKESMAS</h1>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
        <p>Total Data: {{ $antrian->count() }} antrian</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Antrian</th>
                <th>Nama Pasien</th>
                <th>No KTP</th>
                <th>Poli</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Waktu Daftar</th>
                <th>Waktu Panggil</th>
            </tr>
        </thead>
        <tbody>
            @forelse($antrian as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->no_antrian }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->user->no_ktp }}</td>
                    <td>{{ $item->poli->nama_poli }}</td>
                    <td class="status-{{ $item->status }}">
                        {{ ucfirst($item->status) }}
                    </td>
                    <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('H:i') : '-' }}</td>
                    <td>{{ $item->waktu_panggil ? $item->waktu_panggil->format('H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data antrian</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Statistik:</h3>
        <p><strong>Total Antrian:</strong> {{ $totalAntrian }}</p>
        <p><strong>Menunggu:</strong> {{ $antrianMenunggu }}</p>
        <p><strong>Dipanggil:</strong> {{ $antrianDipanggil }}</p>
        <p><strong>Sedang:</strong> {{ $antrianSedang }}</p>
        <p><strong>Selesai:</strong> {{ $antrianSelesai }}</p>
        <p><strong>Batal:</strong> {{ $antrian->where('status', 'batal')->count() }}</p>
    </div>
</body>

</html>
