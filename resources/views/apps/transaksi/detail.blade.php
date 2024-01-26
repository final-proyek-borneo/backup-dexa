@extends('partial.app')
@section('title', 'Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    table.dataTable tbody tr td {
        word-wrap: break-word;
        word-break: break-all;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" id="fc_branch" value="{{ $data->branch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" id="fc_userid" value="{{ $data->fc_userid }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Tgl Transaksi</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_trxdate_byuser" class="form-control" name="fd_trxdate_byuser" value="{{ \Carbon\Carbon::parse( $data->fd_trxdate_byuser )->isoFormat('D MMMM Y'); }}" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group">
                                    <label>Tipe Jurnal</label>
                                    <input type="text" class="form-control" id="fc_mappingtrxtype" name="fc_mappingtrxtype" value="{{ $data->transaksitype->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Referensi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_docreference" name="fc_docreference" value="{{ $data->fc_docreference }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="form-row">
                            <div class="col-12 col-md-6 col-lg-3 mr-4">
                                <div class="form-group required">
                                    <label>No. Transaksi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_trxno" name="fc_trxno" value="{{ $data->fc_trxno }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2 mr-4">
                                <div class="form-group">
                                    <label>Nama Transaksi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_mappingname" name="fc_mappingname" value="{{ $data->mapping->fc_mappingname }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mr-3">
                                <div class="form-group d-flex-row">
                                    <label>Debit</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success" style="font-weight: bold; font-size:large" id="debit" name="debit">Rp. 0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mr-3">
                                <div class="form-group d-flex-row">
                                    <label id="label_kekurangan">Kredit</label>
                                    <div class="text mt-2">
                                        <h5 class="text-danger" style="font-weight: bold; font-size:large" id="kredit" name="kredit">Rp. 0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group d-flex-row">
                                    <label>Balance</label>
                                    <div class="text mt-2">
                                        <h5 class="text-muted" style="font-weight: bold; font-size:large" id="balance" name="balance">Rp. 0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Debit --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Debit</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_debit" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Kredit --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kredit</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_kredit" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($supp > 0)
        {{-- Opsi Lanjutan --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Opsi Lanjutan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_opsi" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                @if ($data->fv_description == null)
                                <input type="text" name="fv_description" id="fv_description" class="form-control" readonly>
                                @else
                                <input type="text" name="fv_description" id="fv_description" class="form-control" value="{{ $data->fv_description }}" readonly>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button text-right mb-4">
                <a href="/apps/transaksi" type="button" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
@endsection

@section('js')
<script>
    var trxno = "{{ $data->fc_trxno }}";
    var balance = "{{ $data->fm_balance }}"
    var encode_trxno = window.btoa(trxno);

    $.ajax({
        url: "/apps/transaksi/data/" + encode_trxno,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            let debit = 0;
            let kredit = 0;

            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i].fc_statuspos == 'D') {
                    debit += parseFloat(data.data[i].fm_nominal);
                } else {
                    kredit += parseFloat(data.data[i].fm_nominal);
                }
            }

            $('#debit').html(fungsiRupiahSystem(parseFloat(debit)));
            $('#kredit').html(fungsiRupiahSystem(parseFloat(kredit)));
            $('#balance').html(fungsiRupiahSystem(parseFloat(balance)));
        }
    });

    var tb_debit = $('#tb_debit').DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        destroy: true,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/data-debit/" + encode_trxno,
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
                data: 'fc_coacode',
                "width": "20px"
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: 'fm_nominal',
                render: function(data, type, row) {
                    return row.fm_nominal.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                },
                "width": "200px"
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: 'fc_refno',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                defaultContent: '-',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
        ],

        rowCallback: function(row, data) {},
        footerCallback: function(row, data, start, end, display) {}
    });

    var tb_kredit = $('#tb_kredit').DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        destroy: true,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/data-kredit/" + encode_trxno,
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
                data: 'fc_coacode',
                "width": "20px"
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: 'fm_nominal',
                render: function(data, type, row) {
                    return row.fm_nominal.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                },
                "width": "200px"
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: 'fc_refno',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                defaultContent: '-'
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
        ],

        rowCallback: function(row, data) {},
        footerCallback: function(row, data, start, end, display) {}
    });


    var tb_opsi = $('#tb_opsi').DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/data-opsi/" + encode_trxno,
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
                data: 'fc_coacode',
                "width": "20px"
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: 'fm_nominal',
                render: function(data, type, row) {
                    return row.fm_nominal.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                },
                "width": "200px"
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: 'fc_refno',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                defaultContent: '-',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
        ],

        rowCallback: function(row, data) {},
    });
</script>

@endsection