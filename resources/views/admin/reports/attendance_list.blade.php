<!DOCTYPE html>
<html>
<head>
    <title>Daftar Hadir Peserta</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .col-no { width: 5%; text-align: center; }
        .col-ttd { width: 25%; }
    </style>
</head>
<body>
    <div class="header">
        <h2>DAFTAR HADIR PESERTA</h2>
        <p><strong>Event:</strong> {{ $event->title }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->date)->isoFormat('D MMMM Y') }} | <strong>Lokasi:</strong> {{ $event->location }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Nama Peserta</th>
                <th>Fakultas / Instansi</th>
                <th>Status Tiket</th>
                <th class="col-ttd">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($event->registrations as $index => $reg)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td>
                    {{ strtoupper($reg->user->name) }}<br>
                    <small style="color: #666;">{{ $reg->user->email }}</small>
                </td>
                <td>
                    {{ optional($reg->user->biodata)->fakultas ?? '-' }}
                </td>
                <td style="text-align: center;">
                    {{ strtoupper($reg->payment_status) }}
                </td>
                <td>
                    </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada peserta yang mendaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>
</body>
</html>