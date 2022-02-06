@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('users-store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Enter Name">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter email" value="{{ old('email') }}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="form-control">
                                        <option value="">--Pilih Jenis Kelamin--</option>
                                        <option value="L" @if (old('jk') == 'L') selected="selected" @endif>Laki-laki</option>
                                        <option value="P" @if (old('jk') == 'P') selected="selected" @endif>Perempuan</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('jk') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="">--Pilih Level--</option>
                                        <option value="1" @if (old('level') == '1') selected="selected" @endif>Admin</option>
                                        <option value="2" @if (old('level') == '2') selected="selected" @endif>Kasir</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('level') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="no_telp">No. HP</label>
                                    <input type="number" class="form-control" id="no_telp" name="no_telp"
                                        placeholder="Enter No. HP" value="{{ old('no_telp') }}">
                                    <span class="text-danger">{{ $errors->first('no_telp') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" value="{{ old('password') }}">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
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

@endsection
