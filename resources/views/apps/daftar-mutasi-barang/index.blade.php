@extends('partial.app')
@section('title', 'Daftar Mutasi Barang')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary {
        color: #969DA4 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .btn-secondary {
        background-color: #A5A5A5 !important;
    }

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .flex-row-item {
            font-size: 12px;
        }

        .grand-text {
            font-size: .9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Mutasi Barang</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="internal-tab" data-toggle="tab" href="#internal" role="tab" aria-controls="internal" aria-selected="true">Internal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="eksternal-tab" data-toggle="tab" href="#eksternal" role="tab" aria-controls="eksternal" aria-selected="false">Eksternal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="belum-terlaksana-tab" data-toggle="tab" href="#belum-terlaksana" role="tab" aria-controls="belum-terlaksana" aria-selected="false">Belum Terlaksana</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="internal" role="tabpanel" aria-labelledby="internal-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/daftar-mutasi-barang/export-excel/internal" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_internal" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Mutasi</th>
                                            <th scope="col" class="text-center">No. SO</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center text-nowrap">Lokasi Awal</th>
                                            <th scope="col" class="text-center text-nowrap">Lokasi Tujuan</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="belum-terlaksana" role="tabpanel" aria-labelledby="belum-terlaksana-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/daftar-mutasi-barang/export-excel/belum" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_belum_terlaksana" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Mutasi</th>
                                            <th scope="col" class="text-center">No. SO</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center text-nowrap"">Lokasi Awal</th>
                                            <th scope="col" class="text-center text-nowrap">Lokasi Tujuan</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="eksternal" role="tabpanel" aria-labelledby="eksternal-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/daftar-mutasi-barang/export-excel/eksternal" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_eksternal" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Mutasi</th>
                                            <th scope="col" class="text-center">No. SO</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center text-nowrap">Lokasi Awal</th>
                                            <th scope="col" class="text-center text-nowrap">Lokasi Tujuan</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Penanda Tangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_pdf" action="/apps/daftar-mutasi-barang/pdf" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="fc_mutationno" id="fc_mutationno_input_ttd" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group form_group_ttd">
                                <label class="d-block">Nama</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user" id="name_user" checked="">
                                    <label class="form-check-label" for="name_user">
                                        {{ auth()->user()->fc_username }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user_lainnya" id="name_user_lainnya">
                                    <label class="form-check-label" for="name_user_lainnya">
                                        Lainnya
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_terlaksana" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Nama Penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/daftar-mutasi-barang/submit" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="text" name="fc_mutationno" id="fc_mutationno_input_terlaksana" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="fc_penerima" id="fc_penerima">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var isNamePjShown = false;

        $('#name_user_lainnya').click(function() {
            // Uncheck #name_user
            $('#name_user').prop('checked', false);

            // Show #form_pj
            if (!isNamePjShown) {
                $('.form_group_ttd').append(
                    '<div class="form-group" id="form_pj"><label>Nama PJ</label><input type="text" class="form-control" name="name_pj" id="name_pj"></div>'
                );
                isNamePjShown = true;
            }
        });

        $('#name_user').click(function() {
            // Uncheck #name_user_lainnya
            $('#name_user_lainnya').prop('checked', false);

            // Hide #form_pj
            if (isNamePjShown) {
                $('#form_pj').remove();
                isNamePjShown = false;
            }
        });

        $('#name_pj').focus(function() {
            $('.form-group:last').toggle();
        });
    });

    // untuk memunculkan nama penanggung jawab
    function click_modal_nama(fc_mutationno) {
        $('#fc_mutationno_input_ttd').val(fc_mutationno);
        $('#modal_nama').modal('show');
    };

    function click_modal_terlaksana(fc_mutationno) {
        $('#fc_mutationno_input_terlaksana').val(fc_mutationno);
        $('#modal_terlaksana').modal('show');
    };

    var tb_internal = $('#tb_internal').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/daftar-mutasi-barang/datatables-internal",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 5, 6]
        }, {
            className: 'text-nowrap',
            targets: [8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_mutationno'
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_date_byuser',
                render: formatTimestamp
            },
            {
                data: 'warehouse_start.fc_rackname'
            },
            {
                data: 'warehouse_destination.fc_rackname'
            },
            {
                data: 'fc_statusmutasi'
            },
            {
                data: 'fn_detailitem'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_mutationno = window.btoa(data.fc_mutationno);
            $('td:eq(6)', row).html(`<i class="${data.fc_statusmutasi}"></i>`);
            if (data['fc_statusmutasi'] == 'P') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Proses</span>');
            } else {
                $('td:eq(6)', row).html('<span class="badge badge-success">Terlaksana</span>');
            }

            $('td:eq(8)', row).html(`
                <a href="/apps/daftar-mutasi-barang/detail/${fc_mutationno}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_mutationno}')"><i class="fa fa-file"></i> PDF</button>
                `);
        },
    });

    var tb_eksternal = $('#tb_eksternal').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/daftar-mutasi-barang/datatables-eksternal",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 5, 6]
        }, {
            className: 'text-nowrap',
            targets: [8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_mutationno'
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_date_byuser',
                render: formatTimestamp
            },
            {
                data: 'warehouse_start.fc_rackname'
            },
            {
                data: 'warehouse_destination.fc_rackname'
            },
            {
                data: 'fc_statusmutasi'
            },
            {
                data: 'fn_detailitem'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_mutationno = window.btoa(data.fc_mutationno);
            $('td:eq(6)', row).html(`<i class="${data.fc_statusmutasi}"></i>`);
            if (data['fc_statusmutasi'] == 'P') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Proses</span>');
            } else {
                $('td:eq(6)', row).html('<span class="badge badge-success">Terlaksana</span>');
            }

            $('td:eq(8)', row).html(`
                <a href="/apps/daftar-mutasi-barang/detail/${fc_mutationno}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_mutationno}')"><i class="fa fa-file"></i> PDF</button>
                `);
        },
    });

    var tb_belum_terlaksana = $('#tb_belum_terlaksana').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/daftar-mutasi-barang/datatables-belum-terlaksana",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 5, 6, 7, 8]
        }, ],
        columns: [{ 
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_mutationno'
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_date_byuser',
                render: formatTimestamp
            },
            {
                data: 'warehouse_start.fc_rackname'
            },
            {
                data: 'warehouse_destination.fc_rackname'
            },
            {
                data: 'fc_statusmutasi'
            },
            {
                data: 'fn_detailitem'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_mutationno = window.btoa(data.fc_mutationno);
            $('td:eq(6)', row).html(`<i class="${data.fc_statusmutasi}"></i>`);
            if (data['fc_statusmutasi'] == 'P') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Proses</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(8)', row).html(`
                <button class="btn btn-info btn-sm ml-1" onclick="click_modal_terlaksana('${data.fc_mutationno}')"><i class="fa fa-check"></i> Telah Terlaksana</button>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection