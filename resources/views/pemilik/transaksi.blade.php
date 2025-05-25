@extends('layouts.pemilik')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pemilik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Acara</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row stats-row">
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"><span class="stats-change stats-change-success"> Pembelian
                                        Tiket</span></h5>
                                <p class="stats-text">Total Pembelian Tiket</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"><span class="stats-change stats-change-success"> Pembelian
                                        Pendapatan</span></h5>
                                <p class="stats-text">Total Pemasukan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table id="zero-conf" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID Tiket</th>
                                    <th>Pemesan</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th>Jumlah Tiket</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Bukti Transaksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($transaksi as $tiket)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $tiket->ID_Tiket }}</td>
                                    <td>{{ $tiket->wisatawan->Email }}</td>
                                    <td class="
                                            @if($tiket->Status === 'Paid') text-success 
                                            @elseif($tiket->Status === 'Sudah Digunakan') text-primary 
                                            @elseif($tiket->Status === 'Unpaid') text-warning 
                                            @elseif($tiket->Status === 'Batal' || $tiket->Status === 'Hangus') text-danger 
                                            @endif
                                    ">
                                        {{ $tiket->Status }}

                                    </td>
                                    <td>{{ number_format($tiket->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ $tiket->Jumlah_Tiket }}</td>
                                    <td>{{ $tiket->Tanggal_Transaksi }}</td>
                                    <td><a class="btn btn-success" href="#" data-toggle="modal" data-target="#ModalBukti{{ $tiket->ID_Transaksi }}">Lihat</a></td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalPembayaran{{ $tiket->ID_Transaksi }}">Konfirmasi Pembayaran</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalGunakan{{ $tiket->ID_Transaksi }}">Konfirmasi Penggunaan</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalHapus{{ $tiket->ID_Transaksi }}">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="ModalHapus{{ $tiket->ID_Transaksi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin mau menghapus pesanan ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Gak jadi deh</button>
                                                <form action="{{ route('tiket.hapus', $tiket->ID_Transaksi) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Konfirmasi -->
                                <div class="modal fade" id="ModalPembayaran{{ $tiket->ID_Transaksi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Pembayaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin mengkonfirmasi pembayaran tiket ini? <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('tiket.konfirmasi', $tiket->ID_Transaksi) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Penggunaan -->
                                <div class="modal fade" id="ModalGunakan{{ $tiket->ID_Transaksi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Penggunaan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin mengkonfirmasi penggunaan tiket ini? <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('tiket.gunakan', $tiket->ID_Transaksi) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Gunakan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Bukti -->
                                <div class="modal fade" id="ModalBukti{{ $tiket->ID_Transaksi }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Bukti Pembayaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="" alt="Bukti Pembayaran">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
