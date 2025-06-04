@extends('layouts.admin')

@section('title', 'Daftar Kategori')

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
            <!-- FOR TABLE -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
                            <div class="table-responsive">
                                <table id="zero-conf" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kategori</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: {!! generateColorFromText($category->nama_kategori) !!}; color: #fff;">
                                                        {{ $category->nama_kategori }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <img style="width:80px; height: 80px;"
                                                        src="{{ asset('storage/images/kategori/' . $category->gambar) }}"
                                                        class="card-img" alt="Gambar {{ $category->gambar }}">
                                                </td>
                                                <td>
                                                    <div class="btn-group dropleft">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('kategori.show', $category->id_kategori) }}">Detail</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('kategori.edit', $category->id_kategori) }}">Ubah</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#exampleModalCenter{{ $category->id_kategori }}">Hapus</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="exampleModalCenter{{ $category->id_kategori }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi
                                                                Hapus</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin mau di hapus nih ? 😁 <br>
                                                            Datanya bakal hilang loh.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Gak jadi deh</button>
                                                            <form
                                                                action="{{ route('kategori.destroy', $category->id_kategori) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Biarin, hapus
                                                                    aja !!</button>
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
                                            <th>Kategori</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TABLE -->
        </div>
    </div>
@endsection
