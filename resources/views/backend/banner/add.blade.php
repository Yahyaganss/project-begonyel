@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Banner</h1>
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
                        <form role="form" action="{{ route('banner-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">


                                <div class="form-group">
                                    <label for="banner">Gambar Banner</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">

                                    <input type="file" style="height: 45px;" class="form-control" id="banner"
                                        name="banner" placeholder="Enter Image" onchange="previewImage()">
                                        
                                    <span class="text-danger">{{ $errors->first('banner') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="status_banner">Status Banner</label>
                                    <select name="status_banner" id="status_banner" class="form-control">
                                        <option value="">--Pilih Kategori--</option>
                                        <option value="publish" @if (old('status_banner') == 'publish') selected="selected" @endif>Publish</option>
                                        <option value="not_publish" @if (old('status_banner') == 'not_publish') selected="selected" @endif>Not Publish</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status_banner') }}</span>
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
            const image = document.querySelector('#banner');
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
