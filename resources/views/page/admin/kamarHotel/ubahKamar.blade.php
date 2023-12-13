@extends('layouts.base_admin.base_dashboard') @section('judul', 'Ubah Kamar Hotel')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ubah Kamar Hotel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Ubah Kamar Hotel</li>
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
                            <h3 class="card-title">Informasi Data Kamar Hotel</h3>

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
                                <label for="inputtipeKamar">Tipe Kamar</label>
                                <input
                                    type="text"
                                    id="inputtipeKamar"
                                    name="tipeKamar"
                                    class="form-control @error('tipeKamar') is-invalid @enderror"
                                    placeholder="Masukkan Nama Fasilitas"
                                    value="{{ $kamar->tipeKamar }}"
                                    required="required"
                                    autocomplete="tipeKamar">
                                @error('tipeKamar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select
                                    id="inputStatus"
                                    name="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required="required"
                                    autocomplete="status"
                                >
                                    <option value="Tersedia" @if($kamar->status === 'Tersedia') selected @endif>Tersedia</option>
                                    <option value="Terisi" @if($kamar->status === 'Terisi') selected @endif>Terisi</option>
                                    <option value="Perbaikan" @if($kamar->status === 'Perbaikan') selected @endif>Perbaikan</option>
                                    <!-- Tambahkan opsi status lainnya sesuai kebutuhan -->
                                </select>
                                @error('status')
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
                    <input type="submit" value="Simpan Perubahan" class="btn btn-success float-right">
                </div>
            </div>
        </div>
    </form>

</section>
<!-- /.content -->

@endsection 
