@extends('layouts.admin')

@section('title', 'Kelola Akun Wisatawan')

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
                                    <span class="stats-change stats-change-success">Akun Wisatawan</span>
                                </h5>
                                <p class="stats-text">Total Akun Wisatawan saat ini</p>
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
                            <a href="{{ route('akun_wisatawan.create') }}" class="btn btn-primary mb-3">Tambah Wisatawan</a>
                            <table id="zero-conf" class="display" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $index => $wisatawan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $wisatawan->Nama }}</td>
                                            <td><span class="badge"
                                                    style="background-color: {!! generateColorFromText($wisatawan->Email) !!}; color: #fff;">
                                                    {{ $wisatawan->Email }}
                                                </span></td>
                                            <td>{{ $wisatawan->Nomor_HP }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modalHapus{{ $wisatawan->ID_Wisatawan }}">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="modalHapus{{ $wisatawan->ID_Wisatawan }}" tabindex="-1"
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
                                                        Yakin ingin menghapus akun <strong>{{ $wisatawan->Nama }}</strong>?
                                                        Aksi ini tidak bisa dibatalkan.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form
                                                            action="{{ route('akun_wisatawan.destroy', $wisatawan->ID_Wisatawan) }}"
                                                            method="POST">
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
                                            <td colspan="6" class="text-center">Tidak ada data wisatawan.</td>
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
