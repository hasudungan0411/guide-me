@extends('layouts.admin')

@section('title', 'Daftar Destinasi')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Apps</a></li>
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
                            <h5 class="card-title"> {{ $totalBlog }}
                                <span class="stats-change stats-change-success">Blog</span>
                            </h5>
                            <p class="stats-text">Total blog saat ini</p>
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
                            <h5 class="card-title"> {{ $totalDestinasi }}
                                <span class="stats-change stats-change-success"> Destinasi </span>
                            </h5>
                            <p class="stats-text">Total destinasi saat ini</p>
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
                            <h5 class="card-title"> {{ $totalGambar }}
                                <span class="stats-change stats-change-success"> Gambar </span>
                            </h5>
                            <p class="stats-text">Total gambar saat ini</p>
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
                        <a href="{{ route('destinasi.create') }}" class="btn btn-primary mb-3">Tambah Destinasi</a>
                        <table id="zero-conf" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tujuan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($destinations as $destination)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $destination->tujuan }}</td>
                                    <td>{{ $destination->latitude }}</td>
                                    <td>{{ $destination->longitude }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {!! generateColorFromText($destination->kategori->nama_kategori) !!}; color: #fff;">
                                            {{ $destination->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('destinasi.show', $destination->id) }}">Detail</a>
                                                <a class="dropdown-item" href="{{ route('destinasi.edit', $destination->id) }}">Ubah</a>
                                                <div class="dropdown-divider"></div>
                                                <!-- Modal untuk konfirmasi hapus -->
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalCenter{{ $destination->id }}">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="exampleModalCenter{{ $destination->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin mau menghapus destinasi ini? 😁 <br>
                                                Datanya bakal hilang loh.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Gak jadi deh</button>
                                                <form action="{{ route('destinasi.destroy', $destination->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Biarin, hapus aja !!</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Tujuan</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
