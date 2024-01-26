@extends('partial.app')
@section('title', 'Surat Jalan')
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
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>No. SO : {{ $data->fc_sono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Order : {{ date('d-m-Y', strtotime($data->fd_sodateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Exp. : {{ date('d-m-Y', strtotime($data->fd_soexpired)) }}
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
                                    <label>Tipe Order</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_sotype }}" readonly>
                                </div>
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
                    <div class="card-body" style="height: 215px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membernpwp_no }}" readonly>
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
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_memberaddress1 }}" readonly>
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
                <div class="card-header">
                    <h4>Order Item</h4>
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
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">DO</th>
                                        <th scope="col" class="text-center">Bonus DO</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <!-- <th scope="col" class="text-center">Harga</th>
                                                                                                    <th scope="col" class="text-center">Disc.(Rp)</th>
                                                                                                    <th scope="col" class="text-center">Total</th> -->
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DELIVERY ITEM --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item yang Dikirim</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="deliver-item" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">CAT</th>
                                        <th scope="col" class="text-center">Exp.</th>
                                        <!-- <th scope="col" class="text-center">Harga</th>
                                                                                                                                <th scope="col" class="text-center">Disc.</th>
                                                                                                                                <th scope="col" class="text-center">Total</th> -->
                                        <th scope="col" class="text-center">Approval</th>
                                        <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="form_submit" action="/apps/delivery-order/update_transport/{{ base64_encode($data->fc_sono) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Transport</label>
                                    <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                        <option value="">- Pilih Transport -</option>
                                        <option value="By Dexa">By Dexa</option>
                                        <option value="By Paket">By Paket</option>
                                        <option value="By Customer">By Customer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Transporter</label>
                                    <div class="input-group">
                                        @if ($domst->fm_servpay == 0.0 && empty($domst->fc_sotransport))
                                        <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fc_transporter" required>
                                        @else
                                        <input type="text" class="form-control" value="{{ $domst->fc_transporter }}" fdprocessedid="hgh1fp" name="fc_transporter">
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Biaya Penanganan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_servpay" id="fm_servpay" value="{{ number_format($domst->fm_servpay, 0, ',', '.') }}" onkeyup="return onkeyupRupiah(this.id);" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Tanggal DO</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        {{-- input waktu sekarang format timestamp tipe hidden --}}
                                        <input type="hidden" class="form-control" name="fd_dodatesysinput" id="fd_dodatesysinput" value="{{ date('d-m-Y') }}">
                                        @if (empty($domst->fc_sotransport) && empty($domst->fc_transporter))
                                        <input type="text" id="fd_dodate" class="form-control datepicker" name="fd_dodate" required>
                                        @else
                                        <input type="text" id="fd_dodate" class="form-control datepicker" name="fd_dodate" @if ($domst->fd_dodate) value="{{ date('d-m-Y', strtotime($domst->fd_dodate)) }}"
                                        @else
                                        value="" @endif
                                        required>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Alamat Tujuan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_memberaddress_loading" id="fc_memberaddress_loading" value="{{ $domst->fc_memberaddress_loading }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                @if (empty($domst->fd_dodate))
                                <button type="submit" class="btn btn-success">Save</button>
                                @else
                                <button type="submit" class="btn btn-warning">Edit</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card" id="card_calculation">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
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
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <button type="button" onclick="click_delete()" class="btn btn-danger mr-2">Cancel Surat Jalan</button>
        <button onclick="cek_submit()" type="button" class="btn btn-success mr-2">Submit</button>
    </div>
</div>
</div>

@endsection

@section('loading')
{{-- loading --}}
{{-- <div class="loading" id="loading_data" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Ketersediaan Stock</h5>
                <div class="card-header-action">
                    <select data-dismiss="modal" onchange="bonus_type()" class="form-control select2 required-field" name="#" id="category">
                        <option value="Regular">Regular&nbsp;&nbsp;</option>
                        <option value="Bonus">Bonus&nbsp;&nbsp;</option>
                    </select>
                </div>
            </div>
            <div class="place_alert_cart_stock text-center"></div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" id="stock_inventory">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Katalog</th>
                                    <th scope="col" class="text-center">Barcode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Exp.</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let encode_fc_sono = "{{ base64_encode($data->fc_sono) }}";

    function bonus_type() {
        var stock_inventory_table = $('#stock_inventory').DataTable();
        var selectedOption = $('#category').val();

        // get the data rows from the table
        var rows = stock_inventory_table.rows().nodes();

        // loop through the rows and update the input values based on the selected option
        rows.each(function(index, row) {
            var data = stock_inventory_table.row(row).data();
            var inputField = $(row).find('input[type="number"]');

            console.log(selectedOption);
            // console.log(selectedOption);
        });
    }

    function pilih_inventory(fc_stockcode) {
        // console.log(fc_stockcode);
        // encode
        var encode_fc_stockcode = window.btoa(fc_stockcode);
        // console.log(encode_fc_stockcode);
        $("#modal_loading").modal('show');

        // tampilkan loading_data
        var stock_inventory_table = $('#stock_inventory');
        if ($.fn.DataTable.isDataTable(stock_inventory_table)) {
            stock_inventory_table.DataTable().destroy();
        }
        stock_inventory_table.DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 5,
            "ordering": false,
            "ajax": {
                "url": '/apps/delivery-order/datatables-stock-inventory/' + encode_fc_stockcode,
                "type": "GET",
                "data": {
                    "fc_stockcode": fc_stockcode
                }
            },
            "columns": [{
                    "data": 'DT_RowIndex',
                    "sortable": false,
                    "searchable": false
                },
                {
                    "data": "fc_stockcode"
                },
                {
                    "data": "fc_barcode"
                },
                {
                    "data": "stock.fc_namelong"
                },
                {
                    "data": "fn_quantity"
                },
                {
                    "data": "fc_batch"
                },
                {
                    "data": "fd_expired",
                    "render": function(data, type, row) {
                        return moment(data).format(
                            // format tanggal
                            'DD MMMM YYYY'
                        );
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        // console.log('data'+data.fn_sorrownum);
                        var selectedOption = $('#category').val();
                        var barcodeEncode = window.btoa(data.fc_barcode);
                        // looping data data.stock.sodtl[index].fn_so_qty
                        if (selectedOption == "Bonus") {
                            let qty = 0;
                            // looping data stock.sodtl[index].fn_so_qty
                            for (let index = 0; index < data.stock.sodtl.length; index++) {
                                if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                    qty = data.stock.sodtl[index].fn_so_bonusqty - data.stock.sodtl[
                                        index].fn_do_bonusqty;
                                    break;
                                }
                            }

                            if (qty >= data.fn_quantity) {
                                return `<input type="number" id="bonus_quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${data.fn_quantity}">`;
                            } else {
                                return `<input type="number" id="bonus_quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${qty}">`;
                            }
                            // reload datatable

                        } else {
                            for (let index = 0; index < data.stock.sodtl.length; index++) {
                                if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                    var qty = data.stock.sodtl[index].fn_so_qty - data.stock.sodtl[
                                        index].fn_do_qty;
                                    break;
                                }
                            }

                            // console.log("qty"+qty);
                            if (qty >= data.fn_quantity) {
                                // console.log("qty"+ data.fn_quantity);
                                return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${data.fn_quantity}">`;
                            } else {
                                if (qty < 0) {
                                    return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="0">`;
                                }
                                return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${qty}">`;
                            }
                        }

                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        var selectedOption = $('#category').val();
                        if (selectedOption == "Bonus") {
                            let qty = 0;
                            // looping data stock.sodtl[index].fn_so_qty
                            for (let index = 0; index < data.stock.sodtl.length; index++) {
                                if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                    qty = data.stock.sodtl[index].fn_so_bonusqty - data.stock.sodtl[
                                        index].fn_do_bonusqty;
                                    break;
                                }
                            }

                            // if (qty == 0) {
                            //     return `<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`;
                            // } else {
                            //     return `<button type="button" class="btn btn-primary" onclick="select_stock('${data.fc_barcode}','${data.fc_stockcode}')">Select</button>`;
                            // }
                            if (qty == 0) {
                                return `<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`;
                            } else {
                                return `<button type="button" class="btn btn-primary" onclick="select_stock('${data.fc_barcode}','${data.fc_stockcode}')">Select</button>`;
                            }

                        } else {
                            for (let index = 0; index < data.stock.sodtl.length; index++) {
                                if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                    var qty = data.stock.sodtl[index].fn_so_qty - data.stock.sodtl[
                                        index].fn_do_qty;
                                    break;
                                }
                            }

                            // console.log("qty"+qty);

                            if (qty == 0) {
                                return `<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`;
                            } else {
                                return `<button type="button" class="btn btn-primary" onclick="select_stock('${data.fc_barcode}','${data.fc_stockcode}')">Select</button>`;
                            }
                        }

                    }
                }
            ],
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 3, 4, 5, 8]
                },
                {
                    className: 'text-nowrap',
                    targets: [7]
                },
                {
                    visible: false,
                    searchable: true,
                    targets: [2]
                },
            ],
            "initComplete": function() {
                // hidden modal loading
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                $('#modal_inventory').modal('show');

                stock_inventory_table.DataTable().ajax.reload();
                var table = stock_inventory_table.DataTable();
                var rows = table.rows().nodes();
                for (var i = 0; i < rows.length; i++) {
                    var row = $(rows[i]);
                    var fn_quantity = row.find('td:nth-child(4)').text();
                    if (fn_quantity == 0) {
                        table.row(row).remove().draw(false);
                    }
                }
            }
        });

        $('#category').on('change', function() {
            // datatable reload
            stock_inventory_table.DataTable().ajax.reload();
        });

    }

    function select_stock(fc_barcode, fc_stockcode) {
        let stock_name = 'input[name="pname[]'
        // ambil 8 string fc_barcode dari depan
        let fc_barcode_8 = fc_barcode.substring(0, 40);
        var barcodeEncode = window.btoa(fc_barcode);
        // console.log($('').val());
        // console.log(fc_barcode);
        // modal loading
        $('#modal_loading').modal('show');
        $.ajax({
            url: '/apps/delivery-order/cart_stock',
            type: "POST",
            data: {
                'fc_barcode': fc_barcode,
                'fc_stockcode': fc_stockcode,
                'short_barcode': fc_barcode_8,
                'quantity': $(`#quantity_cart_stock_${barcodeEncode}`).val(),
                'bonus_quantity': $(`#bonus_quantity_cart_stock_${barcodeEncode}`).val(),
                'fc_sono': '{{ $data->fc_sono }}',
            },
            dataType: 'JSON',
            success: function(response, textStatus, jQxhr) {
                // modal loading hide
                $('#modal_loading').modal('hide');
                $('.place_alert_cart_stock').empty();
                if (response.status === 200) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    location.reload();
                } else {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    iziToast.error({
                        title: 'Gagal!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(jqXhr, textStatus, errorThrown) {
                $('#modal_loading').modal('hide');
                console.log(errorThrown);
                console.warn(jqXhr.responseText);
            },
        });
    }

    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/delivery-order/datatables-so-detail/" + encode_fc_sono,
            type: 'GET',
        },
        columnDefs: [{
            targets: [8],
            defaultContent: "-",
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
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
                data: 'stock.fc_nameshort',
                defaultContent: '',
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
                data: 'fn_do_bonusqty'
            },
            {
                data: 'fv_description'
            },
            // {
            //     data: 'fm_so_oriprice',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            // {
            //     data: 'fm_so_disc'
            // },
            // {
            //     data: 'total_harga',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            {
                data: null
            },

        ],
        rowCallback: function(row, data) {
            if (data.somst.tempdomst.fc_dostatus == 'D' && data.somst.tempdomst.fc_sostatus == 'P') {
                // kosong
                $('td:eq(9)', row).html(``);
            } else {
                $('td:eq(9)', row).html(`
                    <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${data.stock.fc_stockcode}')"><i class="fa fa-search"></i> Pilih Stock</button>
                `);
            }

            if (data.fn_so_qty > data.fn_do_qty || data.fn_so_bonusqty > data.fn_do_bonusqty) {
                $('td:eq(9)', row).html(
                    `
                        <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${data.stock.fc_stockcode}')"><i class="fa fa-search"></i> Pilih Stock</button>`
                );
            } else {
                $('td:eq(9)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`);
            }
        },
        footerCallback: function(row, data, start, end, display) {

            // jika data[0].somst.tempdomst.fc_sotransport tidak kosong
            if (data[0].somst.tempdomst.fc_sotransport) {
                $("#fc_sotransport").val(data[0].somst.tempdomst.fc_sotransport);
            } else if (data[0].somst.fc_sotransport) {
                $("#fc_sotransport").val(data[0].somst.fc_sotransport);
            } else {
                $("#fc_sotransport").val('');
            }

            if (data[0].somst.tempdomst.fc_memberaddress_loading !== "") {
                $("#fc_memberaddress_loading").val(data[0].somst.tempdomst.fc_memberaddress_loading);
            } else {
                $("#fc_memberaddress_loading").val(data[0].somst.fc_memberaddress_loading1);
            }

            $("#fc_memberaddress_loading").trigger("change");
            $("#fc_sotransport").trigger("change");
            // $("#fm_servpay").trigger("change");
        }
    });

    var deliver_item = $('#deliver-item').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/delivery-order/datatables-do-detail",
            type: 'GET',
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9, 10]
            },
            {
                className: 'text-nowrap',
                targets: [10]
            },
            {
                targets: -1,
                data: null,
                defaultContent: '<button class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i> Hapus Item</button>'
            }
        ],
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
                data: 'invstore.stock.fc_namepack'
            },
            {
                data: 'fn_qty_do'
            },
            {
                data: 'fc_status_bonus_do',
                render: function(data, type, row) {
                    return data === 'T' ? 'Ya' : 'Tidak';
                }
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fc_catnumber',
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
            // {
            //     data: 'fn_price',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            // {
            //     data: 'fn_disc',
            // },
            // {
            //     data: 'fn_value',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            {
                data: 'fc_approval',
                render: function(data, type, row) {
                    return data === 'T' ? 'Ya' : 'Tidak';
                }
            },
            {
                data: null
            }

        ],
        rowCallback: function(row, data) {
            const item_barcode = data.fc_barcode;
            const item_row = data.fn_rownum;
            // kirim 2 parameter di data-id di button hapus
            $('td:eq(10)', row).html(`
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${item_barcode}" data-row="${item_row}"><i class="fa fa-trash"></i> Hapus Item</button>
                `);
            $('td:eq(9)', row).html(`<i class="${data.fc_approval}"></i>`);
            if (data['fc_approval'] == 'F') {
                $('td:eq(9)', row).html('<span class="badge badge-success">NO</span>');
            } else {
                $('td:eq(9)', row).html('<span class="badge badge-warning">YES</span>');
            }

            $('td:eq(5)', row).html(`<i class="${data.fc_status_bonus_do}"></i>`);
            if (data['fc_status_bonus_do'] == 'T') {
                $('td:eq(5)', row).html('<span class="badge badge-warning">Bonus</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Regular</span>');
            }
        },
        initComplete: function() {
            $('table').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var barcode = $(this).data('id');
                // data row
                var row = $(this).data('row');
                // console.log(barcode);
                swal({
                        title: "Anda yakin ingin menghapus item ini?",
                        icon: "warning",
                        buttons: ["Batal", "Hapus"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        // modal loading
                        $('#modal_loading').modal('show');
                        if (willDelete) {
                            $.ajax({
                                url: '/apps/delivery-order/delete-item/' + barcode +
                                    '/' + row,
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    // tutup modal loading
                                    if (response.status == 200) {
                                        setTimeout(function() {
                                            $('#modal_loading').modal(
                                                'hide');
                                        }, 500);
                                        deliver_item.ajax.reload();
                                        tb.ajax.reload();
                                        swal("Item telah dihapus!", {
                                            icon: "success",
                                        });
                                    } else if (response.status == 201) {
                                        setTimeout(function() {
                                            $('#modal_loading').modal(
                                                'hide');
                                        }, 500);
                                        deliver_item.ajax.reload();
                                        tb.ajax.reload();
                                        swal("Item telah dihapus!", {
                                            icon: "success",
                                        });
                                        location.href = response.link;
                                    }
                                },
                                error: function(xhr) {
                                    $('#modal_loading').modal('hide');
                                    swal("Oops!",
                                        "Terjadi kesalahan saat menghapus item.",
                                        "error");
                                }
                            });
                        } else {
                            setTimeout(function() {
                                $('#modal_loading').modal(
                                    'hide');
                            }, 500);
                        }
                    });
            });
        },
        footerCallback: function(row, data, start, end, display) {
            //   console.log('ini footer' + data[0].domst.fn_dodetail)
            // jika data tidak sam dengan 0

            if (data.length !== 0) {
                // count item
                $('#fn_dodetail').html(data[0].domst.fn_dodetail);
                $("#fn_dodetail").trigger("change");

                if (data[0].domst.fm_disctotal) {
                    // fm_disctotal
                    $('#fm_disctotal').html("Rp. " + fungsiRupiah(data[0].domst.fm_disctotal));
                    $("#fm_disctotal").trigger("change");
                }

                if (data[0].domst.fm_netto != null) {
                    // fm_netto
                    $('#fm_netto').html("Rp. " + fungsiRupiah(data[0].domst.fm_netto));
                    $("#fm_netto").trigger("change");
                }

                // fm_servpay
                $('#fm_servpay_calculate').html(
                    // convert dengan RP data[0].domst.fm_servpay
                    $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data[0].domst.fm_servpay)
                );
                $("#fm_servpay_calculate").trigger("change");

                // fm_tax
                if (data[0].domst.fm_tax != null) {
                    $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].domst.fm_tax));
                    $("#fm_tax").trigger("change");
                }

                if (data[0].domst.fm_brutto != null) {
                    $('#fm_brutto').html(
                        // concat dengan RP
                        $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data[0].domst
                            .fm_brutto)
                    )
                    $("#fm_brutto").trigger("change");
                }
                // fm_brutto

            }

        }
    });

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan cancel data Surat Jalan ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/delivery-order/cancel_do',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {

                            if (response.status === 201) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
                            } else {
                                swal(response.message, {
                                    icon: 'error',
                                });
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

    function cek_submit() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/delivery-order/need-approve',
            type: 'GET',
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.approval) {
                    var boldConfirm = "<b>Surat Jalan memerlukan approval.</b>";
                    swal({
                        title: 'Membutuhkan Approval',
                        text: 'Surat Jalan Ini Membutuhkan Approval, Apakah anda ingin melanjutkan?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then((willContinue) => {
                        if (willContinue) {
                            submit_do_noconfirm();
                        }
                    });
                } else {
                    submit_do();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function submit_do() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan submit data Surat Jalan ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willSave) => {
                if (willSave) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/delivery-order/submit_do',
                        type: "POST",
                        data: {
                            'fc_sostatus': 'P',
                            'fc_dostatus': 'D',
                            // 'fd_dodatesysinput' sekarang format datetime
                            'fd_dodatesysinput': moment().format('YYYY-MM-DD HH:mm:ss'),
                        },
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
                            } else {
                                swal(response.message, {
                                    icon: 'error',
                                });
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


    function submit_do_noconfirm() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/delivery-order/submit_do',
            type: "POST",
            data: {
                'fc_sostatus': 'P',
                'fc_dostatus': 'NA',
                'fd_dodatesysinput': moment().format('YYYY-MM-DD HH:mm:ss'),
            },
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 201) {
                    $("#modal").modal('hide');
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    window.location.href = response.link;
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }
</script>
@endsection