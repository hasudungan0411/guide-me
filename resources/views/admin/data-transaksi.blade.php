@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Apps</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <!-- Statistik -->
            <div class="row stats-row">
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"> {{ $totalTransaksi }}
                                    <span class="stats-change stats-change-success">Transaksi</span>
                                </h5>
                                <p class="stats-text">Total transaksi saat ini</p>
                            </div>
                            <div class="stats-icon change-success">
                                <i class="material-icons">trending_up</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"> {{ $totalWisatawan }}
                                    <span class="stats-change stats-change-success"> Wisatawan </span>
                                </h5>
                                <p class="stats-text">Total wisatawan yang terdaftar</p>
                            </div>
                            <div class="stats-icon change-success">
                                <i class="material-icons">trending_up</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"> {{ $totalPemilik }}
                                    <span class="stats-change stats-change-success"> Pemilik Wisata </span>
                                </h5>
                                <p class="stats-text">Total pemilik wisata yang terdaftar</p>
                            </div>
                            <div class="stats-icon change-success">
                                <i class="material-icons">trending_up</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.transaksi') }}">
                                <div class="form-group">
                                    <label for="pemilik_wisata">Pilih Wisata</label>
                                    <select id="pemilik_wisata" name="pemilik_wisata" class="form-control">
                                        <option value="">Pilih Wisata</option>
                                        @foreach ($pemilikWisata as $pemilik)
                                            <option value="{{ $pemilik->ID_Pemilik_Wisata }}"
                                                {{ request('pemilik_wisata') == $pemilik->ID_Pemilik_Wisata ? 'selected' : '' }}>
                                                {{ $pemilik->Nama_Wisata }} ({{ $pemilik->Email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Tampilkan Transaksi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="row stats-row">
                <!-- Statistik Card tetap sama -->
            </div>

            <!-- Tabel Transaksi -->
            @if ($transaksi->isNotEmpty())
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero-conf" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>ID Tiket</th>
                                                <th>Nama Wisata</th>
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
                                                    <td>{{ $tiket->destinasi->tujuan ?? 'N/A' }}</td>
                                                    <td>{{ $tiket->wisatawan->Email }}</td>
                                                    <td
                                                        class="
                                                    @if ($tiket->Status === 'Paid') text-success
                                                    @elseif($tiket->Status === 'Sudah Digunakan') text-primary
                                                    @elseif($tiket->Status === 'Unpaid') text-warning
                                                    @elseif($tiket->Status === 'Batal' || $tiket->Status === 'Hangus') text-danger @endif
                                                ">
                                                        {{ $tiket->Status }}
                                                    </td>
                                                    <td>{{ number_format($tiket->total_harga, 0, ',', '.') }}</td>
                                                    <td>{{ $tiket->Jumlah_Tiket }}</td>
                                                    <td>{{ $tiket->Tanggal_Transaksi }}</td>
                                                    <td>
                                                        @if ($tiket->Bukti_Transaksi)
                                                            <a class="btn btn-success" href="#" data-toggle="modal"
                                                                data-target="#ModalBukti{{ $tiket->ID_Transaksi }}">Lihat</a>
                                                        @else
                                                            <button class="btn btn-secondary" disabled>Tidak Ada</button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group dropleft">
                                                            <button type="button" class="btn btn-secondary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                Aksi
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                                    data-target="#ModalPembayaran{{ $tiket->ID_Transaksi }}">Konfirmasi
                                                                    Pembayaran</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                                    data-target="#ModalGunakan{{ $tiket->ID_Transaksi }}">Konfirmasi
                                                                    Penggunaan</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                                    data-target="#ModalHapus{{ $tiket->ID_Transaksi }}">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p>Tidak ada transaksi yang tersedia untuk wisata yang dipilih.</p>
            @endif
        </div>
    </div>
@endsection
