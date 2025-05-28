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
                                            @elseif($tiket->Status === 'Pending') btn-warning 
                                            @elseif($tiket->Status === 'Batal' || $item->Status === 'Hangus') btn-danger 
                                            @endif
                                    ">
                                        {{ $tiket->Status }}</span>                                
                        </p>
                        <p><strong>Bukti Pembayaran:</strong> {{ $tiket->Bukti_Transaksi }} <br>
                            <img src="{{ asset('bukti/' . $tiket->Bukti_Transaksi) }}" alt="Bukti Pembayaran" width="300">
                    </div>
                </div>
                <hr>
                <a href="{{ route('wisatawan.pesanan') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
                @if($tiket->Status === 'Paid')
                    <a href="{{ route('wisatawan.invoice', $tiket->ID_Transaksi) }}" class="btn btn-primary">Cetak Invoice</a>
                @endif
            </div>

        </div>
    </div>
@endsection