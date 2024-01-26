@extends('partial.app')
@section('title', 'Daftar Cost Per Test')
@section('css')
    <style>
        .text-secondary {
            color: #969DA4 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .btn-secondary {
            background-color: #A5A5A5 !important;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
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
                        <h4>Data Cost Per Test</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua"
                                    role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="menunggu-tab" data-toggle="tab" href="#menunggu" role="tab"
                                    aria-controls="menunggu" aria-selected="false">Menunggu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                                    aria-controls="pending" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab"
                                    aria-controls="selesai" aria-selected="false">Selesai</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="semua" role="tabpanel"
                                aria-labelledby="semua-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/daftar-cprr/export-excel/all" method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_semua" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tanggal</th>
                                                <th scope="col" class="text-center">Expired</th>
                                                <th scope="col" class="text-center">Tipe</th>
                                                <th scope="col" class="text-center">Operator</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/daftar-cprr/export-excel/menunggu" method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_menunggu" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tanggal</th>
                                                <th scope="col" class="text-center">Expired</th>
                                                <th scope="col" class="text-center">Tipe</th>
                                                <th scope="col" class="text-center">Operator</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/daftar-cprr/export-excel/pending" method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_pending" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tanggal</th>
                                                <th scope="col" class="text-center">Expired</th>
                                                <th scope="col" class="text-center">Tipe</th>
                                                <th scope="col" class="text-center">Operator</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/daftar-cprr/export-excel/clear" method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_selesai" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tanggal</th>
                                                <th scope="col" class="text-center">Expired</th>
                                                <th scope="col" class="text-center">Tipe</th>
                                                <th scope="col" class="text-center">Operator</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Total</th>
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
                <form id="form_submit_pdf" action="/apps/master-sales-order/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_dono" id="fc_dono_input" hidden>
                    <input type="text" name="fc_sono" id="fc_sono_input" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user" id="name_user"
                                            checked="">
                                        <label class="form-check-label" for="name_user">
                                            {{ auth()->user()->fc_username }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user_lainnya"
                                            id="name_user_lainnya">
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
        function click_modal_nama(fc_dono, fc_sono) {
            $('#fc_dono_input').val(fc_dono);
            $('#fc_sono_input').val(fc_sono);
            $('#modal_nama').modal('show');
        };

        function closeSO(fc_sono) {
            swal({
                title: "Konfirmasi",
                text: "Anda yakin ingin menutup sales order ini?",
                type: "warning",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/master-sales-order/close',
                        type: 'PUT',
                        data: {
                            fc_sostatus: 'CL',
                            fc_sono: fc_sono
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
                                tb.ajax.reload();
                                tb_menunggu.ajax.reload();
                                tb_pending.ajax.reload();
                                tb_selesai.ajax.reload();
                                tb_done.ajax.reload();
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

        var tb = $('#tb_semua').DataTable({
            processing: true,
            serverSide: true,
            pageLength : 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-cprr/datatables/ALL',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 10]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_sono'
                },
                {
                    data: 'fd_sodatesysinput',
                    render: formatTimestamp
                },
                {
                    data: 'fd_soexpired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_sotype'
                },
                {
                    data: 'fc_userid'
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fn_sodetail'
                },
                {
                    data: 'fc_sostatus'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
                var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

                var fc_sono = window.btoa(data.fc_sono);
                // console.log(data);

                // jika data.domst tidak kosong
                if (data.domst) {
                    var fc_dono = window.btoa(data.domst.fc_dono);
                } else {
                    var fc_dono = window.btoa(undefined);
                }

                $('td:eq(8)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_sostatus'] == 'F') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Menunggu</span>');
                } else if (data['fc_sostatus'] == 'C') {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Selesai</span>');
                } else if (data['fc_sostatus'] == 'DD') {
                    $('td:eq(8)', row).html('<span class="badge badge-info">DO Tuntas</span>');
                } else if (data['fc_sostatus'] == 'P') {
                    $('td:eq(8)', row).html('<span class="badge badge-warning">Pending</span>');
                } else if (data['fc_sostatus'] == 'CC') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Cancel</span>');
                } else if (data['fc_sostatus'] == 'CL') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Close</span>');
                } else if (data['fc_sostatus'] == 'WA') {
                    $('td:eq(8)', row).html('<span class="badge badge-warning">Menunggu Perizinan</span>');
                }  
                else {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Lock</span>');
                }

                if (data['fc_sostatus'] == 'CC' || data['fc_sostatus'] == 'CL') {
                $('td:eq(10)', row).html(`
                    <a href="/apps/daftar-cprr/detail/${fc_sono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}','${data.fc_sono}')"><i class="fa fa-file"></i> PDF</button>
                `);
                } else {
                $('td:eq(10)', row).html(`
                    <a href="/apps/daftar-cprr/detail/${fc_sono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}','${data.fc_sono}')"><i class="fa fa-file"></i> PDF</button>
                    <button class="btn btn-danger btn-sm ml-1" onclick="closeSO('${data.fc_sono}')"><i class="fa fa-times"></i> Close SO</button>
                `);
                }
                // <a href="/apps/master-sales-order/pdf/${fc_dono}/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            }
        });

        var tb_menunggu = $('#tb_menunggu').DataTable({
            processing: true,
            serverSide: true,
            pageLength : 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-cprr/datatables/F',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 10]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_sono'
                },
                {
                    data: 'fd_sodatesysinput',
                    render: formatTimestamp
                },
                {
                    data: 'fd_soexpired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_sotype'
                },
                {
                    data: 'fc_userid'
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fn_sodetail'
                },
                {
                    data: 'fc_sostatus'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
                var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

                var fc_sono = window.btoa(data.fc_sono);
                // console.log(fc_sono);

                $('td:eq(8)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_sostatus'] == 'F') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Menunggu</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(10)', row).html(`
            <a href="/apps/daftar-cprr/detail/${fc_sono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}','${data.fc_sono}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-danger btn-sm ml-1" onclick="closeSO('${data.fc_sono}')"><i class="fa fa-times"></i> Close SO</button>
         `);
            }
        });

        var tb_pending = $('#tb_pending').DataTable({
            processing: true,
            serverSide: true,
            pageLength : 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-cprr/datatables/P',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 10]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_sono'
                },
                {
                    data: 'fd_sodatesysinput',
                    render: formatTimestamp
                },
                {
                    data: 'fd_soexpired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_sotype'
                },
                {
                    data: 'fc_userid'
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fn_sodetail'
                },
                {
                    data: 'fc_sostatus'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
                var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

                var fc_sono = window.btoa(data.fc_sono);
                // console.log(fc_sono);

                $('td:eq(8)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_sostatus'] == 'P') {
                    $('td:eq(8)', row).html('<span class="badge badge-warning">Pending</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(10)', row).html(`
            <a href="/apps/daftar-cprr/detail/${fc_sono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}','${data.fc_sono}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-danger btn-sm ml-1" onclick="closeSO('${data.fc_sono}')"><i class="fa fa-times"></i> Close SO</button>
         `);
            }
        });

        var tb_selesai = $('#tb_selesai').DataTable({
            processing: true,
            serverSide: true,
            pageLength : 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-cprr/datatables/C',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 10]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_sono'
                },
                {
                    data: 'fd_sodatesysinput',
                    render: formatTimestamp
                },
                {
                    data: 'fd_soexpired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_sotype'
                },
                {
                    data: 'fc_userid'
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fn_sodetail'
                },
                {
                    data: 'fc_sostatus'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
                var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data
                    .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

                var fc_sono = window.btoa(data.fc_sono);
                // console.log(fc_sono);

                $('td:eq(8)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_sostatus'] == 'C') {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Selesai</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(10)', row).html(`
            <a href="/apps/daftar-cprr/detail/${fc_sono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}','${data.fc_sono}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-danger btn-sm ml-1" onclick="closeSO('${data.fc_sono}')"><i class="fa fa-times"></i> Close SO</button>
         `);
            }
        });
    </script>
@endsection
