@extends('layouts.admin')

@section('title', 'Tambah Blog')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Destination</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('blog.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Blog</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputLatitude">Judul</label>
                                        <input name="judul" type="text" class="form-control" id="inputLatitude"
                                            placeholder="Jembatan barelang 2" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputLatitude">Tanggal</label>
                                        <input name="tanggal" type="date" class="form-control" id="inputLatitude"
                                            placeholder="11221.0" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kategori</label>
                                        <select name="kategori_id" class="form-control custom-select">
                                            @foreach ($categories as $kategori)
                                                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Deskripsi Pendek</label>
                                    <textarea name="short_desk"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress3">Deskripsi Menyeluruh</label>
                                    <textarea name="deskripsi"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputZip">Gambar</label>
                                        <input type="file" name="gambar" class="form-control" id="inputgambar" required>
                                    </div>
                                </div>
                                <button id="submitBtn" type="submit" class="btn btn-primary mt-3">Simpan Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- untuk tnymce  --}}
    <script src="https://cdn.tiny.cloud/1/63zi9v8viv1kfc447qvzmn9ohrdjvkr3awyfdfr4nt2jtkvq/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea[name=short_desk], textarea[name=deskripsi]',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                setup: function(editor) {
                    var submitBtn = document.getElementById('submitBtn');

                    editor.on('keyup', function() {
                        if (editor.targetElm && editor.targetElm.getAttribute('name') ===
                            'desk') {
                            var content = editor.getContent({
                                format: 'text'
                            });
                            var wordCount = content.split(/\s/).filter(Boolean).length;
                            submitBtn.disabled = wordCount < 1;
                        }
                    });
                }
            });
        });
    </script>
@endpush
