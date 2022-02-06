@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Produk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                {{-- content tabel --}}
                <div class="col-12">
                    @if ($message = Session::get('pesan'))

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Produk</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('produk-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                        value="{{ old('nama_produk') }}" placeholder="Enter Name">
                                    <span class="text-danger">{{ $errors->first('nama_produk') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="Enter harga" value="{{ old('harga') }}">
                                    <span class="text-danger">{{ $errors->first('harga') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">

                                    <input type="file" style="height: 45px;" class="form-control" id="gambar"
                                        name="gambar" placeholder="Enter gambar" onchange="previewImage()">
                                        
                                    <span class="text-danger">{{ $errors->first('gambar') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="kategori_id">Kategori</label>
                                    <select name="kategori_id" id="kategori_id" class="form-control">
                                        <option value="">--Pilih Kategori--</option>
                                        @foreach ($kategoris as $kt)
                                            <option value="{{ $kt->id }}">{{ $kt->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('kategori_id') }}</span>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function previewImage() {
            const image = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();

            // 
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
