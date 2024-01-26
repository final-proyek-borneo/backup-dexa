@extends('partial.app')
@section('title', 'Detail Retur Barang')
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

    @media (min-width: 992px) and (max-width: 1200px) {
        .flex-row-item {
            font-size: 12px;
        }

        .grand-text {
            font-size: .9rem;
        }
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $retur_mst->fc_userid }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Jumlah Item</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $retur_mst->fn_returdetail }}" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Item
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>No. Retur</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $retur_mst->fc_returno }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>No. Surat Jalan</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $retur_mst->fc_dono }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal Retur</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($retur_mst->fd_returdate)->format('d/m/Y') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Surat Jalan</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $retur_mst->domst->somst->customer->fc_membernpwp_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama Customer</label>
                                    <input type="text" class="form-control" value="{{ $retur_mst->domst->somst->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Pajak</label>
                                    <input type="text" class="form-control" value="{{ $retur_mst->domst->somst->customer->member_tax_code->fv_description }} ({{ $retur_mst->domst->somst->customer->member_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <input type="text" class="form-control" value="{{ $retur_mst->domst->fc_custreceiver }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Kirim</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($retur_mst->domst->fd_dodate)->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Diterima</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($retur_mst->domst->fd_doarivaldate)->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Pengiriman</label>
                                    <input type="text" class="form-control" value="{{ $retur_mst->domst->fc_memberaddress_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Calculation</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
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

        {{-- RETUR ITEM --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item yang Diretur</h4>
                </div>
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
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp.</th>
                                        <th scope="col" class="text-center">CAT.</th>
                                        <th scope="col" class="text-center">Qty Retur</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <a href="/apps/daftar-retur-barang"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('modal')
@endsection

@section('js')
<script>
    var returno = "{{ $retur_mst->fc_returno }}";
    var encode_returno = window.btoa(returno);
    // console.log(encode_dono)

    var tb = $('#tb').DataTable({
        // apabila data kosongs
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/daftar-retur-barang/datatables-detail/" + encode_returno,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'invstore.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired',
                "render": function(data, type, row) {
                    return moment(data).format(
                        // format tanggal
                        'DD MMMM YYYY'
                    );
                }
            },
            {
                data: 'fc_catnumber'
            },
            {
                data: 'fn_returqty'
            },
            {
                data: 'fn_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },

        ],
        rowCallback: function(row, data) {},
        footerCallback: function(row, data, start, end, display) {
            // console.log(data);
            if (data.length != 0) {
                $('#fm_servpay').html("Rp. " + fungsiRupiah(data[0].returmst.fm_servpay));
                $("#fm_servpay").trigger("change");
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].returmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].returmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].returmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html("Rp. " + fungsiRupiah(data[0].returmst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].returmst.fn_returdetail);
                $("#count_item").trigger("change");
            }
        },
    });
</script>
@endsection