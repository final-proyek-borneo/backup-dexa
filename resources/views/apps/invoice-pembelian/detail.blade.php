@extends('partial.app')
@section('title', 'Detail BPB')
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
        <div class="col-12 col-md-4 col-lg-6">
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
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. BPB : {{ $ro_mst->fc_rono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. PO : {{ $ro_mst->fc_pono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SJ : {{ $ro_mst->fc_sjno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. GR : {{ $ro_mst->fc_grno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl PO : {{ date('d-m-Y', strtotime($ro_mst->pomst->fd_podateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima : {{ date('d-m-Y', strtotime($ro_mst->fd_roarivaldate)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Basis Gudang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->warehouse->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_tax_code->fv_description }} ({{ $ro_mst->pomst->supplier->supplier_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
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
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Hutang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fn_supplierAgingAR }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Hutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ $ro_mst->pomst->supplier->fm_supplierAR }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Transportasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_potransport" id="fc_potransport" value="{{ $ro_mst->pomst->fc_potransport }}" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transporter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $ro_mst->fc_transporter }}" readonly>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Penerima</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_receiver" id="fc_receiver" value="{{ $ro_mst->fc_receiver }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Biaya Transport</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $ro_mst->fm_servpay }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fv_description" id="fv_description" value="{{ $ro_mst->fv_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat Penerimaan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_address_loading" id="fc_address_loading" value="{{ $ro_mst->fc_address_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kalkulasi</h4>
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
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Lain-lain</p>
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
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
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
                    <h4>Barang Diterima</h4>
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
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Total</th>
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
        {{-- <a href="/apps/invoice-pembelian/create/{{ base64_encode($fc_rono) }}"><button type="button" class="btn btn-primary">Buat Invoice</button></a> --}}
        <button type="button" class="btn btn-primary" onclick="click_modal_inv_pembelian();">Buat Invoice</button>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_inv_pembelian" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Masa Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/invoice-pembelian/create/store-invoice" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Tanggal Terbit</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="fd_inv_releasedate" data-provide="datepicker" class="form-control" name="fd_inv_releasedate" required>
                                    <input type="hidden" id="fc_suppdocno" class="form-control" value="{{ $ro_mst->pomst->fc_pono }}" name="fc_suppdocno" required>
                                    <input type="hidden" id="fc_child_suppdocno" class="form-control" value="{{ $ro_mst->fc_rono }}" name="fc_child_suppdocno" required>
                                    <input type="hidden" id="fc_entitycode" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_suppliercode }}" name="fc_entitycode" required>
                                    <input type="hidden" id="fn_dodetail" class="form-control" value="{{ $ro_mst->fn_rodetail }}" name="fn_dodetail" required>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Masa Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="number" id="fn_inv_agingday" class="form-control" name="fn_inv_agingday" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Hari
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Estimasi Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="fd_inv_agingdate" class="form-control" name="fd_inv_agingdate" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
    function click_modal_inv_pembelian() {
        $("#modal_inv_pembelian").modal('show');
    }


    $('#fn_inv_agingday').on('input', function() {
        var fd_inv_releasedate = $('#fd_inv_releasedate').val();
        var fn_inv_agingday = parseInt($('#fn_inv_agingday').val());
        if (moment(fd_inv_releasedate, 'MM/DD/YYYY').isValid()) {
            var fd_inv_agingdate = moment(fd_inv_releasedate, 'MM/DD/YYYY').add(fn_inv_agingday, 'days').format('MM/DD/YYYY');
            $('#fd_inv_agingdate').val(fd_inv_agingdate);
        }
    });

    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/master-receiving-order/datatables/ro_detail",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5]
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
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired_date'
            },
            {
                data: 'fn_qty_ro'
            },
            {
                data: 'fn_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fn_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
        ],
        rowCallback: function(row, data) {},
        footerCallback: function(row, data, start, end, display) {
            console.log(data);
            if (data.length != 0) {
                $('#fm_servpay_calculate').html("Rp. " + fungsiRupiah(data[0].romst.fm_servpay));
                $("#fm_servpay_calculate").trigger("change");
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].romst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].romst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].romst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html("Rp. " + fungsiRupiah(data[0].romst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].romst.fn_rodetail);
                $("#count_item").trigger("change");
            }
        }
    });
</script>
@endsection