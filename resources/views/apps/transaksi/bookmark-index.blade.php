@extends('partial.app')
@section('title', 'Bookmark Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
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
                    <h4>Daftar Transaksi Pending</h4>
                </div>
                <div class="card-body">
                    @if (auth()->user()->fc_groupuser == 'IN_MNGACT' && auth()->user()->fl_level == 3)
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="berkasku-tab" data-toggle="tab" href="#berkasku" role="tab" aria-controls="berkasku" aria-selected="false">Berkasku</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_bookmark_all" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Operator</th>
                                            <th scope="col" class="text-center text-nowrap">Referensi Doc</th>
                                            <th scope="col" class="text-center">Balance</th>
                                            <th scope="col" class="text-center">Informasi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="berkasku" role="tabpanel" aria-labelledby="berkasku-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_bookmark" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Operator</th>
                                            <th scope="col" class="text-center text-nowrap">Referensi Doc</th>
                                            <th scope="col" class="text-center">Balance</th>
                                            <th scope="col" class="text-center">Informasi</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_bookmark" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center text-nowrap">Referensi Doc</th>
                                    <th scope="col" class="text-center">Balance</th>
                                    <th scope="col" class="text-center">Informasi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
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
    var tb_bookmark = $('#tb_bookmark').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-bookmark",
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
            // encode data.fc_trxno
            var fc_trxno = window.btoa(data.fc_trxno);

            if (data.fc_docreference == "") {
                $('td:eq(5)', row).html(`<i><b>No Reference</b></i>`);
            }

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/lanjutkan-bookmark" class="btn btn-warning btn-sm mr-1 lanjutkan-btn"><i class="fas fa-forward mr-1"></i> Lanjutkan</a>
                `);

            $(row).on('click', '.lanjutkan-btn', function(event) {
                event.preventDefault();

                var fc_mappingcode = $(row).attr('id');
                var url_lanjutkan = "/apps/transaksi/lanjutkan-bookmark/" + fc_trxno;

                showConfirmationDialog(url_lanjutkan);
            });
        },
    });

    var tb_bookmark_all = $('#tb_bookmark_all').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-bookmark-all",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
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
        ],

        rowCallback: function(row, data) {
            // encode data.fc_trxno
            var fc_trxno = window.btoa(data.fc_trxno);

            if (data.fc_docreference == "") {
                $('td:eq(5)', row).html(`<i><b>No Reference</b></i>`);
            }
        },
    });

    function showConfirmationDialog(url_lanjutkan) {
        swal({
                title: "Are you sure?",
                text: "Lanjutkan buat transaksi?",
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


    $('.modal').css('overflow-y', 'auto');
</script>

@endsection