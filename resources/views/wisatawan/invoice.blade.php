<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $pesanan->ID_Tiket }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 40px 0;
        }

        .invoice-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            overflow: hidden;
        }

        .invoice-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .invoice-content {
            padding: 24px;
            font-size: 12px;
        }

        .invoice-title {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }

        .invoice-location {
            font-size: 0.9em;
            color: #777;
            margin-top: 4px;
            margin-bottom: 16px;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        table.info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #555;
            width: 40%;
        }

        .value {
            color: #222;
        }

        .terms-section {
            border-top: 1px solid #eee;
            margin-top: 30px;
            padding-top: 16px;
            color: #555;
            font-size: 0.7em;
        }

        .terms-section h2 {
            font-size: 0.85em;
            color: #333;
            margin-bottom: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.75em;
            color: #aaa;
        }

        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
            text-decoration: none;
            text-align: center;
        }

        .download-btn:hover {
            background-color: #45a049;
        }

        @media print {
            .download-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-card">
        <div class="invoice-image">
            <img src="{{ asset('storage/images/destinasi/' . $pesanan->destinasi->gambar) }}" alt="Destinasi">
        </div>

        <div class="invoice-content">
            <h1 class="invoice-title">Tiket {{ $pesanan->destinasi->tujuan }}</h1>
            <div class="invoice-location">{{ $pesanan->destinasi->lokasi }}</div>

            <table class="info-table">
                <tr>
                    <td class="label">ID TRANSAKSI</td>
                    <td class="value">{{ $pesanan->ID_Tiket }}</td>
                </tr>
                <tr>
                    <td class="label">NAMA</td>
                    <td class="value">{{ $pesanan->wisatawan->Nama }}</td>
                </tr>
                <tr>
                    <td class="label">EMAIL</td>
                    <td class="value">{{ $pesanan->wisatawan->Email }}</td>
                </tr>
                <tr>
                    <td class="label">TANGGAL</td>
                    <td class="value">{{ \Carbon\Carbon::parse($pesanan->Tanggal_Transaksi)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">HARGA TIKET</td>
                    <td class="value">Rp {{ number_format($pesanan->destinasi->tiket->Harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">JUMLAH TIKET</td>
                    <td class="value">{{ $pesanan->Jumlah_Tiket }}</td>
                </tr>
                <tr>
                    <td class="label">TOTAL HARGA</td>
                    <td class="value">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="footer">
                Terima kasih telah melakukan transaksi dengan kami.
            </div>

            <div class="terms-section">
                <h2>Syarat dan Ketentuan</h2>
                <ol>
                    <li>Tiket yang sudah dibeli tidak dapat dikembalikan atau dibatalkan.</li>
                    <li>Tiket hanya berlaku pada tanggal yang tertera di tiket.</li>
                    <li>Kerusakan atau kehilangan tiket bukan tanggung jawab pihak penyelenggara.</li>
                </ol>
            </div>
        </div>
    </div>

    <button class="download-btn" onclick="window.print()">Download Tiket</button>
</body>
</html>
