@extends('partial.app')
@section('title', 'Sales Order')
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
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12" hidden>
                                <div class="form-group">
                                    <label>Submit : {{ $data->fd_sodatesysinput }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>No. SO : {{ $data->fc_sono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Order : {{ date('d-m-Y', strtotime ($data->fd_sodateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                <div class="form-group">
                                    <label>Expired : {{ date('d-m-Y', strtotime($data->fd_soexpired)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <input type="text" class="form-control" value="{{ $data->sales->fc_salesname1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>SO Type</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_sotype }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{ $data->fc_membercode }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $data->member_tax_code->fv_description }} ({{ $data->member_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <form id="form_cancel" action="/apps/master-sales-order/cancel_so" method="PUT">
                                    @csrf
                                    <input type="hidden" name="fc_sono" value="{{ $data->fc_sono }}">
                                    @if (($data->fc_sostatus == 'CL') || ($data->fc_sostatus == 'C') || ($data->fc_sostatus == 'CC') || ($data->fc_sostatus == 'DD'))
                                    <button type="submit" class="btn btn-danger" hidden>Cancel SO</button>
                                    @else
                                    <button type="submit" class="btn btn-danger">Cancel SO</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Customer</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membernpwp_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_memberaddress_loading1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $data->customer->fm_memberAP,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">DO</th>
                                        <th scope="col" class="text-center">Sisa</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Disc.(Rp)</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TRANSPORT --}}
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label>Transport</label>
                                <input type="text" class="form-control" value="{{ $data->fc_sotransport }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label>Pelayanan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ number_format($data->fm_servpay,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-7 place_detail">
            <div class="card" style="height: 225px">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item"></p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_so_disc">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">{{ number_format($data->fm_servpay,0,',','.') }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE SO PAY --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_sopay" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No.</th>
                                        <th scope="col" class="text-center">Kode Metode Pembayaran</th>
                                        <th scope="col" class="text-center">Deskripsi Metode</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Tanggal</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Catatan</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse3" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <textarea class="form-control" style="height: 70px;" readonly>{{ $data->fv_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <a href="/apps/master-sales-order"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/master-sales-order/datatables-so-detail",
            type: 'GET',
        },
        columnDefs: [{
            targets: [7],
            defaultContent: "-",
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'stock.fc_namelong'
            },
            {
                data: 'namepack.fv_description'
            },
            {
                data: 'fn_so_qty'
            },
            {
                data: 'fn_so_bonusqty'
            },
            {
                data: 'fn_do_qty'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return row.fn_so_qty - row.fn_do_qty;
                }
            },
            {
                data: 'fm_so_oriprice',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fm_so_disc'
            },
            {
                data: 'total_harga',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: "-",
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            if (data.fn_do_qty == 0) {
                $('td:eq(12)', row).html('<span class="badge badge-primary"><i class="fa fa-hourglass"></i> Menunggu</span>');
            } else if (data.fn_do_qty < data.fn_so_qty != 0) {
                $('td:eq(12)', row).html('<span class="badge badge-warning"><i class="fa fa-spinner"></i> Pending</span>');
            } else {
                $('td:eq(12)', row).html('<span class="badge badge-success"><i class="fa fa-check"></i> Selesai</span>');
            }
            // <a href="/apps/master-sales-order/pdf/${fc_dono}/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
        },
        footerCallback: function(row, data, start, end, display) {

            let count_quantity = 0;
            let total_harga = 0;
            let grand_total = 0;

            for (var i = 0; i < data.length; i++) {
                count_quantity += data[i].fn_so_qty;
                total_harga += data[i].total_harga;
                grand_total += data[i].total_harga;
            }

            $('#count_quantity').html(count_quantity);
            // $('#total_harga').html(fungsiRupiah(grand_total));
            // $('#grand_total').html("Rp. " + fungsiRupiah(total_harga));
            // servpay
            if (data.length != 0) {
                $('#fm_servpay').html("Rp. " + fungsiRupiah(data[0].somst.fm_servpay));
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].somst.fm_tax));
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].somst.fm_brutto));
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].somst.fm_netto));
                $('#fm_so_disc').html("Rp. " + fungsiRupiah(data[0].somst.fn_disctotal));
                $('#count_item').html(data[0].somst.fn_sodetail);
            }
        }
    });

    var tb_sopay = $('#tb_sopay').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/master-sales-order/datatables-so-payment",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, ]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_sopaymentcode',
                name: 'Kode Metode Pembayaran'
            },
            {
                data: 'fc_description',
                name: 'Deskripsi Metode'
            },
            {
                data: 'fm_valuepayment',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                name: 'Nominal'
            },
            {
                data: "fd_paymentdate",
                render: formatTimestamp
            },
            {
                data: 'fv_keterangan',
                name: 'Keterangan',
                defaultContent: "-",
            },
        ],
    });
</script>
@endsection