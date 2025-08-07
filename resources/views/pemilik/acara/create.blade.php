@extends('layouts.pemilik')

@section('title', 'Tambah Acara')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pemilik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Acara</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('pemilik.acara.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Acara Baru</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('pemilik.acara.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="Nama_acara">Nama Acara</label>
                                        <input type="text" name="Nama_acara" id="Nama_acara" class="form-control"
                                            placeholder="Contoh: Festival Budaya Sekupang" value="{{ old('Nama_acara') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="Gambar_acara">Gambar</label>
                                        <input type="file" name="Gambar_acara" id="Gambar_acara" class="form-control"
                                            placeholder="Contoh: Festival Budaya Sekupang" value="{{ old('Gambar_acara') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Tanggal_mulai_acara">Tanggal Mulai Acara</label>
                                        <input type="date" name="Tanggal_mulai_acara" id="Tanggal_mulai_acara" class="form-control"
                                            value="{{ old('Tanggal_mulai_acara') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Tanggal_berakhir_acara">Tanggal Berakhir Acara</label>
                                        <input type="date" name="Tanggal_berakhir_acara" id="Tanggal_berakhir_acara" class="form-control"
                                            value="{{ old('Tanggal_berakhir_acara') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="Deskripsi">Deskripsi Acara</label>
                                    <textarea name="Deskripsi" id="Deskripsi">{{ old('Deskripsi') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Acara</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/63zi9v8viv1kfc447qvzmn9ohrdjvkr3awyfdfr4nt2jtkvq/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea[name=Deskripsi]',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave(); // ← ini yang penting
                    });
                }
            });
            document.querySelector('form').addEventListener('submit', function() {
                tinymce.triggerSave();
            });
        });
    </script>
@endpush
