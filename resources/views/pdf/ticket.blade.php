<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket</title>
    <style>
        body { font-family: sans-serif; text-align: center; color: #333; }
        .ticket-box {
            border: 2px dashed #444;
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            background-color: #f9f9f9;
        }
        .header { border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; }
        .h1 { color: #2563eb; margin: 0; text-transform: uppercase; }
        .info-table { width: 100%; margin-top: 20px; text-align: left; }
        .info-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .qr-area { margin-top: 30px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; }
        .status { background: #d1fae5; color: #065f46; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            <h1>E-TICKET</h1>
            <p>Campus Event System</p>
        </div>

        <h2>{{ $registration->event->title }}</h2>

        <table class="info-table">
            <tr>
                <th>Nama Peserta:</th>
                <td>{{ $registration->user->name }}</td>
            </tr>
            <tr>
                <th>Tanggal Acara:</th>
                <td>{{ \Carbon\Carbon::parse($registration->event->event_date)->translatedFormat('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <th>Lokasi:</th>
                <td>{{ $registration->event->location }}</td>
            </tr>
            <tr>
                <th>Kode Tiket:</th>
                <td><strong style="font-size: 16px;">{{ $registration->ticket_code }}</strong></td>
            </tr>
        </table>

        <div class="qr-area">
            <p>Scan QR Code ini di pintu masuk:</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $registration->ticket_code }}" width="150">
        </div>

        <div class="footer">
            <p>Simpan tiket ini dan tunjukkan kepada panitia.</p>
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>
</body>
</html>