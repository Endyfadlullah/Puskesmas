<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor Antrian - {{ $antrian->no_antrian }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .ticket {
            background: white;
            border: 2px solid #333;
            border-radius: 10px;
            padding: 30px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .hospital-subtitle {
            font-size: 14px;
            color: #666;
        }

        .queue-number {
            text-align: center;
            margin: 30px 0;
        }

        .number {
            font-size: 48px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }

        .queue-label {
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }

        .patient-info {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .date-time {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 10px;
        }

        @media print {
            body {
                background-color: white;
            }

            .ticket {
                box-shadow: none;
                border: 1px solid #333;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            <div class="hospital-name">🏥 PUSKESMAS</div>
            <div class="hospital-subtitle">Sistem Antrian Digital</div>
        </div>

        <div class="queue-number">
            <div class="number">{{ $antrian->no_antrian }}</div>
            <div class="queue-label">NOMOR ANTRIAN</div>
        </div>

        <div class="patient-info">
            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $antrian->user->nama }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Poli:</span>
                <span class="info-value">{{ $antrian->poli->nama_poli }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst($antrian->status) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span class="info-value">{{ $antrian->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Waktu:</span>
                <span class="info-value">{{ $antrian->created_at->format('H:i') }}</span>
            </div>
        </div>

        <div class="footer">
            <div>Terima kasih telah menggunakan layanan kami</div>
            <div>Mohon menunggu panggilan di layar display</div>
        </div>

        <div class="date-time">
            Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
