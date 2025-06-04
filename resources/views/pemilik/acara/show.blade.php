@extends('layouts.pemilik')

@section('title', 'Detail Acara')

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
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.acara.index') }}">Acara</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail acara {{ $acara->Nama_acara }}</h5>
                            <form>
                            <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input name="tanggal_mulai_acara" type="date" class="form-control" value="{{ $acara->Tanggal_mulai_acara }}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input name="tanggal_berakhir_acara" type="date" class="form-control" value="{{ $acara->Tanggal_berakhir_acara }}">
                                </div>
                                <div class="form-group">
                                    <label>Nama Acara</label>
                                    <input name="nama_acara" type="text" class="form-control" value="{{ $acara->Nama_acara }}">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" value="{{ $acara->Deskripsi }}"></textarea>
                                </div>
                            </form>
                            <a href="{{ route('pemilik.acara.index') }}" class="btn btn-primary mt-3">Kembali ke daftar</a>
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
