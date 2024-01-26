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
                    <h4>Master Sales Order</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal :
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</label>
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
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_customer()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
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
                                <button class="btn btn-danger" onclick="click_delete()">Cancel SO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Customer Sales Order</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
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

        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit_noconfirm" action="/apps/sales-order/detail/store-update" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Kode Barang</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_barcode" name="fc_barcode" readonly hidden>
                                        <input type="text" class="form-control" id="fc_stockcode" name="fc_stockcode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="click_modal_stock()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control" name="fn_so_qty" id="fn_so_qty" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Bonus</label>
                                    <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control" name="fn_so_bonusqty" id="fn_so_bonusqty">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5">
                                <div class="form-group required">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_so_price_edit" id="fm_so_price" onkeyup="return onkeyupRupiah(this.id);" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-7">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description" id="fv_description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button type="button" class="btn btn-warning" onclick="click_modal_inventory()"><i class="fa fa-eye"></i> Cek Stock</button>
                                <button class="btn btn-success ml-1">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Calculation</h4>
                </div>
                <div class="card-body" style="height: 190px">
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
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Produk</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Qty Bonus</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Disc.(%)</th>
                                        <th scope="col" class="text-center">Disc.(Rp)</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center justify-content-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <form id="form_submit" action="/apps/sales-order/detail/catatan-save" method="POST">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label for="fv_description_mst">Catatan</label>
                                <div class="input-group">
                                    @if (empty($data->fv_description))
                                    <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description_mst" id="fv_description_mst">
                                    @else
                                    <input type="text" class="form-control" fdprocessedid="hgh1fp" value="{{ $data->fv_description }}" name="fv_description_mst" id="fv_description_mst">
                                    <input type="text" class="form-control" name="fc_sono" id="fc_sono" hidden>
                                    @endif
                                </div>  
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="button text-right">
                                <button type="submit" class="btn btn-warning" id="btn_save">
                                    <i class="fas fa-edit"></i> Simpan
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if ($data->fc_sostatus === 'F')
            <div class="button text-right mb-4">
                <a href="#" class="btn btn-success">Save SO</a>
            </div>
            @else
                @if ($data->fc_sotype == 'Memo Internal')
                    @if ($total != 0 && $data->fv_description != null)
                    <div class="button text-right mb-4">
                        <a href="/apps/sales-order/detail/payment" class="btn btn-success">Pembayaran</a>
                    </div>
                    @else
                    <div class="button text-right mb-4">

                    </div>
                    @endif
                    {{-- <div id="btn-payment" class="button text-right mb-4">
                                
                        </div> --}}
                @else
                <div class="button text-right mb-4">
                    <a href="/apps/sales-order/detail/payment" class="btn btn-success">Pembayaran</a>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_customer" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_customer" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Kode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Tipe Bisnis</th>
                                    <th scope="col" class="text-center">Tipe Cabang</th>
                                    <th scope="col" class="text-center">Status Legal</th>
                                    <th scope="col" class="text-center">NPWP</th>
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

<div class="modal fade" role="dialog" id="modal_stock" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Item</h5>
                <div class="card-header-action">
                    <select data-dismiss="modal" name="category" onchange="" class="form-control select2 required-field" name="Category" id="category">
                        <option value="Semua" selected>Semua&nbsp;&nbsp;</option>
                        <option value="Khusus">Khusus&nbsp;&nbsp;</option>
                    </select>
                </div>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_stock" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Katalog Produk</th>
                                    <th scope="col" class="text-center">Nama Produk</th>
                                    <th scope="col" class="text-center">Brand</th>
                                    <th scope="col" class="text-center">Sub Group</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="click_category" class="btn btn-secondary" onclick="clear_category()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Ketersediaan Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Brand</th>
                                    <th scope="col" class="text-center">Sub Group</th>
                                    <th scope="col" class="text-center">Tipe Stock</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
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
    $(document).ready(function() {
        // Format mata uang.
        $('.rupiah').mask('000.000.000', {
            reverse: true
        });
    })
    $(document).ready(function() {
        $('.place_detail').attr('hidden', false);
    })

    function click_modal_customer() {
        $('#modal_customer').modal('show');
        table_customer();
    }

    function clear_category() {
        $('#category').val('Semua').trigger('change');
    }

    function click_modal_stock() {
        $('#modal_stock').modal('show');
        table_stock();
    }

    function click_modal_inventory() {
        $('#modal_inventory').modal('show');
        table_inventory();
    }

    function onchange_member_code(fc_membercode) {
        $.ajax({
            url: "/master/data-customer-first/" + fc_membercode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $('#fc_membertaxcode').val(data.member_tax_code.fc_kode);
                    $('#fc_membertaxcode_view').val(data.member_tax_code.fv_description);
                    $('#fc_memberaddress_loading1').val(data.fc_memberaddress_loading1);
                    $('#fc_memberaddress_loading2').val(data.fc_memberaddress_loading2);
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

    function table_customer() {
        var tb_customer = $('#tb_customer').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/master/get-data-customer-so-datatables/" + $('#fc_branch').val(),
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 7]
            }, ],
            columns: [{
                    data: 'fc_membercode'
                },
                {
                    data: 'fc_membername1'
                },
                {
                    data: 'fc_memberaddress1'
                },
                {
                    data: 'member_type_business.fv_description'
                },
                {
                    data: 'member_typebranch.fv_description'
                },
                {
                    data: 'member_legal_status.fv_description'
                },
                {
                    data: 'fc_membernpwp_no'
                },
                {
                    data: 'fc_membernpwp_no'
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_customer('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    
    function table_stock() {
        var tipe_bisnis = "{{ $data->customer->member_type_business->fv_description }}";
        var tb_stock = $('#tb_stock').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/master/get-data-stock-so-datatables",
                type: 'GET',
                data: function(d) {
                    d.category = $('#category').val();
                },
                dataSrc: function(data) {
                    data.data.forEach(function(row) {
                        switch (tipe_bisnis) {
                            case 'PERSONAL':
                                row.fm_price_default = row.fm_price_enduser;
                                break;
                            case 'DISTRIBUTOR':
                                row.fm_price_default = row.fm_price_distributor;
                                break;
                            case 'RETAIL':
                                row.fm_price_default = row.fm_price_default;
                                break;
                            case 'RUMAH SAKIT':
                                row.fm_price_default = row.fm_price_project;
                                break;
                            case 'END USER':
                                row.fm_price_default = row.fm_price_enduser;
                                break;
                            default:
                                row.fm_price_default = "";
                        }
                    });
                    return data.data;
                }

            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 5, 7]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'fc_namelong',
                    // render: function(data, type, row) {
                    //     if (!data) {
                    //         return row.stock.fc_namelong;
                    //     }
                    //     return data;
                    // },
                    // searchable: true,
                },
                {
                    data: 'fc_brand',
                    // render: function(data, type, row) {
                    //     if ($('#category').val() === 'Semua') {
                    //         if (row && row.fc_brand) {
                    //             return row.fc_brand;
                    //         } else {
                    //             return data;
                    //         }
                    //     } else if ($('#category').val() === 'Khusus') {
                    //         if (row.fc_brand === undefined && row.stock && row.stock.fc_brand) {
                    //             return row.stock.fc_brand;
                    //         } else {
                    //             return data;
                    //         }
                    //     } else {
                    //         return data;
                    //     }
                    // }
                },
                {
                    data: 'fc_subgroup',
                    // render: function(data, type, row) {
                    //     if ($('#category').val() === 'Semua') {
                    //         if (row && row.fc_subgroup) {
                    //             return row.fc_subgroup;
                    //         } else {
                    //             return data;
                    //         }
                    //     } else if ($('#category').val() === 'Khusus') {
                    //         if (row.fc_subgroup === undefined && row.stock && row.stock.fc_subgroup) {
                    //             return row.stock.fc_subgroup;
                    //         } else {
                    //             return data;
                    //         }
                    //     } else {
                    //         return data;
                    //     }
                    // }
                },
                {
                    data: 'namepack.fv_description',
                    // render: function(data, type, row) {
                    //     if (!data) {
                    //         return row.stock.namepack.fv_description;
                    //     }
                    //     return data;
                    // }
                },
                {
                    data: 'fm_price_default',
                    render: function(data, type, row) {
                        if ($('#category').val() == 'Khusus') {
                            if (row.fm_price_customer == undefined) {
                                return data
                            } else {
                                return row.fm_price_customer.toLocaleString('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                });
                            }

                        } else {
                            return data.toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            });
                        }
                    }
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                // console.log(data)
                if (!data.fc_nameshort) {
                    data.fc_nameshort = data.stock.fc_nameshort;
                }

                if ($('#category').val() == 'Khusus') {
                    $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="detail_stock_customer('${data.fc_stockcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                } else {
                    $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="detail_stock('${data.fc_stockcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                }

            },
        });
        // Reload datatable when category is changed
        $('#category').on('change', function() {
            var url = $(this).val() === 'Semua' ? '/master/get-data-stock-so-datatables' :
                '/master/get-data-stock_customer-so-datatables';
            tb_stock.ajax.url(url).load();
        });
    }

    function table_inventory() {
        // var fc_sono = "{{ $data->fc_sono }}";
        // var fc_sono_encode = window.btoa(fc_sono);
        var tb_inventory = $('#tb_inventory').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [7, 'asc']
            ],
            ajax: {
                url: "/apps/sales-order/detail/datatables-inventory",
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5]
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
                    data: 'stock.fc_brand'
                },
                {
                    data: 'stock.fc_subgroup'
                },
                {
                    data: 'stock.fc_typestock2'
                },
                {
                    data: 'stock.fc_namepack'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });
    }

    function detail_stock(id) {
        // console.log($id)
        var fc_stockcode = window.btoa(id)
        $.ajax({
            url: "/master/get-data-where-field-id-first/Stock/fc_stockcode/" + fc_stockcode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;
                // console.log(data.tempsodetail[0].fm_so_price);
                var tipe_bisnis = "{{ $data->customer->member_type_business->fc_kode }}";
                if (tipe_bisnis == 'DISTRIBUTOR') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_distributor));
                } else if (tipe_bisnis == 'RETAIL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_default));
                } else if (tipe_bisnis == 'HOSPITAL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_project));
                } else if (tipe_bisnis == 'PERSONAL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_enduser));
                } else if (tipe_bisnis == 'ENDUSER') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_enduser));
                } else {
                    $('#fm_so_price').val(fungsiRupiah(""));
                }
                $('#fc_stockcode').val(data.fc_stockcode);
                $('#fc_barcode').val(data.fc_barcode);
                $('#category').val('Semua').trigger('change');
                $("#modal_stock").modal('hide');
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

    function detail_stock_customer(id) {
        // console.log(id)
        var fc_stockcode = window.btoa(id);
        // console.log(fc_stockcode)
        $.ajax({
            url: "/master/get-data-where-field-id-first-so-khusus/StockCustomer/fc_stockcode/" + fc_stockcode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;
                // console.log(data.tempsodetail[0].fm_so_price);
                var tipe_bisnis = "{{ $data->customer->member_type_business->fc_kode }}";
                if (tipe_bisnis == 'DISTRIBUTOR') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_customer));
                } else if (tipe_bisnis == 'RETAIL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_customer));
                } else if (tipe_bisnis == 'HOSPITAL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_customer));
                } else if (tipe_bisnis == 'PERSONAL') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_customer));
                } else if (tipe_bisnis == 'ENDUSER') {
                    $('#fm_so_price').val(fungsiRupiah(data.fm_price_customer));
                } else {
                    $('#fm_so_price').val(fungsiRupiah(""));
                }
                $('#fc_stockcode').val(data.fc_stockcode);
                $('#fc_barcode').val(data.fc_barcode);
                $('#category').val('Semua').trigger('change');
                $("#modal_stock").modal('hide');
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

    function detail_customer($id) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/data-customer-first/" + $id,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;
                $('#modal_loading').modal('hide');
                $("#modal_customer").modal('hide');
                Object.keys(data).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    elem_name.val(data[key]);
                });

                $('#fc_member_branchtype_desc').val(data.member_typebranch.fv_description);
                $('#fc_membertypebusiness_desc').val(data.member_type_business.fv_description);
                $('#fc_memberlegalstatus_desc').val(data.member_legal_status.fv_description);
                $('#status_pkp').val(data.member_tax_code.fv_description);

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

    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/sales-order/detail/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 2, 4, 5, 6, 7, 8, 9, 10]
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
                data: 'fm_so_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fm_so_disc'
            },
            {
                data: 'fm_so_disc'
            },
            {
                data: 'fn_so_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: '-',
            },
            {
                data: null,
            },


        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/sales-order/detail/delete/" + data.fc_sono + '/' + data.fn_sorownum;

            $('td:eq(11)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action_dtl('${url_delete}','SO Detail')"><i class="fa fa-trash"> </i> Hapus Item</button>
                `);
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
                $('#fm_servpay').html("Rp. " + fungsiRupiah(data[0].tempsomst.fm_servpay));
                $("#fm_servpay").trigger("change");
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].tempsomst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].tempsomst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].tempsomst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_so_disc').html("Rp. " + fungsiRupiah(data[0].tempsomst.fn_disctotal));
                $("#fm_so_disc").trigger("change");
                $('#count_item').html(data[0].tempsomst.fn_sodetail);
                $("#count_item").trigger("change");
            }
        }
    });

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan menghapus data SO ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/sales-order/delete',
                        type: "DELETE",
                        dataType: "JSON",
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

    $('#form_submit_noconfirm').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_noconfirm').attr('action'),
            type: $('#form_submit_noconfirm').attr('method'),
            data: $('#form_submit_noconfirm').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    $("#form_submit_noconfirm")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 201) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                    location.href = location.href;
                } else if (response.status == 203) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                } else if (response.status == 300) {
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
    });

    // sementara
    function save_so() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan menyimpan data SO ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/sales-order/detail/lock',
                        type: "GET",
                        dataType: "JSON",
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
</script>
@endsection