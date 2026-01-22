<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .box { border: 1px solid #ddd; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
        .header { background: #2563eb; color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h2>Pendaftaran Berhasil! 🎉</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $registration->user->name }}</strong>!</p>
            <p>Terima kasih telah mendaftar di event kami. Berikut detail tiket Anda:</p>
            
            <table style="width:100%; text-align: left;">
                <tr>
                    <th>Event:</th>
                    <td>{{ $registration->event->title }}</td>
                </tr>
                <tr>
                    <th>Waktu:</th>
                    <td>{{ \Carbon\Carbon::parse($registration->event->event_date)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Kode Tiket:</th>
                    <td><strong style="font-size:18px; color: #2563eb;">{{ $registration->ticket_code }}</strong></td>
                </tr>
            </table>

            <p style="text-align: center; margin-top: 30px;">
                <a href="{{ route('dashboard') }}" class="btn">Lihat Tiket & QR Code</a>
            </p>
        </div>
        <div class="footer">
            <p>Simpan email ini sebagai bukti pendaftaran.</p>
        </div>
    </div>
</body>
</html>