@extends('layouts.base_user.base_dashboard')

@section('judul', 'Reservasi')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Transaksi</li>
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
        <h4><i class="icon fa fa-check"></i>Berhasil!</h4>
        {{ session('status') }}
    </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Transaksi</h3>

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

                             <input
                                    type="number"
                                    id="inputIdRervasi"
                                    name="idReservasi"
                                    class="form-control @error('idReservasi') is-invalid @enderror"
                                    value="{{ $transaksi->idReservasi }}"
                                    required="required"
                                    readonly
                                    style="display: none;">

                            <div class="form-group">
                                <label for="inputtipeKamar">Jumlah Pembayaran</label>
                                <input
                                    type="text"
                                    id="inputJumlahPembayaran"
                                    name="jumlahPembayaran"
                                    class="form-control @error('jumlahPembayaran') is-invalid @enderror"
                                    value="{{ $transaksi->totalBiaya }}"
                                    required="required"
                                    readonly>
                                @error('jumlahPembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputtipeKamar">Metode Pembayaran</label>
                                    <select
                                        id="inputMetodePembayaran"
                                        name="metodePembayaran"
                                        class="form-control @error('metodePembayaran') is-invalid @enderror"
                                        required = "required"
                                        value="{{ old('metodePembayaran') }}"
                                        autocomplete="metodePembayaran"
                                    >
                                        <option value="CASH">CASH</option>
                                        <option value="TRANSFER">TRANSFER BANK</option>
                                        <option value="E-MONEY">E-MONEY</option>
                                    </select>
                                    @error('metodePembayaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputStatus">Tipe Pembayaran</label>
                                <select 
                                    name="status" 
                                    id="inputStatus"
                                    class="form-control @error('metodePembayaran') is-invalid @enderror"
                                    required="required"
                                    value="{{ old('status') }}"
                                    autocomplete="status"
                                >
                                    <option value="DP">DP</option>
                                    <option value="FP">FP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('user.home') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Bayar" class="btn btn-success float-right">
                    </div>
                </div>
        </div>
    </form>
</section>
@endsection

@section('script_footer')

@endsection