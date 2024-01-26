@extends('partial.app')
@section('title', 'Purchase Order')
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
            display:inline;
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
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    {{-- <form id="form_submit" action="/apps/purchase-order/store-update" method="POST" autocomplete="off"> --}}
                    <div class="collapse" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" name="" id=""
                                            value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>PO Type</label>
                                        <input type="text" class="form-control" value="{{ $data->fc_potype }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Supplier Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode"
                                                name="fc_membercode" value="{{ $data->fc_suppliercode }}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" disabled onclick="click_modal_supplier()"
                                                    type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Status PKP</label>
                                        {{-- <select class="form-control select2 select2-hidden-accessible" name="" id="" tabindex="-1" aria-hidden="true">
                                        <option value="T">YES</option>
                                        <option selected="" value="F">NO</option>
                                    </select> --}}
                                        <input type="text" class="form-control" style="font-size: 12px"
                                            value="{{ $data->supplier->supplier_tax_code->fv_description }} ({{ $data->supplier->supplier_tax_code->fc_action }}%)"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-danger" onclick="click_delete()">Cancel PO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Supplier</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->fc_supplierNPWP }}" name="fc_membernpwp_no"
                                            id="fc_membernpwp_no" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->supplier_typebranch->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->supplier_type_business->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->fc_suppliername1 }}" name="fc_suppliername1"
                                            id="fc_suppliername1" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->fc_supplierphone1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Masa Hutang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->fn_supplierAgingAR }} Hari" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->supplier_legal_status->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Hutang</label>
                                        <input type="text" class="form-control"
                                            value="Rp. {{ number_format( $data->supplier->fm_supplierAR,0,',','.') }}" readonly>
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
                        <form id="add_item" action="/apps/purchase-order/detail/store-update" method="POST"
                            autocomplete="off">
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
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control format-rp" name="fm_po_price" id="fm_po_price" 
                                                onkeyup="return onkeyupRupiah(this.id);" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group required">
                                        <label>Qty</label>
                                        <div class="form-group">
                                            <input type="number" min="0" class="form-control" name="fn_po_qty"
                                                id="fn_po_qty" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" fdprocessedid="hgh1fp"
                                                name="fv_description" id="fv_description">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label>Kedatangan</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                                <input type="text" id="fd_stockarrived" class="form-control datepicker" name="fd_stockarrived">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Add Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Prediksi Tagihan</h4>
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
                                <div class="d-flex" style="gap: 5px; white-space: pre" >
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
                                <table class="table table-striped" id="po_detail" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode Barang</th>
                                            <th scope="col" class="text-center">Nama Produk</th>
                                            <th scope="col" class="text-center">Satuan</th>
                                            <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Disc</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center">Kedatangan</th>
                                            <th scope="col" class="text-center">Catatan</th>
                                            <th scope="col" class="text-center justify-content-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit" action="/apps/purchase-order/detail/received-update/{{ $data->fc_pono }}"
                            method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group required">
                                        <label>Tanggal PO</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            @if (empty($data->fd_podateinputuser))
                                                <input type="text" id="fd_podateinputuser"
                                                    class="form-control datepicker" name="fd_podateinputuser" required>
                                            @else
                                                <input type="text" id="fd_podateinputuser"
                                                    class="form-control datepicker" name="fd_podateinputuser"
                                                    value="{{ $data->fd_podateinputuser }}" required>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group required">
                                        <label>Masa</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            @if (empty($data->fd_poexpired) || empty($data->fd_podateinputuser))
                                                <input type="number" id="fn_inv_agingday" class="form-control"
                                                    name="fn_inv_agingday" required>
                                            @else
                                                @php
                                                    $fn_inv_aging_day = strtotime($data->fd_poexpired) - strtotime($data->fd_podateinputuser);
                                                @endphp
                                                <input type="number" id="fn_inv_agingday" class="form-control"
                                                    name="fn_inv_agingday"
                                                    value="{{ round(abs($fn_inv_aging_day / (60 * 60 * 24))) }}" required>
                                            @endif
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Hari
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label>Estimasi Barang Datang</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            @if (empty($data->fd_poexpired))
                                                <input type="text" id="fd_poexpired" class="form-control"
                                                    name="fd_poexpired" required readonly>
                                            @else
                                                <input type="text" id="fd_poexpired" class="form-control"
                                                    name="fd_poexpired" value="{{ $data->fd_poexpired }}" required
                                                    readonly>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <label>Catatan</label>
                                    <div class="form-group">
                                        @if (empty($data->fv_description))
                                            <input type="text" id="fv_description" class="form-control"
                                                name="fv_description">
                                        @else
                                            <input type="text" id="fv_description" class="form-control"
                                                name="fv_description" value="{{ $data->fv_description }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group required">
                                        <label>Transport</label>
                                        @if (empty($data->fc_potransport))
                                            <select class="form-control select2" name="fc_potransport"
                                                id="fc_potransport" required>
                                                <option value="" selected disabled>- Pilih Transport -</option>
                                                <option value="By Dexa">By Dexa</option>
                                                <option value="By Paket">By Paket</option>
                                                <option value="By Supplier">By Supplier</option>
                                            </select>
                                        @else
                                            <select class="form-control select2" name="fc_potransport"
                                                id="fc_potransport">
                                                <option value="{{ $data->fc_potransport }}" selected>
                                                    {{ $data->fc_potransport }}
                                                </option>
                                                <option value="By Dexa">By Dexa</option>
                                                <option value="By Paket">By Paket</option>
                                                <option value="By Supplier">By Supplier</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label>Perkiraan Penanganan</label>
                                        <div class="input-group format-rp">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            @if ($data->fm_servpay == 0)
                                                <input type="text" class="form-control format-rp" name="fm_servpay"
                                                    id="fm_servpay_po" value="0" fdprocessedid="hgh1fp"
                                                    onkeyup="return onkeyupRupiah(this.id);" required>
                                            @else
                                                <input type="text" class="form-control format-rp" name="fm_servpay"
                                                    id="fm_servpay_po" onkeyup="return onkeyupRupiah(this.id);"
                                                    value="{{ number_format($data->fm_servpay,0,',','.') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group required">
                                    <label>Dikirim Ke</label>
                                        @if (empty($data->fc_membername1))
                                            <select class="form-control select2" name="fc_membername1"
                                            id="fc_membername1" required></select>
                                        @else
                                            <select class="form-control select2" name="fc_membername1"
                                                id="fc_membername1">
                                                <option value="{{ $data->fc_membername1 }}" selected>
                                                    {{ $data->fc_membername1 }}
                                                </option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <label>Alamat Tujuan</label>
                                    <div class="form-group">
                                        @if (empty($data->fc_address_loading1))
                                            <input type="text" id="fc_memberaddress_loading1" class="form-control"
                                                name="fc_memberaddress_loading1" readonly>
                                        @else
                                            <input type="text" id="fc_memberaddress_loading1" class="form-control"
                                                name="fc_memberaddress_loading1" value="{{ $data->fc_address_loading1 }}"
                                                readonly>
                                        @endif
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-md-12 col-lg-3">
                                            <label>Alamat Tujuan</label>
                                            <div class="form-group">
                                                @if (empty($data->fc_address_loading1))
    <input type="text" id="fc_address_loading1" class="form-control" name="fc_address_loading1" value="Jl. Raya Jemursari No.329-331, Sidosermo, Kec. Wonocolo, Kota SBY, Jawa Timur 60297" required>
@else
    <input type="text" id="fc_address_loading1" class="form-control" name="fc_address_loading1" value="{{ $data->fc_address_loading1 }}" required>
    @endif
                                            </div>
                                        </div> -->
                            </div>
                            <div class="text-right">
                                @if ($data->fm_servpay == 0 && empty($data->fc_potransport))
                                    <button type="submit" class="btn btn-primary">Save</button>
                                @else
                                    <button type="submit" class="btn btn-warning">Edit</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="button text-right mb-4">
                    @if ($data->fc_postatus === 'F')
                        <button id="submit_button" class="btn btn-success" disabled>Submit</button>
                    @else
                        <button id="submit_button" class="btn btn-success">Submit</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_supplier" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_supplier" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Kode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Tipe Bisnis</th>
                                    <th scope="col" class="text-center">Tipe Cabang</th>
                                    <th scope="col" class="text-center">Legalitas</th>
                                    <th scope="col" class="text-center">NPWP</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                            <option value="Semua">Semua&nbsp;&nbsp;</option>
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
                    <button type="button" class="btn btn-secondary" onclick="clear_category()" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        $(document).ready(function() {
            // get_data_supplier();
            $('.place_detail').attr('hidden', false);
            get_data_member_name();
        })

        function click_modal_supplier() {
            $('#modal_supplier').modal('show');
            table_supplier();
        }

        function click_modal_stock() {
            $('#modal_stock').modal('show');
            table_stock();
        }

        function get_data_member_name() {
            $("#modal_loading").modal('show');

            var staticAddress = [{
                text: 'PT Dexa Arfindo Pratama',
                value: 'Jl. Raya Jemursari No.329-331, Sidosermo, Kec. Wonocolo, Kota SBY, Jawa Timur 60297'
            }, ]
            $.ajax({
                url: "/master/get-data-all/Customer",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status === 200) {
                        var data = response.data;
                        // console.log(data);
                        $("#fc_membername1").empty();
                        $("#fc_membername1").append(`<option value="" selected readonly>-- Pilih --</option>`);
                        for (var i = 0; i < staticAddress.length; i++) {
                            $("#fc_membername1").append(
                                `<option value="${staticAddress[i].text}">${staticAddress[i].text}</option>`
                            );
                        }
                        for (var i = 0; i < data.length; i++) {
                            $("#fc_membername1").append(
                                `<option value="${data[i].fc_membername1}">${data[i].fc_membername1}</option>`
                            );
                        }
                        
                        var fc_destination = "{{ $data->fc_destination }}";
                        if( fc_destination != ''){
                            $("#fc_membername1").val('{{ $data->fc_destination }}');
                        }
                        
                        // $("#fc_membername1").val(data[i].fc_membername1)
                        // data[i].fc_membername1

                        $("#fc_membername1").change(function() {
                            var fc_membername1 = $(this).val();
                            var data = response.data;
                            // console.log(data);
                            for (var i = 0; i < data.length; i++) {
                                if (data[i].fc_membername1 === fc_membername1) {
                                    $('#fc_memberaddress_loading1').val(data[i]
                                        .fc_memberaddress_loading1);
                                } else {
                                    for (let index = 0; index < staticAddress.length; index++) {
                                        if (staticAddress[index].text === fc_membername1) {
                                            $('#fc_memberaddress_loading1').val(staticAddress[index]
                                                .value);
                                        }
                                    }
                                }
                            }


                        });
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

        function table_supplier() {
            var tb = $('#tb_supplier').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "/apps/purchase-order/get-data-supplier-po-datatables/" + $('#fc_branch').val(),
                    type: 'GET'
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                }, ],
                columns: [{
                        data: 'fc_suppliercode',
                    },
                    {
                        data: 'fc_suppliername1'
                    },
                    {
                        data: 'fc_supplier_npwpaddress1'
                    },
                    {
                        data: 'fc_suppliertypebusiness'
                    },
                    {
                        data: 'fc_branchtype'
                    },
                    {
                        data: 'fc_supplierlegalstatus'
                    },
                    {
                        data: 'fc_supplierNPWP'
                    },
                    {
                        data: null
                    },
                ],
                rowCallback: function(row, data) {
                    $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_supplier('${data.fc_suppliercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                }
            });
        }

        function table_stock() {
            var fc_suppliercode = "{{ $data->fc_suppliercode }}";
            var fc_suppliercode_encode = window.btoa(fc_suppliercode);
            console.log(fc_suppliercode_encode);
            var tipe_bisnis = "{{ $data->supplier->supplier_type_business->fv_description }}";
            var tb_stock = $('#tb_stock').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "/master/get-data-stock-po-datatables",
                    type: 'GET',
                    data: function(d) {
                    d.category = $('#category').val();
                 },
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 5]
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
                        data: 'fc_namelong',
                        render: function(data, type, row) {
                            if (!data) {
                                return row.stock.fc_namelong;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'fc_brand',
                        render: function(data, type, row) {
                          if ($('#category').val() === 'Semua') {
                                if (row.stock && row.stock.fc_brand) {
                                    return row.stock.fc_brand;
                                } else {
                                    return data;
                                }
                            } else if ($('#category').val() === 'Khusus') {
                                if (row.fc_brand === undefined && row.stock && row.stock.fc_brand) {
                                    return row.stock.fc_brand;
                                } else {
                                    return data;
                                }
                            } else {
                                return data;
                            }
                            }
                    },
                    {
                        data: 'fc_subgroup',
                        render: function(data, type, row) {
                          if ($('#category').val() === 'Semua') {
                            if (row.stock && row.stock.fc_subgroup) {
                                return row.stock.fc_subgroup;
                            } else {
                                return data;
                            }
                        } else if ($('#category').val() === 'Khusus') {
                            if (row.fc_subgroup === undefined && row.stock && row.stock.fc_subgroup) {
                                return row.stock.fc_subgroup;
                            } else {
                                return data;
                            }
                        } else {
                            return data;
                        }
                        }
                    },
                    {
                        data: 'namepack.fv_description',
                        render: function(data, type, row) {
                            if ($('#category').val() === 'Semua') {
                                if (row.stock && row.stock.namepack && row.stock.namepack.fv_description) {
                                    return row.stock.namepack.fv_description;
                                } else {
                                    return data;
                                }
                            } else if ($('#category').val() === 'Khusus') {
                                if (row.namepack && row.namepack.fv_description) {
                                    return row.namepack.fv_description;
                                } else if (row.stock && row.stock.namepack && row.stock.namepack.fv_description) {
                                    return row.stock.namepack.fv_description;
                                } else {
                                    return data;
                                }
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'fm_purchase',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
                    },
                    {
                        data: 'fc_stockcode'
                    },
                ],
                rowCallback: function(row, data) {
                    $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="detail_stock('${data.fc_stockcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                }
            });

            $('#category').on('change', function() {
                var url = $(this).val() === 'Semua' ? '/master/get-data-stock-po-datatables' :
                    '/master/get-data-stock_supplier-po-datatables/' + fc_suppliercode_encode;
                tb_stock.ajax.url(url).load();
        });
        }

        function clear_category(){
            $('#category').val('Semua').trigger('change');
        }

        function detail_stock($id) {
            var fc_stockcode = window.btoa($id)
            console.log($id)
            $.ajax({
                url: "/master/get-data-where-field-id-first/Stock/fc_stockcode/" + fc_stockcode,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    var data = response.data;
                    $('#fm_po_price').val(fungsiRupiah(data.fm_purchase))
                    $('#fc_stockcode').val(data.fc_stockcode);
                    $('#fc_barcode').val(data.fc_barcode);

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

        function detail_supplier($id) {
            $.ajax({
                url: "/master/data-supplier-first/" + $id,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    // console.log(data);
                    var data = response.data;
                    // console.log(data);
                    $("#modal_supplier").modal('hide');
                    Object.keys(data).forEach(function(key) {
                        var elem_name = $('[name=' + key + ']');
                        elem_name.val(data[key]);
                    });

                    $('#fn_supplierAgingAR').val(data.fn_supplierAgingAR);
                    $('#fn_supplierAR').val(data.fn_supplierAR);
                    $('#fc_branchtype_desc').val(data.supplier_typebranch.fv_description);
                    $('#fc_suppliertypebusiness_desc').val(data.supplier_type_business.fv_description);
                    $('#fc_supplierlegalstatus_desc').val(data.supplier_legal_status.fv_description);
                    $('#status_pkp').val(data.supplier_tax_code.fv_description);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }

        // tabel po detail
        var tb = $('#po_detail').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/purchase-order/detail/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8]
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
                    data: 'fc_namelong'
                },
                {
                    data: 'fc_namepack'
                },
                {
                    data: 'fm_po_price',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp')
                },
                {
                    data: 'fm_po_disc',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp')
                },
                {
                    data: 'fn_po_qty',
                },
                {
                    data: 'fm_po_value',
                    render: $.fn.dataTable.render.number('.', ',', 0, 'Rp')
                },
                {
                    data: 'fd_stockarrived'
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
                // console.log(data.fc_pono);
                // console.log(data.fn_porownum);
                var url_delete = "/apps/purchase-order/detail/delete/" + data.fc_pono + '/' + data.fn_porownum;

                $('td:eq(10)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','Purchase Order Detail')"><i class="fa fa-trash"> </i> Hapus Item</button>
                `);
            },
            footerCallback: function(row, data, start, end, display) {

                let count_quantity = 0;
                let total_harga = 0;
                let grand_total = 0;

                for (var i = 0; i < data.length; i++) {
                    count_quantity += data[i].fn_po_qty;
                    total_harga += data[i].total_harga;
                    grand_total += data[i].total_harga;
                }

                $('#count_quantity').html(count_quantity);
                // $('#total_harga').html(fungsiRupiah(grand_total));
                // $('#grand_total').html("Rp. " + fungsiRupiah(total_harga));
                // servpay
                if (data.length != 0) {
                    $('#fm_servpay').html("Rp. " + fungsiRupiah(data[0].temppomst.fm_servpay));
                    $("#fm_servpay").trigger("change");
                    $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].temppomst.fm_tax));
                    $("#fm_tax").trigger("change");
                    $('#grand_total').html("Rp. " + fungsiRupiah(data[0].temppomst.fm_brutto));
                    $("#grand_total").trigger("change");
                    $('#total_harga').html("Rp. " + fungsiRupiah(data[0].temppomst.fm_netto));
                    $("#total_harga").trigger("change");
                    $('#fm_so_disc').html("Rp. " + fungsiRupiah(data[0].temppomst.fn_disctotal));
                    $("#fm_so_disc").trigger("change");
                    $('#count_item').html(data[0].temppomst.fn_podetail);
                    $("#count_item").trigger("change");
                }

                $('#fn_inv_agingday').on('input', function() {
                    var fd_podateinputuser = $('#fd_podateinputuser').val();
                    var fn_inv_agingday = $('#fn_inv_agingday').val();
                    var fd_poexpired = moment(fd_podateinputuser, 'YYYY-MM-DD').add(fn_inv_agingday,
                        'days').format('YYYY-MM-DD');
                    $('#fd_poexpired').val(fd_poexpired);
                });
            }

        });
        
        function click_delete() {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan menghapus data Purchase Order ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/purchase-order/delete',
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
                                    tb.ajax.reload(null, false);
                                } else if (response.status === 200) {
                                    $("#modal").modal('hide');
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    // arahkan ke link
                                    location.href = response.link;
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

        $('#add_item').on('submit', function(e) {
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
                url: $('#add_item').attr('action'),
                type: $('#add_item').attr('method'),
                data: $('#add_item').serialize(),
                success: function(response) {

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status == 200) {
                        // swal(response.message, { icon: 'success', });
                        $("#modal").modal('hide');
                        $("#add_item")[0].reset();
                        // reset_all_select();
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

        $("#submit_button").click(function() {

            swal({
                title: "Apakah anda yakin?",
                text: "Apakah anda yakin akan menyimpan data PO ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Proceed with submission
                    var data = {
                        'fd_podateinputuser': $('#fd_podateinputuser').val(),
                        'fd_poexpired': $('#fd_poexpired').val(),
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/apps/purchase-order/detail/submit',
                        data: data,
                        success: function(response) {
                            // tampilkan modal section alert
                            console.log(response.status);
                            if (response.status == 300 || response.status == 301) {
                                $('#modal_loading').modal('hide');
                                swal(response.message, {
                                    icon: 'error',
                                });
                            } else {
                                $('#modal_loading').modal('hide');
                                // tampilkan flas message bootstrap id alert-bayar
                                swal(response.message, {
                                    icon: 'success',
                                });
                                // redirect ke halaman sales order
                                // hapus local storage
                                setTimeout(function() {
                                    window.location.href = "/apps/purchase-order";
                                }, 500);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#modal_loading').modal('hide');
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                .responseText + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                } else {
                    // Do nothing
                }
            });
        });
    </script>
@endsection
