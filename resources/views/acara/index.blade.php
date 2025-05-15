@extends('layouts.pemilik')

@section('title', 'Halaman Acara')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">MeGuide</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Acara</li>
                </ol>
            </nav>
        </div>

        <div class="main-wrapper">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('acara.create') }}" class="btn btn-primary mb-3">Tambah Acara</a>
                            <table id="zero-conf" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Acara</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($acara as $Acara)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $Acara->Nama_acara }}</td>
                                            <td>{{ \Carbon\Carbon::parse($Acara->Tanggal_acara)->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success" tabindex="0" data-toggle="popover"
                                                    data-trigger="focus" title="Deskripsi"
                                                    data-content="{{ strip_tags($Acara->Deskripsi) }}">Lihat</button>
                                            </td>
                                            <td>
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('acara.edit', $Acara->ID_Acara) }}">Ubah</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modalHapus{{ $Acara->ID_Acara }}">Hapus</a>
                                                    </div>
                                                </div>

                                                <!-- Modal Konfirmasi Hapus -->
                                                <div class="modal fade" id="modalHapus{{ $Acara->ID_Acara }}" tabindex="-1"
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
                                                                Yakin ingin menghapus acara ini? Data akan hilang secara permanen.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Batal</button>
                                                                <form
                                                                    action="{{ route('acara.destroy', $Acara->ID_Acara) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus!</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($acara->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data acara.</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Acara</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
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

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
@endpush
