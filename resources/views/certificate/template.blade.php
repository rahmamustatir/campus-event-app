<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Penghargaan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .border-pattern {
            position: absolute;
            top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 5px solid #1e3a8a; /* Warna Biru Tua */
            padding: 20px;
        }
        .inner-border {
            border: 2px solid #d4af37; /* Warna Emas */
            height: 94%;
            padding: 20px;
            position: relative;
        }
        .header {
            margin-top: 30px;
        }
        h1 {
            font-size: 40px;
            text-transform: uppercase;
            color: #1e3a8a;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }
        .content {
            margin-top: 20px;
        }
        .recipient-name {
            font-size: 32px;
            font-weight: bold;
            color: #000;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 10px;
            margin: 20px 0;
        }
        .event-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 15px 0;
        }
        .text {
            font-size: 16px;
            color: #444;
            line-height: 1.6;
        }
        .footer {
            margin-top: 60px;
            display: table;
            width: 100%;
        }
        .signature-col {
            display: table-cell;
            width: 50%;
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-bottom: 1px solid #000;
            margin: 50px auto 10px auto;
        }
        .scan-code {
            position: absolute;
            bottom: 40px;
            right: 40px;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="border-pattern">
        <div class="inner-border">
            
            <div class="header">
                <h1>SERTIFIKAT PENGHARGAAN</h1>
                <div class="subtitle">Nomor: CERT/{{ $code }}/{{ date('Y') }}</div>
            </div>

            <div class="content">
                <p class="text">Diberikan dengan bangga kepada:</p>
                
                <div class="recipient-name">
                    {{ strtoupper($user->name) }}
                </div>
                
                <p class="text">Atas partisipasinya sebagai <strong>PESERTA</strong> dalam acara:</p>
                
                <div class="event-name">
                    "{{ $event->title }}"
                </div>

                <p class="text">
                    Yang diselenggarakan pada tanggal {{ $date }}<br>
                    Bertempat di {{ $event->location }}.
                </p>
            </div>

            <div class="footer">
                <div class="signature-col">
                    <div class="signature-line"></div>
                    <strong>Prof. Dr. H. Iwan Gunawan, M.Kom.</strong><br>
                    <span style="font-size: 12px; color: #666;">Rektor Universitas</span>
                </div>
                
                <div class="signature-col">
                    <div class="signature-line"></div>
                    <strong>Muhammad Dimas, S.T.</strong><br>
                    <span style="font-size: 12px; color: #666;">Ketua Pelaksana</span>
                </div>
            </div>
            </div>

            <div class="scan-code">
                ID Tiket: {{ $code }} <br>
                Dicetak: {{ date('d-m-Y H:i') }}
            </div>

        </div>
    </div>
</body>
</html>