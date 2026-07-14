<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Times New Roman', serif; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat img { width: 80px; float: left; }
        .kop-surat h2 { margin: 0; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/Logo UNU.png') }}">
        <h2>UNIVERSITAS NAHDLATUL ULAMA LAMPUNG</h2>
        <p>Jl. Raya Lintas Pantai Timur Sumatera Kec. Purbolinggo Lampung Timur | Telp. 0725-763180, Fax.</p>
    </div>
    <h3>Laporan Pelaksanaan Event: {{ $event->title }}</h3>
    </body>
</html>