<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket</title>
    <style>
        body { 
            font-family: sans-serif; 
            text-align: center; 
            border: 2px dashed #2d3748; 
            padding: 20px; 
        }
        .header h1 { margin-bottom: 5px; color: #2d3748; }
        .header h3 { margin-top: 0; color: #718096; font-weight: normal; }
        
        /* KOTAK KODE TIKET */
        .ticket-code {
            font-size: 18px;
            font-weight: bold;
            color: #2b6cb0;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        /* AREA QR CODE */
        .qr-area {
            margin: 20px auto;
            width: 150px;
            height: 150px;
        }
        /* Style agar QR Code svg posisinya pas di tengah */
        .qr-area svg {
            width: 100%;
            height: 100%;
        }

        .info { text-align: left; margin: 20px auto; width: 80%; font-size: 14px; }
        .info td { padding: 5px; border-bottom: 1px solid #eee; }
        
        .footer { margin-top: 30px; font-size: 10px; color: gray; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TIKET EVENT KAMPUS</h1>
        <h3>{{ $registration->event->title }}</h3>
    </div>
    
    <hr>

    <div style="margin-top: 20px;">NOMOR TIKET:</div>
    <div class="ticket-code">{{ $kodeTiket }}</div>

    <div class="qr-area">
        <img src="data:image/svg+xml;base64,{{ $qrcode }}" alt="QR Code" width="150" height="150">
    </div>

    <div class="info">
        <table width="100%" cellspacing="0">
            <tr>
                <td width="35%"><strong>Nama Peserta</strong></td>
                <td>: {{ strtoupper($registration->user->name) }}</td>
            </tr>
            <tr>
                <td><strong>Fakultas</strong></td>
                <td>: {{ optional($registration->user->biodata)->fakultas ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: {{ \Carbon\Carbon::parse($registration->event->date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Lokasi</strong></td>
                <td>: {{ $registration->event->location }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Scan QR Code ini di meja registrasi untuk Check-In.<br>
        Tiket ini sah dan dikeluarkan secara otomatis.
    </div>
</body>
</html>