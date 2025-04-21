@extends('layouts.admin')

@section('title', 'Daftar Galeri')

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
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table id="zero-conf" class="display" style="width:100%">
                                <a href="{{ route('galeri.create') }}" class="btn btn-primary m-b-md">Tambah Galeri</a>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galery as $galeri)
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td><a href="#" data-toggle="modal"
                                                    data-target="#modalGambar{{ $galeri->id }}"><img
                                                        style="width:80px; height: 80px;"
                                                        src="{{ asset('storage/images/galeri/' . $galeri->gambar) }}"
                                                        class="card-img" alt="gambar"></a></td>
                                            <td><a href="#" data-toggle="modal"
                                                    data-target="#modalHapus{{ $galeri->id }}"
                                                    class="btn btn-danger btn-sm ml-3"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>

                                        {{-- modal Gambar  --}}
                                        <div class="modal fade" id="modalGambar{{ $galeri->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="galeryview">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img style="width:100%; height: auto;"
                                                            src="{{ asset('storage/images/galeri/' . $galeri->gambar) }}"
                                                            class="card-img" alt="">
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="modalHapus{{ $galeri->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                        <form action="{{ route('galeri.destroy', $galeri->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Biarin, hapus aja
                                                                !!</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
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
    </div>
@endsection
