@extends('layouts.admin')

@section('title', 'Halaman Blog')

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
                        <a href="{{ route('blog.create') }}" class="btn btn-primary mb-3">Tambah Blog</a>
                        <table id="zero-conf" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi Pendek</th>
                                    <th>Deskripsi Panjang</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $blog->judul }}</td>
                                        <td><span class="badge" style="background-color: {!! generateColorFromText($blog->kategori->nama_kategori) !!}; color: #fff;">
                                            {{ $blog->kategori->nama_kategori }}
                                        </span></td>
                                        <td>
                                            <button class="btn btn-sm btn-success" tabindex="0" data-toggle="popover"
                                                data-trigger="focus" title="Deskripsi Pendek"
                                                data-content="{{ strip_tags($blog->short_desk) }}">Lihat</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" tabindex="0" data-toggle="popover"
                                                data-trigger="focus" title="Deskripsi Panjang"
                                                data-content="{{ strip_tags($blog->deskripsi) }}">Lihat</button>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($blog->tanggal)->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group dropleft">
                                                <button type="button" class="btn btn-secondary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('blog.show', $blog->slug) }}">Detail</a>
                                                    <a class="dropdown-item" href="{{ route('blog.edit', $blog->id_blog) }}">Ubah</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#modalHapus{{ $blog->id_blog }}">Hapus</a>
                                                </div>
                                            </div>

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade" id="modalHapus{{ $blog->id_blog }}" tabindex="-1"
                                                role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin mau dihapus? Data akan hilang permanen.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <form action="{{ route('blog.destroy', $blog->id_blog) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus!</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </td>
                                    </tr>
                                @endforeach
                                @if($blogs->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data blog.</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi Pendek</th>
                                    <th>Deskripsi Panjang</th>
                                    <th>Tanggal</th>
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
