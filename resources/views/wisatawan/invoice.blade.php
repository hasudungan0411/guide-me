<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $pesanan->ID_Tiket }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $pesanan->ID_Tiket }}</h1>

    <p><strong>Nama Wisatawan:</strong> {{ $pesanan->wisatawan->Nama }}</p>
    <p><strong>Email Wisatawan:</strong> {{ $pesanan->wisatawan->Email }}</p>
    <p><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($pesanan->Tanggal_Transaksi)->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pesanan #{{ $pesanan->ID_Tiket }}</td>
                <td>{{ $pesanan->Jumlah_Tiket }}</td>
                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Total: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h3>
</body>
</html>
