@extends('layouts.admin')

@section('title', 'Tambah Kategori')
    
@section('content')

<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('kategori.index') }}" class="btn btn-primary mb-3">Kembali</a>
                        <h5 class="card-title">Tambah kategori</h5>
                        <form id="uploadForm" action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputkategori">Kategori</label>
                                    <input id="nama_kategori" name="nama_kategori" type="text" class="form-control" placeholder="Arung Jeram" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                <label for="inputZip">Gambar</label>
                                    <input type="file" name="gambar" class="form-control" id="upload_image" accept="image/*"  required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
                        </form>
                        <div id="uploadimageModal" class="modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Crop &amp; Upload Gambar</h4>
                                    <button type="button" class="close" data-dismiss="modal" >
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div id="image_demo"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success crop_image" data-dismiss="modal">Crop &amp; Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection