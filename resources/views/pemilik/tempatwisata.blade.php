@extends('layouts.pemilik')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Apps</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tempat Wisa</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <table border="1" cellpadding="10" cellspacing="0">
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
                                <tr>
                                    <td>1</td>
                                    <td>{{ $destination->tujuan }}</td>
                                    <td>{{ $destination->latitude }}</td>
                                    <td>{{ $destination->longitude }}</td>
                                    <td>{{ $destination->kategori }}</td>
                                    <td>
                                        <a href="/edit/1">Edit</a> |
                                        <a href="/delete/1" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                    </td>
                                </tr>
                                <!-- Tambahkan baris lain di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
