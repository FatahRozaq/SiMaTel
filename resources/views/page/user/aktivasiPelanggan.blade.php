@extends('layouts.base_admin.base_dashboard') @section('judul', 'Aktivasi Pelanggan')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Aktivasi Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Aktivasi Pelanggan</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
      </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="column">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Data Pribadi</h3>

                            <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-tool"
                                    data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputtipeKamar">Nama Pelanggan</label>
                                <input
                                    type="text"
                                    id="inputNamaPelanggan"
                                    name="namaPelanggan"
                                    class="form-control @error('namaPelanggan') is-invalid @enderror"
                                    value="{{ $user->name }}"
                                    required="required"
                                    autocomplete="namaPelanggan">
                                @error('namaPelanggan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Alamat">Alamat</label>
                                <input
                                    type="text"
                                    id="inputAlamat"
                                    name="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    value="{{ old('alamat') }}"
                                    required="required"
                                    autocomplete="alamat">
                                @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Alamat">Nomor Telepon</label>
                                <input
                                    type="text"
                                    id="inputNoTelepon"
                                    name="noTelepon"
                                    class="form-control @error('noTelepon') is-invalid @enderror"
                                    value="{{ old('noTelepon') }}"
                                    required="required"
                                    autocomplete="noTelepon">
                                @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputhargaPerMalam">Email</label>
                                <input
                                    type="text"
                                    id="inputEmail"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ $user->email }}"
                                    required="required"
                                    autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Alamat">Nomor Identifikasi</label>
                                <input
                                    type="text"
                                    id="inputNoIdentifikasi"
                                    name="noIdentifikasi"
                                    class="form-control @error('noIdentifikasi') is-invalid @enderror"
                                    value="{{ old('alamat') }}"
                                    required="required"
                                    autocomplete="alamat">
                                @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Aktivasi" class="btn btn-success float-right">
                </div>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection
