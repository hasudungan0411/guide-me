@extends('layouts.admin')

@section('title', 'Detail Blog')
    
@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Blog</a></li>
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
                        <h5 class="card-title">Detail blog {{ $blog->judul }}</h5>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                        <label for="inputLatitude">Judul</label>
                                        <input type="text" class="form-control" id="inputJudul" placeholder="" value="{{ $blog->judul }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputLatitude">Kategori</label>
                                    <input type="text" class="form-control" id="inputKategori" placeholder="" value="{{ $blog->kategori->nama_kategori }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputLongitude">Tanggal</label>
                                    <input type="date" class="form-control" id="inputTanggal" placeholder="" value="{{ $blog->tanggal }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                        <label for="inputLatitude">Slug</label>
                                        <input type="text" class="form-control" id="inputJudul" placeholder="" value="{{ $blog->slug }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2">Deskripsi Pendek</label>
                                <textarea name="short_desk" readonly>{{ $blog->short_desk }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2">Deskripsi Menyeluruh</label>
                                <textarea name="deskripsi" readonly>{{ $blog->deskripsi }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                <label for="inputZip">Gambar</label>
                                    <div class="card bg-dark text-white">
                                        <img src="{{ asset('storage/images/blog/' . $blog->gambar) }}" class="card-img" alt="...">
                                        <div class="card-img-overlay">
                                        </div>
                                    </div>
                                </div>
                            </div>
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