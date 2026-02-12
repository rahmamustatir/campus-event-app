<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Penghargaan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            text-align: center;
            border: 10px solid #2d3748; /* Bingkai Luar */
            padding: 40px;
            height: 90%; /* Agar bingkai penuh di A4 Landscape */
        }
        .inner-border {
            border: 2px solid #cbd5e0; /* Bingkai Tipis Dalam */
            padding: 30px;
            height: 85%;
        }
        h1 {
            font-size: 48px;
            color: #2b6cb0;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 5px;
        }
        h3 {
            font-size: 24px;
            color: #4a5568;
            margin-top: 0;
            font-weight: normal;
        }
        .recipient {
            font-size: 36px;
            font-weight: bold;
            color: #1a202c;
            border-bottom: 2px solid #718096;
            display: inline-block;
            padding: 0 50px 10px 50px;
            margin: 20px 0;
        }
        .event-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c5282;
            margin: 20px 0;
        }
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: center;
        }
        .signature {
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            padding-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="inner-border">
        <br>
        <h3>SERTIFIKAT PENGHARGAAN</h3>
        <p>Diberikan kepada:</p>

        <div class="recipient">{{ strtoupper($registration->user->name) }}</div>

        <p>Atas partisipasinya sebagai <strong>PESERTA</strong> dalam acara:</p>

        <div class="event-name">{{ $registration->event->title }}</div>

        <p>Diselenggarakan pada tanggal {{ \Carbon\Carbon::parse($registration->event->date)->isoFormat('D MMMM Y') }}</p>
        <p>Bertempat di {{ $registration->event->location }}</p>

        <div class="footer">
            <br><br>
            <div class="signature">
                Panitia Pelaksana
            </div>
        </div>
    </div>
</body>
</html>