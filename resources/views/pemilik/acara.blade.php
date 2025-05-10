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
        
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <a href="{{ route('acara.create') }}" class="btn btn-primary mb-3">Tambah Acara</a>
                        <table id="zero-conf" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Acara</th>
                                    <th>Tanggal Acara</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($Acara as $acara)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $acara->Nama_acara }}</td>
                                    <td>{{ $acara->Tanggal_acara }}</td>
                                    <td>{{ $acara->Deskripsi }}</td>
                                    <td>
                                        <a href="/edit/{{ $acara->ID_Acara }}">Edit</a> |
                                        <a href="/delete/{{ $acara->ID_Acara }}" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
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
</div>
@endsection
