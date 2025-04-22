@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('blog.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Edit Blog</h5>
                            <form action="{{ route('blog.update', $blog->id_blog) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id_blog" value="{{ $blog->id_blog }}">

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputJudul">Judul</label>
                                        <input name="judul" type="text" class="form-control" id="inputJudul"
                                            value="{{ $blog->judul }}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kategori</label>
                                        <select name="kategori_id" class="form-control custom-select">
                                            @foreach ($categories as $kategori)
                                                <option value="{{ $kategori->id_kategori }}" @selected($kategori->id_kategori == $blog->kategori_id)>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputTanggal">Tanggal</label>
                                        <input name="tanggal" type="date" class="form-control" id="inputTanggal"
                                            value="{{ $blog->tanggal }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_desk">Deskripsi Pendek</label>
                                    <textarea name="short_desk" class="form-control" rows="4">{{ $blog->short_desk }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Menyeluruh</label>
                                    <textarea name="deskripsi" class="form-control" rows="6">{{ $blog->deskripsi }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                    <label for="inputZip">Gambar</label>
                                        <div class="card bg-dark text-white">
                                            <img style="max-width: 100%; height: auto;" src="{{ asset('storage/images/blog/' . $blog->gambar) }}" class="card-img"
                                            alt="...">
                                            <div class="card-img-overlay">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="gambar" class="form-control" id="inputgambar">
                                    </div>
                                </div>

                                <button id="submitBtn" type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
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
                selector: 'textarea[name=short_desk], textarea[name=deskripsi]',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                setup: function(editor) {
                    const submitBtn = document.getElementById('submitBtn');

                    editor.on('keyup', function() {
                        const name = editor.targetElm.getAttribute('name');
                        if (name === 'short_desk' || name === 'deskripsi') {
                            const content = editor.getContent({
                                format: 'text'
                            });
                            const wordCount = content.split(/\s/).filter(Boolean).length;
                            // submitBtn.disabled = wordCount < 15;
                            submitBtn.disabled = false;
                        }
                    });
                }
            });
        });
    </script>
@endpush
