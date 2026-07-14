<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat img { width: 80px; float: left; }
        .kop-surat h2, .kop-surat h3 { margin: 0; padding: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/Logo UNU.png') }}" alt="Logo UNU">
        <h2>UNIVERSITAS NAHDLATUL ULAMA LAMPUNG</h2>
        <h3>LAPORAN PELAKSANAAN EVENT: {{ strtoupper($event->title) }}</h3>
        <p>Jl. Lintas Sumatera, Bandar Lampung | Telp: (0721) xxxxx</p>
    </div>

    <p>Berikut adalah daftar kehadiran peserta untuk event <b>{{ $event->title }}</b>:</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Prodi</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->registrations as $index => $reg)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $reg->user->name }}</td>
                <td>{{ $reg->user->nim ?? '-' }}</td>
                <td>{{ $reg->user->prodi ?? '-' }}</td>
                <td style="height: 40px;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>