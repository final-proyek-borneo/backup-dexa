@extends('partial.app')
@section('title', 'Daftar Invoice')
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

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Invoice</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="incoming-tab" data-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="true">Hutang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="outgoing-tab" data-toggle="tab" href="#outgoing" role="tab" aria-controls="outgoing" aria-selected="false">Piutang</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                            <div class="text-right mb-3">

                                @if ($fc_rono)
                                <a href="/apps/master-invoice/create/{{ base64_encode($fc_rono) }}" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambah
                                    Invoice</a>
                                @else
                                <button type="button" class="btn btn-success" onclick="click_modal_add_invoice()"><i class="fa fa-plus mr-1"></i> Tambah
                                    Invoice</button>
                                @endif
                                {{-- @dd($fc_rono) --}}


                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_incoming_invoice" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Invoice</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Tgl Berakhir</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 25%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="outgoing" role="tabpanel" aria-labelledby="outgoing-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_outgoing_invoice" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Invoice</th>
                                            <th scope="col" class="text-center text-nowrap">No. Surat Jalan</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Tgl Berakhir</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 25%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal_update_invoice_do" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Update Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_edit" action="/apps/master-invoice/update-invoice-outgoing" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Informasi Umum</h4>
                                </div>
                                {{-- <input type="text" id="" value="" hidden> --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Tgl Rilis Invoice :</label>
                                                <span id="fd_inv_releasedate_outgoing"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>No. Invoice :</label>
                                                <span id="fc_invno_outgoing"></span>
                                                <input type="text" name="fc_invno_outgoing" id="fc_invno_input_outgoing" hidden>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>No. Surat Jalan :</label>
                                                <span id="fc_dono_outgoing"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <input type="text" id="fc_membernpwp_no_outgoing" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" id="fc_membername1_outgoing" name="fc_membername1_outgoing" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 place_detail">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Calculation</h4>
                                </div>
                                <div class="card-body" style="height: 215px">
                                    <div class="d-flex border-bottom">
                                        <div class="flex-row-item" style="margin-right: 30px">
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_invdetail_outgoing">0,00</p>
                                            </div>

                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal_outgoing">0,00</p>
                                            </div>

                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto_outgoing">0,00</p>
                                            </div>
                                        </div>
                                        <div class="flex-row-item">
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_outgoing">0,00</p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax_outgoing">0,00</p>
                                            </div>
                                            <input type="text" name="fm_tax" id="fm_tax_input" hidden>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto_outgoing">Rp. 0,00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-row-item" style="margin-right: 30px">
                                            <div class="d-flex">
                                                <p class="flex-row-item"></p>
                                                <p class="flex-row-item text-right"></p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Terbayar</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_paidvalue_outgoing">0,00</p>
                                            </div>
                                        </div>
                                        <div class="flex-row-item">
                                            <div class="d-flex">
                                                <p class="flex-row-item"></p>
                                                <p class="flex-row-item text-right"></p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">SISA</p>
                                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="sisa_outgoing">Rp. 0,00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Tanggal Berakhir</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_inv_agingdate_outgoing" name="fd_inv_agingdate_outgoing" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Tgl Pembayaran</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>

                                    <input type="text" id="fd_datepayment" class="form-control datepicker" name="fd_datepayment" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select class="form-control select2 " name="fc_kode" id="fc_kode_outgoing" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach ($kode_bayar as $kode)
                                    <option value="{{ $kode->fc_kode }}">{{ $kode->fc_kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>No. Rekening</label>
                                <input type="text" id="fc_bankaccount_outgoing" class="form-control" name="fc_bankaccount_outgoing" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Nama Pembayar</label>
                                <input type="text" id="fc_payername_outgoing" class="form-control" name="fc_payername" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group format-rp">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" id="fm_valuepayment_outgoing" class="form-control" name="fm_valuepayment" onkeyup="return onkeyupRupiah(this.id)" required>
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

<div class="modal fade" role="dialog" id="modal_update_invoice_ro" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Update Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/master-invoice/update-invoice-incoming" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Informasi Umum</h4>
                                </div>
                                <input type="text" id="" value="" hidden>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Tgl Rilis Invoice :</label>
                                                <span id="fd_inv_releasedate_incoming"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>No. Invoice :</label>
                                                <span id="fc_invno_incoming"></span>
                                                <input type="text" name="fc_invno_incoming" id="fc_invno_input" hidden>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>No. BPB :</label>
                                                <span id="fc_rono_incoming"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <input type="text" id="fc_supplierNPWP" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input id="fc_suppliername1" name="fc_suppliername1" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 place_detail">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Calculation</h4>
                                </div>
                                <div class="card-body" style="height: 215px">
                                    <div class="d-flex border-bottom">
                                        <div class="flex-row-item" style="margin-right: 30px">
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_invdetail_incoming">0,00</p>
                                            </div>

                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal_incoming">0,00</p>
                                            </div>

                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto_incoming">0,00</p>
                                            </div>
                                        </div>
                                        <div class="flex-row-item">
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_incoming">0,00</p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax_incoming">0,00</p>
                                            </div>
                                            <input type="text" name="fm_tax" id="fm_tax_input" hidden>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto_incoming">Rp. 0,00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-row-item" style="margin-right: 30px">
                                            <div class="d-flex">
                                                <p class="flex-row-item"></p>
                                                <p class="flex-row-item text-right"></p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-size: medium">Terbayar</p>
                                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_paidvalue_incoming">0,00</p>
                                            </div>
                                        </div>
                                        <div class="flex-row-item">
                                            <div class="d-flex">
                                                <p class="flex-row-item"></p>
                                                <p class="flex-row-item text-right"></p>
                                            </div>
                                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">SISA</p>
                                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="sisa">Rp. 0,00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Tanggal Berakhir</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_inv_agingdate" name="fd_inv_agingdate" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Tgl Pembayaran</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>

                                    <input type="text" id="fd_datepayment" class="form-control datepicker" name="fd_datepayment" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select class="form-control select2 " name="fc_kode_incoming" id="fc_kode_incoming" required>
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach ($kode_bayar as $kode)
                                    <option value="{{ $kode->fc_kode }}">{{ $kode->fc_kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>No. Rekening</label>
                                <input type="text" id="fc_bankaccount_incoming" class="form-control" name="fc_bankaccount_incoming" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Nama Pembayar</label>
                                <input type="text" id="fc_payername" class="form-control" name="fc_payername" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group format-rp">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" id="fm_valuepayment_incoming" class="form-control" name="fm_valuepayment" onkeyup="return onkeyupRupiah(this.id)" required>
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

<div class="modal fade" role="dialog" id="modal_add_invoice" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Data BPB</h5>
            </div>
            <div class="place_alert_cart_stock text-center"></div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" id="add_invoice">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. BPB</th>
                                    <th scope="col" class="text-center">Surat Jalan</th>
                                    <th scope="col" class="text-center">No. PO</th>
                                    <th scope="col" class="text-center">Legal Status</th>
                                    <th scope="col" class="text-center">Nama Supplier</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Tgl Diterima</th>
                                    <th scope="col" class="text-center" style="width: 10%">Action</th>
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
    function click_modal_update_invoice_outgoing(fc_invno) {

        $('#modal_loading').modal('show');

        $.ajax({
            url: '/apps/master-invoice/get-update/outgoing',
            type: 'GET',
            data: {
                fc_invno: fc_invno
            },
            success: function(response) {
                var data = response.data;
                console.log(data);
                if (response.status == 200) {
                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_update_invoice_do').modal('show');

                    $('#fc_invno_outgoing').html(data.fc_invno);
                    $('#fc_invno_input_outgoing').val(data.fc_invno);
                    $('#fd_inv_releasedate_outgoing').html(data.fd_inv_releasedate);
                    $('#fc_dono_outgoing').html(data.fc_dono);
                    $('#fc_membernpwp_no_outgoing').val(data.domst.somst.customer.fc_membernpwp_no);
                    $('#fc_membername1_outgoing').val(data.domst.somst.customer.fc_membername1);
                    $('#fd_inv_agingdate_outgoing').val(data.fd_inv_agingdate);

                    //calculation
                    $('#fn_invdetail_outgoing').html(data.fn_invdetail);
                    $('#fm_disctotal_outgoing').html("Rp. " + fungsiRupiah(data.fm_disctotal));
                    $('#fm_netto_incoming').html("Rp. " + fungsiRupiah(data.fm_netto));
                    $('#fm_servpay_outgoing').html("Rp. " + fungsiRupiah(data.fm_servpay));
                    $('#fm_tax_outgoing').html("Rp. " + fungsiRupiah(data.fm_tax));
                    $('#fm_brutto_outgoing').html("Rp. " + fungsiRupiah(data.fm_brutto));
                    $('#fm_paidvalue_outgoing').html("Rp. " + fungsiRupiah(data.fm_paidvalue));
                    $('#sisa_outgoing').html("Rp. " + fungsiRupiah(data.fm_brutto - data.fm_paidvalue));
                    $('#fm_valuepayment_outgoing').val(fungsiRupiah(data.fm_brutto - data.fm_paidvalue));
                }


            },
            error: function() {
                alert('Terjadi kesalahan pada server');
            }
        });
    }

    function click_modal_update_invoice_incoming(fc_invno) {
        // modal_loading show
        $('#modal_loading').modal('show');

        $.ajax({
            url: '/apps/master-invoice/get-update/incoming',
            type: 'GET',
            data: {
                fc_invno: fc_invno
            },
            success: function(response) {
                var data = response.data;

                if (response.status == 200) {
                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_update_invoice_ro').modal('show');

                    $('#fc_invno_incoming').html(data.fc_invno);
                    $('#fc_invno_input').val(data.fc_invno);

                    $('#fd_inv_releasedate_incoming').html(data.fd_inv_releasedate);
                    $('#fc_rono_incoming').html(data.fc_rono);
                    $('#fc_supplierNPWP').val(data.romst.pomst.supplier.fc_supplierNPWP);
                    $('#fc_suppliername1').val(data.romst.pomst.supplier.fc_suppliername1);
                    $('#fd_inv_agingdate').val(data.fd_inv_agingdate);

                    //calculation
                    $('#fn_invdetail_incoming').html(data.fn_invdetail);
                    $('#fm_disctotal_incoming').html("Rp. " + fungsiRupiah(data.fm_disctotal));
                    $('#fm_netto_incoming').html("Rp. " + fungsiRupiah(data.fm_netto));
                    $('#fm_servpay_incoming').html("Rp. " + fungsiRupiah(data.fm_servpay));
                    $('#fm_tax_incoming').html("Rp. " + fungsiRupiah(data.fm_tax));
                    $('#fm_brutto_incoming').html("Rp. " + fungsiRupiah(data.fm_brutto));
                    $('#fm_paidvalue_incoming').html("Rp. " + fungsiRupiah(data.fm_paidvalue));
                    $('#sisa').html("Rp. " + fungsiRupiah(data.fm_brutto - data.fm_paidvalue));
                    $('#fm_valuepayment_incoming').val(fungsiRupiah(data.fm_brutto - data.fm_paidvalue));
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server');
            }
        });
    }

    function click_modal_add_invoice() {
        $('#modal_add_invoice').modal('show');
    }

    var tb = $('#add_invoice').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [
            [6, "asc"]
        ],
        ajax: {
            url: "/apps/master-invoice/datatables/add-invoice",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, {
            className: 'text-nowrap',
            targets: [2, 6]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_rono'
            },
            {
                data: 'fc_sjno'
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'pomst.supplier.fc_supplierlegalstatus'
            },
            {
                data: 'pomst.supplier.fc_suppliername1',
            },
            {
                data: 'pomst.fn_podetail'
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            var fc_rono = window.btoa(data.fc_rono);
            if (data['fc_invstatus'] != 'N') {
                $(row).hide();
            } else {
                $(row).show();
            }

            $('td:eq(8)', row).html(`
                    <a href="/apps/master-invoice/create/${fc_rono}" class="btn btn-warning">Pilih</a>
                `);
        },
    });


    $('#fc_kode_outgoing').on('change', function() {
        // Check if the selected value is BCA Trans or Mandiri Trans
        if (this.value === 'BCA TRANS' || this.value === 'MANDIRI TRANS') {
            // Enable the No Rekening input
            $('#fc_bankaccount_outgoing').prop('disabled', false);
        } else {
            // Disable the No Rekening input and clear its value
            $('#fc_bankaccount_outgoing').prop('disabled', true).val('');
        }
    });

    $('#fc_kode_incoming').on('change', function() {
        // Check if the selected value is BCA Trans or Mandiri Trans
        if (this.value === 'BCA TRANS' || this.value === 'MANDIRI TRANS') {
            // Enable the No Rekening input
            $('#fc_bankaccount_incoming').prop('disabled', false);
        } else {
            // Disable the No Rekening input and clear its value
            $('#fc_bankaccount_incoming').prop('disabled', true).val('');
        }
    });


    var tb = $('#tb_incoming_invoice').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        ajax: {
            url: '/apps/master-invoice/datatables/incoming',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 3]
            },
            {
                className: 'text-nowrap',
                targets: [3, 4, 5, 6, 7, 8]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_invno'
            },
            {
                data: 'fc_rono'
            },
            {
                data: 'fc_status'
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
                data: 'fn_invdetail'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {

            var fc_rono = window.btoa(data.fc_rono);
            $('td:eq(3)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'R') {
                $('td:eq(3)', row).html('<span class="badge badge-primary">Terbit</span>');
            } else if (data['fc_status'] == 'P') {
                $('td:eq(3)', row).html('<span class="badge badge-success">Terbayar</span>');
            } else if (data['fc_status'] == 'IS') {
                $('td:eq(3)', row).html('<span class="badge badge-info">Angsuran</span>');
            } else {
                $(row).hide();
            }

            if (data['fc_status'] != 'P') {
                $('td:eq(8)', row).html(
                    `
                        <a href="/apps/master-invoice/detail_ro/${fc_rono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                        <a href="/apps/master-invoice/inv_ro/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                        <button class="btn btn-info btn-sm" onclick="click_modal_update_invoice_incoming('${data.fc_invno}')"><i class="fa fa-edit"></i> Update Inv</button>`
                );
            } else {
                $('td:eq(8)', row).html(
                    `
                        <a href="/apps/master-invoice/detail_ro/${fc_rono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                        <a href="/apps/master-invoice/inv_ro/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>`
                );
            }
        }
    });

    var tb = $('#tb_outgoing_invoice').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        ajax: {
            url: '/apps/master-invoice/datatables/outgoing',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 3]
            },
            {
                className: 'text-nowrap',
                targets: [3, 4, 5, 6, 7, 8]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_invno'
            },
            {
                data: 'fc_dono'
            },
            {
                data: 'fc_status'
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
                data: 'fn_invdetail'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_dono = window.btoa(data.fc_dono);
            $('td:eq(3)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'R') {
                $('td:eq(3)', row).html('<span class="badge badge-primary">Terbit</span>');
            } else if (data['fc_status'] == 'P') {
                $('td:eq(3)', row).html('<span class="badge badge-success">Terbayar</span>');
            } else if (data['fc_status'] == 'IS') {
                $('td:eq(3)', row).html('<span class="badge badge-info">Angsuran</span>');
            } else {
                $(row).hide();
            }

            if (data['fc_status'] != 'P') {
                $('td:eq(8)', row).html(
                    `
                        <a href="/apps/master-invoice/detail_do/${fc_dono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                        <a href="/apps/master-invoice/inv_do/${fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                        <button class="btn btn-info btn-sm" onclick="click_modal_update_invoice_outgoing('${data.fc_invno}')"><i class="fa fa-edit"></i> Update Inv</button>`
                );
            } else {
                $('td:eq(8)', row).html(
                    `
                        <a href="/apps/master-invoice/detail_do/${fc_dono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                        <a href="/apps/master-invoice/inv_do/${fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>`
                );
            }
        }
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection