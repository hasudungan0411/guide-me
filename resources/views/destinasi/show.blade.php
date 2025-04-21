@extends('layouts.admin')

@section('title', 'Detail Destinasi')

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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}">Destination</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail destinasi {{ $destination->tujuan }}</h5>
                            <form>
                                <div class="form-group">
                                    <label>Destinasi</label>
                                    <input type="text" class="form-control" value="{{ $destination->tujuan }}" disabled>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Latitude</label>
                                        <input type="text" class="form-control" value="{{ $destination->latitude }}"
                                            disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" value="{{ $destination->longitude }}"
                                            disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control"
                                            value="{{ $destination->kategori->nama_kategori ?? '-' }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Pendek</label>
                                    <textarea name="desk" readonly>{!! $destination->desk !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Menyeluruh</label>
                                    <textarea name="long_desk" readonly>{!! $destination->long_desk !!}</textarea>
                                </div>

                                <div class="row">
                                    @php
                                        $gambarFields = [
                                            'gambar',
                                            'gambar2',
                                            'gambar3',
                                            'gambar4',
                                            'gambar5',
                                            'gambarM',
                                        ];
                                    @endphp
                                    @foreach ($gambarFields as $index => $field)
                                        @if (!empty($destination->$field))
                                            <div class="col-md-3 mb-3">
                                                <label>Gambar {{ $index }}</label>
                                                <div class="card bg-dark text-white">
                                                    <img src="{{ asset('storage/images/destinasi/' . $destination->$field) }}"
                                                        class="card-img" alt="Gambar {{ $index }}">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="form-row mt-4">
                                    <div class="form-group col-md-8">
                                        <label>Peta</label>
                                        <div id="map" data-lat="{{ $destination->latitude }}"
                                            data-lng="{{ $destination->longitude }}" disabled></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Navigasi</label>
                                        <div id="directions-container"></div>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('destinasi.index') }}" class="btn btn-primary mt-3">Kembali ke daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- untuk mapbox  --}}
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
    <script src="{{ asset('assets/component/mapbox_detail.js') }}"></script>

    {{-- untuk tnymce  --}}
    <script src="https://cdn.tiny.cloud/1/63zi9v8viv1kfc447qvzmn9ohrdjvkr3awyfdfr4nt2jtkvq/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea[name=desk], textarea[name=long_desk]',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                readonly: true, // Pastikan editor dalam mode hanya-baca
                setup: function(editor) {
                    // Pastikan hanya bisa dibaca dan tidak ada pengeditan
                    editor.on('init', function() {
                        editor.getBody().setAttribute('contenteditable', 'false');
                    });
                }
            });
        });
    </script>
@endpush
