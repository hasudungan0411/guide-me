@extends('layouts.admin')

@section('title', 'Tambah Destinasi')

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
                <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}">Destination</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('destinasi.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Destinasi</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('destinasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Destinasi</label>
                                    <input name="tujuan" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jual Tiket</label>
                                    <select name="jual_tiket" class="form-control custom-select" required>
                                        <option value="tidak">Tidak</option>
                                        <option value="ya">Ya</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Latitude</label>
                                        <input name="latitude" type="text" class="form-control" id="latitude" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Longitude</label>
                                        <input name="longitude" type="text" class="form-control" id="longitude" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kategori</label>
                                        <select name="kategori_id" class="form-control custom-select">
                                            @foreach ($categories as $kategori)
                                                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Pendek</label>
                                    <textarea name="desk" class="form-control" id="desk"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Menyeluruh</label>
                                    <textarea name="long_desk" class="form-control"></textarea>
                                </div>
                                <div class="row">
                                    @for ($i = 1; $i <= 6; $i++)
                                        <div class="col-md-3">
                                            <label>Gambar {{ $i }}</label>
                                            <input type="file" name="gambar{{ $i == 6 ? 'M' : ($i == 1 ? '' : $i) }}"
                                                class="form-control" required>
                                        </div>
                                    @endfor
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-md-8">
                                        <label>Peta</label>
                                        <div id="map"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Navigasi</label>
                                        <p>Silakan copy LAT dan LANG pada input <b>B(destinasi)</b></p>
                                        <div id="directions-container"></div>
                                    </div>
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
    {{-- untuk Mapbox --}}
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
    <script src="{{ url('assets/component/mapbox_add.js') }}"></script>

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
