@extends('layouts.wisatawan')

@section('title', 'Detail Tiket')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/images/destinasi/' . $destinasi->gambar) }}" class="img-fluid rounded" alt="{{ $destinasi->tujuan }}">
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $destinasi->tujuan }}</h3>

                        <p><strong>ID Tiket:</strong> {{ $tiket->ID_Tiket }}</p>
                        <p><strong>Jumlah Tiket:</strong> {{ $tiket->Jumlah_Tiket }}</p>
                        <p><strong>Harga Tiket:</strong> Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</p>
                        <p><strong>Tanggal Pesanan:</strong> {{ \Carbon\Carbon::parse($tiket->Tanggal_Transaksi)->format('d F Y') }}</p>
                        <p><strong>Status Tiket:</strong> <span class="
                                        btn
                                            @if($tiket->Status === 'Paid') btn-success 
                                            @elseif($tiket->Status === 'Sudah Digunakan') btn-primary 
                                            @elseif($tiket->Status === 'Unpaid') btn-warning 
                                            @elseif($tiket->Status === 'Batal' || $item->Status === 'Hangus') btn-danger 
                                            @endif
                                    ">
                                        {{ $tiket->Status }}</span>                                
                        </p>
                        <p><strong>Bukti Pembayaran:</strong> {{ $tiket->Bukti_Transaksi }} <br>
                        @if ($tiket->Bukti_Transaksi)
                            <img src="{{ asset('bukti/' . $tiket->Bukti_Transaksi) }}" alt="Bukti Pembayaran" width="300">
                        @elseif ($tiket->Status !== 'Batal')
                            <form action="{{ route('upload.bukti', $tiket->ID_Transaksi) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="bukti_transaksi" accept="image/*" required>
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </form>
                        @endif
                    </div>
                </div>
                <hr>
                <a href="{{ route('wisatawan.pesanan') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
                @if ($tiket->Status === 'Unpaid' && !$tiket->Bukti_Transaksi)
                    <form action="{{ route('wisatawan.tiket-batal', $tiket->ID_Transaksi) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Batalkan</button>
                    </form>
                @endif
                @if ($tiket->Status === 'Unpaid' && !$tiket->Bukti_Transaksi)
                    <button class="btn btn-success" data-bs-toggle="modal"data-bs-target="#bayarModal">Bayar Sekarang</button>  
                @endif
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bayarModal" tabindex="-1"
        aria-labelledby="bayarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarModalLabel">
                        Silakan lakukan pembayaran melalui transfer bank atau dengan memindai QRIS berikut ini.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Transfer Bank : </strong>{{ $pemilik->Nomor_Rekening }}</p>
                    <p><strong>Qris : </strong></p>
                    <img src="{{ asset('gambar_qris/' . $pemilik->Qris) }}" alt="{{ $pemilik->Qris }}" style="max-width:400px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection