@extends('partial.app')
@section('title', 'Daftar BPB')
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data BPB</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="terbayar-tab" data-toggle="tab" href="#terbayar" role="tab" aria-controls="terbayar" aria-selected="false">Terbayar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="diterima-tab" data-toggle="tab" href="#diterima" role="tab" aria-controls="diterima" aria-selected="false">Diterima</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/master-receiving-order/export-excel/all" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_semua" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">No. PO</th>
                                            <th scope="col" class="text-center text-nowrap">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center text-nowrap">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Invoice</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="terbayar" role="tabpanel" aria-labelledby="terbayar-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/master-receiving-order/export-excel/terbayar" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_terbayar" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">No. PO</th>
                                            <th scope="col" class="text-center text-nowrap">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center text-nowrap">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Invoice</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                            <div class="table-responsive">
                                <form id="exportForm" action="/apps/master-receiving-order/export-excel/diterima" method="POST" target="_blank">
                                    @csrf
                                    <div class="button text-right mb-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                    </div>
                                </form>
                                <table class="table table-striped" id="tb_diterima" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">No. PO</th>
                                            <th scope="col" class="text-center text-nowrap">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center text-nowrap">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Invoice</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
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
                <form id="form_submit_pdf" action="/apps/master-receiving-order/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_rono" id="fc_rono_input" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
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
    @endsection

    @section('js')
    <script>
        // untuk form input nama penanggung jawab
        $(document).ready(function() {
            var isNamePjShown = false;

            $('#name_user_lainnya').click(function() {
                // Uncheck #name_user
                $('#name_user').prop('checked', false);

                // Show #form_pj
                if (!isNamePjShown) {
                    $('.form-group').append(
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
        function click_modal_nama(fc_rono) {
            // #fc_rono_input value
            $('#fc_rono_input').val(fc_rono);
            $('#modal_nama').modal('show');
        };

        var tb = $('#tb_semua').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8, 9]
            }, {
                className: 'text-nowrap',
                targets: [2, 6, 10]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: 'pomst.supplier.fc_supplierlegalstatus'
                },
                {
                    data: 'pomst.supplier.fc_suppliername1',
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: 'fc_invstatus'
                },
                {
                    data: 'fn_rodetail'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Terbayar</span>');
                } else if (data['fc_rostatus'] == 'L') {
                    $('td:eq(7)', row).html('<span class="badge badge-danger">Lock</span>');
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Diterima</span>');
                }

                if (data['fc_invstatus'] == 'INV') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_invstatus'] == 'N') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                } else {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                //  console.log(data.rodtl[0].invstore.fc_barcode)

                $('td:eq(10)', row).html(`
                    <a href="/apps/master-receiving-order/detail/${fc_rono}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_rono}')"><i class="fa fa-file"></i> PDF</button>
                `);
                // <a href="/apps/master-receiving-order/pdf/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            },
        });

        var tb = $('#tb_terbayar').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8, 9]
            }, {
                className: 'text-nowrap',
                targets: [2, 10]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: 'pomst.supplier.fc_supplierlegalstatus'
                },
                {
                    data: 'pomst.supplier.fc_suppliername1',
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: 'fc_invstatus'
                },
                {
                    data: 'fn_rodetail'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Terbayar</span>');
                } else {
                    $(row).hide();
                }

                if (data['fc_invstatus'] == 'INV') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_invstatus'] == 'N') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                } else {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                $('td:eq(10)', row).html(`
                    <a href="/apps/master-receiving-order/detail/${fc_rono}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_rono}')"><i class="fa fa-file"></i> PDF</button>
                `);
            },
        });

        var tb = $('#tb_diterima').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8, 9]
            }, {
                className: 'text-nowrap',
                targets: [2, 6, 10]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: 'pomst.supplier.fc_supplierlegalstatus'
                },
                {
                    data: 'pomst.supplier.fc_suppliername1',
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: 'fc_invstatus'
                },
                {
                    data: 'fn_rodetail'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'R') {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Diterima</span>');
                } else {
                    $(row).hide();
                }

                if (data['fc_invstatus'] == 'INV') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_invstatus'] == 'N') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                } else {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                $('td:eq(10)', row).html(`
                    <a href="/apps/master-receiving-order/detail/${fc_rono}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_rono}')"><i class="fa fa-file"></i> PDF</button>
                `);
            },
        });
    </script>
    @endsection