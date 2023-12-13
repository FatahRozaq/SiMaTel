@extends('layouts.base_user.base_dashboard')

@section('judul', 'List Kamar Hotel')

@section('script_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')

@if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>Berhasil!</h4>
        {{ session('status') }}
    </div>
@endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Reservasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Reservasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="margin: 20px">
                <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID Rervasi</th>
                            <th>ID Kamar</th>
                            <th>Tanggal Check In</th>
                            <th>Tanggal Check Out</th>
                            <th>Status</th>
                            <th>Bayar</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script_footer')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [
                    { data: 'idReservasi', name: 'idReservasi' },
                    { data: 'idKamar', name: 'idKamar' },
                    { data: 'tanggalCheckIn', name: 'tanggalCheckIn' },
                    { data: 'tanggalCheckOut', name: 'tanggalCheckOut' },
                    { data: 'status', name: 'status' },
                    {
                        data: 'idReservasi',
                        name: 'idReservasi',
                        render: function (data, type, full, meta) {
                            if(full.status != 'FP'){
                                var routeUrl = '{{ route("user.transaksi", ":idReservasi") }}';
                                routeUrl = routeUrl.replace(':idReservasi', data);
                                return '<a href="' + routeUrl + '" class="bayar" data-id="' + data + '"><i class="fas fa-shopping-cart fa-lg"></i></a>';
                            } else {
                                return 'Sudah Lunas'
                            }
                            
                        }
                    },
                    {
                        data: 'idReservasi',
                        name: 'idReservasi',
                        render: function (data, type, full, meta) {
                            return '<a href="#" class="hapusData" data-id="' + data + '"><i class="fas fa-trash fa-lg text-danger"></i></a>';
                        }
                    }
                ]
            });

            // Edit button click event
            

            // Delete button click event
            $('#tbl_list').on('click', '.hapusData', function (e) {
                e.preventDefault();
                var idKamar = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dipilih akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("kamar.delete", ["id" => ":id"]) }}'.replace(':id', idKamar),
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function (data) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Terhapus!',
                                    'Data yang dipilih telah dihapus.',
                                    'success'
                                );
                            },
                            error: function (error) {
                                console.log('Error:', error);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection