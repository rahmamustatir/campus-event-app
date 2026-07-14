<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat img { width: 80px; float: left; }
        .kop-surat h2 { margin: 0; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/Logo UNU.png') }}">
        <h2>UNIVERSITAS NAHDLATUL ULAMA LAMPUNG</h2>
        <h3 style="margin: 5px 0;">LAPORAN KEGIATAN EVENT BULAN {{ strtoupper($bulan) }}</h3>
        <p>Jl. Raya Lintas Pantai Timur Sumatera Kec. Purbolinggo Lampung Timur | Telp. 0725-763180, Fax.</p>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr style="background: #f2f2f2;">
            <th>No</th><th>Nama Event</th><th>Tanggal</th><th>Lokasi</th>
        </tr>
        @foreach($events as $i => $e)
        <tr>
            <td style="text-align: center;">{{ $i+1 }}</td>
            <td>{{ $e->title }}</td>
            <td>{{ \Carbon\Carbon::parse($e->date)->format('d-m-Y') }}</td>
            <td>{{ $e->location }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>