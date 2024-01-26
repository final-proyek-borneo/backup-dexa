@extends('partial.app')
@section('title', 'Daftar Invoice')
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
                        <h4>Data Invoice</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="penjualan-tab" data-toggle="tab" href="#penjualan"
                                    role="tab" aria-controls="penjualan" aria-selected="true">Penjualan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pembelian-tab" data-toggle="tab" href="#pembelian" role="tab"
                                    aria-controls="pembelian" aria-selected="false">Pembelian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cprr-tab" data-toggle="tab" href="#cprr" role="tab"
                                    aria-controls="cprr" aria-selected="false">CPRR</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="penjualan" role="tabpanel"
                                aria-labelledby="penjualan-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb_penjualan" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Invoice</th>
                                                <th scope="col" class="text-center">No. SJ</th>
                                                <th scope="col" class="text-center text-nowrap">Tgl Terbit</th>
                                                <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Tagihan</th>
                                                <th scope="col" class="text-center">Terbayar</th>
                                                <th scope="col" class="text-center text-nowrap">Cetak</th>
                                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pembelian" role="tabpanel" aria-labelledby="pembelian-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb_pembelian" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Invoice</th>
                                                <th scope="col" class="text-center">No. BPB</th>
                                                <th scope="col" class="text-center text-nowrap">Tgl Terbit</th>
                                                <th scope="col" class="text-center  text-nowrap">Jatuh Tempo</th>
                                                <th scope="col" class="text-center">Supplier</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Tagihan</th>
                                                <th scope="col" class="text-center">Terbayar</th>
                                                <th scope="col" class="text-center text-nowrap">Cetak</th>
                                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cprr" role="tabpanel" aria-labelledby="cprr-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb_cprr" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Invoice</th>
                                                <th scope="col" class="text-center text-nowrap">Tgl Terbit</th>
                                                <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Tagihan</th>
                                                <th scope="col" class="text-center">Terbayar</th>
                                                <th scope="col" class="text-center text-nowrap">Cetak</th>
                                                <th scope="col" class="text-center">Catatan</th>
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
                <form id="form_submit_cek" action="/apps/daftar-invoice/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_invno" id="fc_invno_input" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_pj"
                                            id="{{ auth()->user()->fc_username }}" checked=""
                                            value="{{ auth()->user()->fc_username }}">
                                        <label class="form-check-label" for="{{ auth()->user()->fc_username }}">
                                            {{ auth()->user()->fc_username }}
                                        </label>
                                    </div>
                                    <div id="name_user_lainnya"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Tampilan Diskon</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" name="tampil_diskon" id="tampil_diskon" value="N"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Nominal</span>
                                        </label>
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" checked name="tampil_diskon" id="tampil_diskon"
                                                checked="" value="P" class="selectgroup-input">
                                            <span class="selectgroup-button">Persen</span>
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

    <div class="modal fade" role="dialog" id="modal_diskon" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Tampilan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modal_diskon_form" action="#" method="GET" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tampilan Diskon</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <a href="" target="_blank" class="btn btn-primary" id="radio-button-nominal"
                                                type="radio">Nominal</a>
                                        </label>
                                        <label class="selectgroup-item" style="margin-left: 10px">
                                            <a href="" target="_blank" class="btn btn-success" id="radio-button-persen"
                                                type="radio">Persen</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="modal_ttd" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Penanda Tangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit_kwitansi" action="/apps/daftar-invoice/kwitansi" method="POST"
                    autocomplete="off">
                    @csrf
                    <input type="text" name="fc_invno" id="fc_invno_input2" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group-2">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nama_user" id="nama_user"
                                            checked="">
                                        <label class="form-check-label" for="nama_user">
                                            {{ auth()->user()->fc_username }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nama_user_lainnya"
                                            id="nama_user_lainnya">
                                        <label class="form-check-label" for="nama_user_lainnya">
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

    <div class="modal fade" role="dialog" id="modal_request" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Request Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/daftar-invoice/request-approval" method="POST" autocomplete="off">
                    <input type="text" class="form-control" name="fc_branch" id="fc_branch"
                        value="{{ auth()->user()->fc_branch }}" readonly hidden>
                    <input type="text" name="name_pj" id="name_pj_req" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-8">
                                <div class="form-group">
                                    <label>No. Invoice</label>
                                    <input name="fc_invno" id="fc_invno_req" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Pemohon</label>
                                    <input name="fc_applicantid" id="fc_applicantid"
                                        value="{{ auth()->user()->fc_userid }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="form-group required">
                                    <label>Keterangan</label>
                                    <input name="fc_annotation" id="fc_annotation" type="text" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            get_user();
        })

        // Pembuatan variabel Global-Ephemeral untuk menyimpan sementara invno
        var globalInvno;

        function need_approval() {
            $("#modal_nama").modal('hide');
            $("#modal_request").modal('show');
            get(globalInvno);
        }

        // Modifikasi Fungsi Get agar bisa mengakses invno
        function get(invno) {
            var fc_invno = window.atob(invno);
            $('#fc_invno_req').val(fc_invno);

            var globalName = document.getElementsByName('name_pj');
            for (i = 0; i < globalName.length; i++) {
                if (globalName[i].checked)
                    var name_pj = globalName[i].value;
            };

            $('#name_pj_req').val(name_pj);

        }

        // function get(name) {
        //     $('#name_pj_req').val(name_pj);
        // }

        // untuk form input nama penanggung jawab
        $(document).ready(function() {
            var isNamePjShown2 = false;
            $('#nama_user_lainnya').click(function() {
                // Uncheck #name_user
                $('#nama_user').prop('checked', false);

                // Show #form_pj
                if (!isNamePjShown2) {
                    $('.form-group-2').append(
                        '<div class="form-group" id="form_pj_2"><label>Nama PJ</label><input type="text" class="form-control" name="nama_pj" id="nama_pj"></div>'
                    );
                    isNamePjShown2 = true;
                }
            });

            $('#nama_user').click(function() {
                // Uncheck #name_user_lainnya
                $('#nama_user_lainnya').prop('checked', false);

                // Hide #form_pj
                if (isNamePjShown2) {
                    $('#form_pj_2').remove();
                    isNamePjShown2 = false;
                }
            });

            $('#nama_pj').focus(function() {
                $('.form-group-2:last').toggle();
            });
        });

        function get_user() {
            $("#modal_loading").modal('show');
            $.ajax({
                url: "/apps/daftar-invoice/get-user",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status === 200) {
                        var data = response.data;
                        // console.log(data);
                        for (var i = 0; i < data.length; i++) {
                            $("#name_user_lainnya").append(`
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name_pj" id="${data[i].fc_userid}" value="${data[i].fc_userid}">
                                <label class="form-check-label" for="${data[i].fc_userid}"">
                                    ${data[i].fc_userid}
                                </label>
                            </div>
                        `);
                        }
                    } else {
                        iziToast.error({
                            title: 'Error!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }


        function cekExistApproval(fc_invno) {
            $("#modal_loading").modal('show');
            // encode fc_invno
            var fc_invno_encode = window.btoa(fc_invno);
            $.ajax({
                url: "/apps/daftar-invoice/cek-exist-approval/" + fc_invno_encode,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status === 200) {
                        // console.log(response)
                        if (response.approve == 'wait') {
                            swal(response.message, {
                                icon: 'error',
                            });
                        } else if (response.approve == 'pdf') {
                            click_modal_diskon(response.link);
                            // window.open(response.link,
                            //     '_blank'
                            // );
                        } else if (response.approve == 'request') {
                            click_modal_nama(fc_invno);
                        } else {
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT", {
                                icon: 'error',
                            });
                        }
                    } else {
                        iziToast.error({
                            title: 'Error!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }

        function click_modal_diskon(tampil_diskon_value) {
            var tampil_diskon = $('.tampil_diskon').val();
            $('#radio-button-persen').attr('href', tampil_diskon_value + "/" + "P");
            $('#radio-button-nominal').attr('href', tampil_diskon_value + "/" + "N");

            $("#radio-button-persen").on('click', reloadTB)
            $("#radio-button-nominal").on('click', reloadTB)
            $('#modal_diskon').modal('show');
        };

        function reloadTB(){
            tb_penjualan.ajax.reload(null, false);
            tb_pembelian.ajax.reload(null, false);
            tb_cprr.ajax.reload(null, false);
        }

        // untuk memunculkan nama penanggung jawab
        function click_modal_nama(fc_invno) {
            // #fc_pono_input value
            $('#fc_invno_input').val(fc_invno);
            $('#modal_nama').modal('show');

            globalInvno = window.btoa(fc_invno);
        };

        function click_modal_ttd(fc_invno) {
            // #fc_pono_input value
            $('#fc_invno_input2').val(fc_invno);
            $('#modal_ttd').modal('show');
        };

        var tb_penjualan = $('#tb_penjualan').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            order: [
                [3, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-invoice/datatables/SALES',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 6, 7]
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
                    data: 'fc_invno',
                    defaultContent: '-'
                },
                {
                    data: 'fc_child_suppdocno',
                    defaultContent: '-'
                },
                {
                    data: 'fd_inv_releasedate',
                    render: formatTimestamp
                },
                {
                    data: 'fd_inv_agingdate',
                    render: formatTimestamp
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fm_paidvalue',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                    defaultContent: '-'
                },
                {
                    data: 'fn_printout',
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var fc_invno = window.btoa(data.fc_invno);
                // console.log(fc_sono);

                $('td:eq(6)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'R') {
                    $('td:eq(6)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_status'] == 'I') {
                    $('td:eq(6)', row).html('<span class="badge badge-warning">Pending</span>');
                } else if (data['fc_status'] == 'L') {
                    $('td:eq(6)', row).html('<span class="badge badge-danger">Lock</span>');
                } else {
                    $('td:eq(6)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                $('td:eq(10)', row).html(
                    `
            <a href="/apps/daftar-invoice/detail/${fc_invno}/SALES"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm mr-1" onclick="cekExistApproval('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-info btn-sm" onclick="click_modal_ttd('${data.fc_invno}')"><i class="fa-solid fa-receipt"></i> Kuitansi</button>`
                    )
            }
        });

        var tb_pembelian = $('#tb_pembelian').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            order: [
                [3, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-invoice/datatables/PURCHASE',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 6, 7]
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
                    data: 'fc_invno',
                    defaultContent: '-'
                },
                {
                    data: 'romst.fc_rono',
                    defaultContent: '-'
                },
                {
                    data: 'fd_inv_releasedate',
                    render: formatTimestamp
                },
                {
                    data: 'fd_inv_agingdate',
                    render: formatTimestamp
                },
                {
                    data: 'supplier.fc_suppliername1'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fm_paidvalue',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                    defaultContent: '-'
                },
                {
                    data: 'fn_printout',
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var fc_invno = window.btoa(data.fc_invno);
                // console.log(fc_sono);

                $('td:eq(6)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'R') {
                    $('td:eq(6)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_status'] == 'I') {
                    $('td:eq(6)', row).html('<span class="badge badge-warning">Pending</span>');
                } else if (data['fc_status'] == 'L') {
                    $('td:eq(6)', row).html('<span class="badge badge-danger">Lock</span>');
                } else {
                    $('td:eq(6)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                $('td:eq(10)', row).html(`
            <a href="/apps/daftar-invoice/detail/${fc_invno}/PURCHASE"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm mr-1" onclick="cekExistApproval('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-info btn-sm" onclick="click_modal_ttd('${data.fc_invno}')"><i class="fa-solid fa-receipt"></i> Kuitansi</button>
         `);
            }
        });

        var tb_cprr = $('#tb_cprr').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/daftar-invoice/datatables/CPRR',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [2, 3, 10]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_invno',
                    defaultContent: '-'
                },
                {
                    data: 'fd_inv_releasedate',
                    render: formatTimestamp
                },
                {
                    data: 'fd_inv_agingdate',
                    render: formatTimestamp
                },
                {
                    data: 'customer.fc_membername1'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fm_paidvalue',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                    defaultContent: '-'
                },
                {
                    data: 'fn_printout',
                },
                {
                    data: 'fv_description',
                    defaultContent: '-'
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var fc_invno = window.btoa(data.fc_invno);
                // console.log(fc_sono);

                $('td:eq(5)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'R') {
                    $('td:eq(5)', row).html('<span class="badge badge-primary">Terbit</span>');
                } else if (data['fc_status'] == 'I') {
                    $('td:eq(5)', row).html('<span class="badge badge-warning">Pending</span>');
                } else if (data['fc_status'] == 'L') {
                    $('td:eq(5)', row).html('<span class="badge badge-danger">Lock</span>');
                } else {
                    $('td:eq(5)', row).html('<span class="badge badge-success">Lunas</span>');
                }

                $('td:eq(10)', row).html(`
            <a href="/apps/daftar-invoice/detail/${fc_invno}/CPRR"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm mr-1" onclick="cekExistApproval('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
            <button class="btn btn-info btn-sm" onclick="click_modal_ttd('${data.fc_invno}')"><i class="fa-solid fa-receipt"></i> Kuitansi</button>
         `);
                //  <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
            }
        });

        $('#form_submit_cek').on('submit', function(e) {
            e.preventDefault();
            var form_id = $(this).attr("id");
            if (check_required(form_id) === false) {
                swal("Oops! Mohon isi field yang kosong", {
                    icon: 'warning',
                });
                return;
            }
            swal({
                    title: 'Yakin?',
                    text: 'Apakah anda yakin akan menyimpan data ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((save) => {
                    if (save) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: $('#form_submit_cek').attr('action'),
                            type: $('#form_submit_cek').attr('method'),
                            data: $('#form_submit_cek').serialize(),
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status === 301) {
                                    $("#modal").modal('hide');
                                    swal({
                                        title: 'Membutuhkan Approval',
                                        text: 'Invoice ini Membutuhkan Approval, Apakah anda ingin melanjutkan?',
                                        icon: 'warning',
                                        buttons: true,
                                        dangerMode: true,
                                    }).then((willContinue) => {
                                        if (willContinue) {
                                            need_approval();
                                        }
                                    });
                                } else if (response.status == 300) {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                    $("#modal").modal('hide');
                                } else {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    tb_penjualan.ajax.reload(null, false);
                                    tb_pembelian.ajax.reload(null, false);
                                    tb_cprr.ajax.reload(null, false);
                                    $("#modal_nama").modal('hide');
                                    //  location.href = response.link;
                                    window.open(
                                        response.link,
                                        '_blank' // <- This is what makes it open in a new window.
                                    );
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
        });
    </script>
@endsection
