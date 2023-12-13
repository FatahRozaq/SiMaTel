@extends('layouts.base_admin.base_dashboard')

@section('judul', 'List Fasilitas Hotel')

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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Fasilitas Hotel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Fasilitas Hotel</li>
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

                
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-file-excel"></i> Import Data
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form untuk Memilih File -->
                                    <form action="{{ route('fasilitas.import') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="file">Type: .xlsx, .xls</label>
                                                <input type="file" name="file" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Import Data</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Ekspor Excel -->
                    <a href="{{ route('fasilitas.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor Excel
                    </a>
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
                            <th>Nama Fasilitas</th>
                            <th>Status</th>
                            <th>Jumlah Tamu</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
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
                    { data: 'namaFasilitas', name: 'namaFasilitas' },
                    { data: 'status', name: 'status' },
                    { data: 'jumlahTamu', name: 'jumlahTamu' },
                    { data: 'deskripsi', name: 'deskripsi' },
                    {
                        data: 'idFasilitas',
                        name: 'idFasilitas',
                        render: function (data, type, full, meta) {
                            return '<a href="#" class="editData" data-id="' + data + '"><i class="fas fa-edit fa-lg"></i></a> ' +
                                   '<a href="#" class="hapusData" data-id="' + data + '"><i class="fas fa-trash fa-lg text-danger"></i></a>';
                        }
                    },
                ]
            });

            // Edit button click event
            $('#tbl_list').on('click', '.editData', function (e) {
                e.preventDefault();
                var idFasilitas = $(this).data('id');
                window.location.href = '{{ route("fasilitas.edit", ["idFasilitas" => ":idFasilitas"]) }}'.replace(':idFasilitas', idFasilitas);
            });

            // Delete button click event
            $('#tbl_list').on('click', '.hapusData', function (e) {
                e.preventDefault();
                var idFasilitas = $(this).data('id');

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
                            url: '{{ route("fasilitas.delete", ["id" => ":id"]) }}'.replace(':id', idFasilitas),
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