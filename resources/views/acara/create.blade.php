@extends('layouts.pemilik')

@section('title', 'Tambah Acara')

@push('styles')
    <!-- Include Mapbox GL CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
    <link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css"
        rel="stylesheet" />
    <style>
        #map {
            width: 100% !important;
            height: 500px !important;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="page-info">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Acara</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('pemilik.acara') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Acara</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('acara.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input name="tanggal_acara" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Acara</label>
                                    <input name="nama_acara" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control"></textarea>
                                </div>
                                <button id="submitBtn" type="submit" class="btn btn-primary mt-3">Simpan
                                    Data</button>
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
                selector: 'textarea[name=desk], textarea[name=long_desk]',
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
