@extends('partial.app')
@section('title', 'Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    table.dataTable {
        box-sizing: border-box;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Transaksi</h4>
                    <div class="card-header-action">
                        <a href="/apps/transaksi/giro" type="button" class="btn btn-info mr-1"><i class="fas fa-money-check mr-1"></i> Cek Giro</a>
                        <a href="/apps/transaksi/bookmark-index" type="button" class="btn btn-warning mr-1"><i class="fas fa-bookmark mr-1"></i> Bookmark</a>
                        <a href="/apps/transaksi/create-index" type="button" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambah Data Transaksi</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (auth()->user()->fc_groupuser == 'IN_MNGACT' && auth()->user()->fl_level == 3)
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center text-nowrap">Referensi</th>
                                    <th scope="col" class="text-center">Balance</th>
                                    <th scope="col" class="text-center">Informasi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                        @else
                        <table class="table table-striped" id="tb_applicant" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center text-nowrap">Referensi</th>
                                    <th scope="col" class="text-center">Balance</th>
                                    <th scope="col" class="text-center">Informasi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_request" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Request Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/transaksi/request-approval" method="POST" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input name="fc_trxno" id="fc_trxno" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid" id="fc_applicantid" value="{{ auth()->user()->fc_userid}}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <input name="fc_annotation" id="fc_annotation" type="text" class="form-control" required>
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
    function request_edit(fc_trxno) {
        $("#modal_request").modal('show');
        get(fc_trxno)
    }

    function exist_approval(fc_trxno) {
        $("#modal_loading").modal('show');
        // encode fc_invno
        var fc_trxno_encode = window.btoa(fc_trxno);
        $.ajax({
            url: "/apps/transaksi/cek-exist-approval/" + fc_trxno_encode,
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
                    } else if (response.approve == 'request') {
                        request_edit(fc_trxno)
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

    function get(fc_trxno) {
        var trxno = window.btoa(fc_trxno);

        $.ajax({
            url: "/apps/transaksi/get/" + trxno,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                }, 500);

                if (response.status == 200) {
                    console.log(data);
                    $('#fc_trxno').val(data.fc_trxno);
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
        })
    }

    var tb = $('#tb').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: [8]
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
                data: 'mapping.fc_mappingname'
            },
            {
                data: 'fd_trxdate_byuser',
                render: formatTimestamp
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'fc_docreference'
            },
            {
                data: 'fm_balance',
                render: function(data, type, row) {
                    return row.fm_balance.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'transaksitype.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_trxno = window.btoa(data.fc_trxno);
            var url_lanjutkan = "/apps/approvement/edit/" + fc_trxno;

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/get-data/${fc_trxno}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm" onclick="edit('${url_lanjutkan}')"><i class="fas fa-edit"></i> Edit</button>
                `);
        },
    });

    function edit(url_lanjutkan) {
        swal({
                title: "Apakah anda yakin?",
                text: "Ingin melakukan edit transaksi?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willProceed) => {
                if (willProceed) {
                    sendPUTRequest(url_lanjutkan);
                } else {
                    console.log("PUT request canceled.");
                }
            });
    }

    function sendPUTRequest(url_lanjutkan) {
        $('#modal_loading').modal('show');
        $.ajax({
            url: url_lanjutkan,
            type: 'PUT',
            success: function(response) {
                $('#modal_loading').modal('hide');
                if (response.status == 201) {
                    // arahkan ke response.link
                    window.location.href = response.link;
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(error) {
                $('#modal_loading').modal('hide');
                swal("Error", error.message, "error");
            }
        });
    }

    var tb_applicant = $('#tb_applicant').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: [8]
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
                data: 'mapping.fc_mappingname'
            },
            {
                data: 'fd_trxdate_byuser',
                render: formatTimestamp
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'fc_docreference'
            },
            {
                data: 'fm_balance',
                render: function(data, type, row) {
                    return row.fm_balance.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'transaksitype.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_trxno = window.btoa(data.fc_trxno);

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/get-data/${fc_trxno}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm" onclick="exist_approval('${data.fc_trxno}')"><i class="fas fa-edit"></i> Edit</button>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection