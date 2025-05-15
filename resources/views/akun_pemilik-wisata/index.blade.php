@extends('layouts.admin')

@section('title', 'Kelola Akun Pemilik Wisata')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">MeGuide</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

        <div class="main-wrapper">
            <div class="row stats-row">
                <div class="col-lg-4 col-md-12">
                    <div class="card card-transparent stats-card">
                        <div class="card-body">
                            <div class="stats-info">
                                <h5 class="card-title"> {{ $data->count() }}
                                    <span class="stats-change stats-change-success">Akun Pemilik</span>
                                </h5>
                                <p class="stats-text">Total Akun Pemilik Wisata saat ini</p>
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
                            <a href="{{ route('akun_pemilik-wisata.create') }}" class="btn btn-primary mb-3">Tambah Pemilik Wisata</a>
                            <table id="zero-conf" class="display" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nomor HP</th>
                                        <th>Nama Wisata</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $index => $pemilik)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge"
                                                    style="background-color: {!! generateColorFromText($pemilik->Email) !!}; color: #fff;">
                                                    {{ $pemilik->Email }}
                                                </span>
                                            </td>
                                            <td>{{ $pemilik->Nomor_HP }}</td>
                                            <td>{{ $pemilik->Nama_Wisata }}</td>
                                            <td>{{ $pemilik->Lokasi }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modalHapus{{ $pemilik->ID_Pemilik_Wisata }}">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="modalHapus{{ $pemilik->ID_Pemilik_Wisata }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin ingin menghapus akun dengan email
                                                        <strong>{{ $pemilik->Email }}</strong>? Aksi ini tidak bisa dibatalkan.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('akun_pemilik-wisata.destroy', $pemilik->ID_Pemilik_Wisata) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data pemilik wisata.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
