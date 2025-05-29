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
        }

        .invoice-title {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .invoice-location {
            font-size: 0.95em;
            color: #777;
            margin-top: 4px;
            margin-bottom: 16px;
        }

        .section {
            border-top: 1px solid #eee;
            margin-top: 20px;
            padding-top: 16px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .info-block {
            margin-bottom: 12px;
        }

        .label {
            font-weight: 600;
            font-size: 0.85em;
            color: #555;
            margin-bottom: 2px;
        }

        .value {
            font-size: 1em;
            color: #222;
        }

        .terms-section {
            border-top: 1px solid #eee;
            margin-top: 30px;
            padding-top: 16px;
            color: #555;
            font-size: 0.75em; /* lebih kecil dari sebelumnya */
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .terms-section h2 {
            font-size: 0.85em; /* judul juga kecil */
            color: #333;
            margin-bottom: 12px;
        }

        .terms-section ol {
            padding-left: 20px;
            margin: 0;
        }

        .terms-section li {
            margin-bottom: 6px;
        }


        /* Tambahan footer invoice */
        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.8em;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="invoice-card">
        <!-- Foto destinasi -->
        <div class="invoice-image">
            <img src="{{ asset('storage/images/destinasi/' . $pesanan->destinasi->gambar) }}" alt="Destinasi">
        </div>

        <div class="invoice-content">
            <h1 class="invoice-title">Tiket {{ $pesanan->destinasi->tujuan }}</h1>
            <div class="invoice-location">{{ $pesanan->destinasi->lokasi }}</div>

            <div class="section">
                <div class="info-block">
                    <div class="label">ID TRANSAKSI</div>
                    <div class="value">{{ $pesanan->ID_Tiket }}</div>
                </div>
                <div class="info-block">
                    <div class="label">NAMA</div>
                    <div class="value">{{ $pesanan->wisatawan->Nama }}</div>
                </div>
                <div class="info-block">
                    <div class="label">EMAIL</div>
                    <div class="value">{{ $pesanan->wisatawan->Email }}</div>
                </div>
                <div class="info-block">
                    <div class="label">TANGGAL</div>
                    <div class="value">{{ \Carbon\Carbon::parse($pesanan->Tanggal_Transaksi)->format('d M Y') }}</div>
                </div>
                <div class="info-block">
                    <div class="label">HARGA TIKET</div>
                    <div class="value">Rp {{ number_format($pesanan->destinasi->tiket->Harga, 0, ',', '.') }}</div>
                </div>
                <div class="info-block">
                    <div class="label">JUMLAH TIKET</div>
                    <div class="value">{{ $pesanan->Jumlah_Tiket }}</div>
                </div>
                <div class="info-block">
                    <div class="label">TOTAL HARGA</div>
                    <div class="value">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                </div>
            </div>

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
</body>
</html>
