@extends('partial.app')
@section('title', 'Giro Berjalan')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .select2-selection__rendered {
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 id="masuk">Daftar Giro Masuk</h4>
                    <h4 id="keluar" hidden>Daftar Giro Keluar</h4>
                    <div class="card-header-action">
                        <select name="category" class="form-control select2" id="category">
                            <option value="D" selected>Giro Masuk</option>
                            <option value="C">Giro Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="giro-masuk">
                        <table class="table table-striped" id="tb_giro_masuk" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">No. Giro</th>
                                    <th scope="col" class="text-center text-nowrap">Customer</th>
                                    <th scope="col" class="text-center text-nowrap">Nominal</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive" id="giro-keluar" hidden>
                        <table class="table table-striped" id="tb_giro_keluar" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">No. Giro</th>
                                    <th scope="col" class="text-center text-nowrap">Supplier</th>
                                    <th scope="col" class="text-center text-nowrap">Nominal</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 text-right">
            <a href="/apps/transaksi" type="button" class="btn btn-info mr-1">Back</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $("#category").change(function() {
        if ($('#category').val() === 'D') {
            $('#giro-masuk').attr('hidden', false);
            $('#giro-keluar').attr('hidden', true);
            $('#masuk').attr('hidden', false);
            $('#keluar').attr('hidden', true);
        } else {
            $('#giro-masuk').attr('hidden', true);
            $('#giro-keluar').attr('hidden', false);
            $('#masuk').attr('hidden', true);
            $('#keluar').attr('hidden', false);
        }
    });

    var tb_giro_masuk = $('#tb_giro_masuk').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/transaksi/datatables-giro/D",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_trxno'
            },
            {
                data: 'fc_refno'
            },
            {
                data: 'coa.fc_coaname',
                defaultContent: '-'
            },
            {
                data: 'fm_value',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                render: formatTimestamp
            },
            {
                data: 'fc_girostatus'
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            if (data['fc_girostatus'] == 'W') {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-success">Tuntas</span>');
            }

            if (data['fc_girostatus'] == 'W') {
                $('td:eq(8)', row).html(`
                <button class="btn btn-info btn-sm ml-1" onclick="tuntaskan('${data.id}')"><i class="fa-solid fa-check-to-slot"></i> Tuntaskan</button>
                `);
            } else {
                $('td:eq(8)', row).html(`
                <button class="btn btn-success btn-sm ml-1"><i class="fa-solid fa-check"></i></button>
                `);
            }
        },
    });

    var tb_giro_keluar = $('#tb_giro_keluar').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/transaksi/datatables-giro/C",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_trxno'
            },
            {
                data: 'fc_refno'
            },
            {
                data: 'coa.fc_coaname',
                defaultContent: '-'
            },
            {
                data: 'fm_value',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                render: formatTimestamp
            },
            {
                data: 'fc_girostatus'
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            if (data['fc_girostatus'] == 'W') {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-success">Tuntas</span>');
            }

            if (data['fc_girostatus'] == 'W') {
                $('td:eq(8)', row).html(`
                <button class="btn btn-info btn-sm ml-1" onclick="tuntaskan('${data.id}')"><i class="fa-solid fa-check-to-slot"></i> Tuntaskan</button>
                `);
            } else {
                $('td:eq(8)', row).html(`
                <button class="btn btn-success btn-sm ml-1"><i class="fa-solid fa-check"></i></button>
                `);
            }
        },
    });

    function tuntaskan(id) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin menuntaskan Giro ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/transaksi/clear',
                    type: 'PUT',
                    data: {
                        fc_girostatus: 'C',
                        id: id
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 200) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb_giro_masuk.ajax.reload();
                            tb_giro_keluar.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                            .responseText + ")", {
                                icon: 'error',
                            });
                    }
                });
            }
        });
    }

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection