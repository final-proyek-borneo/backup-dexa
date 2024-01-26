@extends('partial.app')
@section('title','Invoice CPRR')
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

<div id="alert-success"></div>

<div class="section-body">
    <div class="row">
        {{-- Informasi Umum  --}}
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Invoice CPRR</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/invoice-cprr/cancel" method="DELETE" autocomplete="off">
                    <div class="collapse" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" id="fc_userid" name="fc_userid" value="{{ $data->fc_userid }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Terbit</label>
                                        <div class="input-group date">
                                            <input type="text" id="fd_inv_releasedate" name="fd_inv_releasedate" class="form-control" fdprocessedid="8ovz8a" value="{{ $data->fd_inv_releasedate }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No. Dokumen RS</label>
                                        <input type="text" class="form-control" id="fc_sono" name="fc_sono" value="{{ $data->fc_suppdocno }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Jatuh Tempo</label>
                                        <div class="input-group date">
                                            <input type="text" id="fd_inv_agingdate" name="fd_inv_agingdate" class="form-control" fdprocessedid="8ovz8a" value="{{ $data->fd_inv_agingdate }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Customer</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{$data->fc_entitycode}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-danger">Batalkan Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Detail Customer  --}}
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Customer</h4>
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
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_tax_code->fv_description }} ({{$data->customer->member_tax_code->fc_action}}%)" readonly>
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
        {{-- Input CPRR Form  --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit_noconfirm" action="/apps/invoice-cprr/detail/store-update" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    <label>Kode CPRR</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control required-field" id="fc_detailitem" name="fc_detailitem" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="click_modal_cprr()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <div class="input-group">
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null" name="fn_itemqty" id="fn_itemqty" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_unityprice" id="fm_unityprice" onkeyup="return onkeyupRupiah(this.id);" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description" id="fv_description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button class="btn btn-success ml-1">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Calculation Bill  --}}
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
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_inv_disc">0,00</p>
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
        {{-- Tabel CPRR --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode CPRR</th>
                                        <th scope="col" class="text-center">Nama</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Diskon</th>
                                        <th scope="col" class="text-center">Persen</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center justify-content-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabel Biaya Lain-lain  --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Biaya Lain-lain</h4>
                    <div class="card-header-action">
                        <button type="button" onclick="click_addon_invdtl()" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambahkan Biaya Lain</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_addon" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center justify-content-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit_custom" action="/apps/invoice-cprr/update-inform/{{ $data->fc_invno }}" method="POST" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Bank</label>
                                    @if (empty($data->fc_bankcode))
                                    <select class="form-control select2 required-field" name="fc_bankcode" id="fc_bankcode" required></select>
                                    @else
                                    <select class="form-control select2" name="fc_bankcode" id="fc_bankcode">
                                        <option value="{{ $data->fc_bankcode }}" selected>
                                            {{ $data->bank->fv_bankname }}
                                        </option>
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Alamat Customer</label>
                                    @if (empty($data->fc_address))
                                    <select class="form-control select2" name="fc_address" id="fc_address" required>
                                        <option value="" selected disabled>- Pilih Alamat -</option>
                                        <option value="{{ $data->customer->fc_memberaddress1 }}">{{ $data->customer->fc_memberaddress1 }}</option>
                                        <option value="{{ $data->customer->fc_memberaddress_loading1 }}">{{ $data->customer->fc_memberaddress_loading1 }}</option>
                                        <option value="{{ $data->customer->fc_member_npwpaddress1 }}">{{ $data->customer->fc_member_npwpaddress1 }}</option>
                                    </select>
                                    @else
                                    <select class="form-control select2" name="fc_address" id="fc_address">
                                        <option value="{{ $data->fc_address }}" selected>
                                            {{ $data->fc_address }}
                                        </option>
                                        <option value="{{ $data->customer->fc_memberaddress1 }}">{{ $data->customer->fc_memberaddress1 }}</option>
                                        <option value="{{ $data->customer->fc_memberaddress_loading1 }}">{{ $data->customer->fc_memberaddress_loading1 }}</option>
                                        <option value="{{ $data->customer->fc_member_npwpaddress1 }}">{{ $data->customer->fc_member_npwpaddress1 }}</option>
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        @if (empty($data->fv_description))
                                        <input type="text" class="form-control" name="fv_description_mst" id="fv_description_mst">
                                        @else
                                        <input type="text" class="form-control" name="fv_description_mst" id="fv_description_mst" value="{{ $data->fv_description }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="button text-right">
                                    @if (empty($data->fc_address) && empty($data->fc_bankcode) && empty($data->fv_description))
                                    <button type="submit" class="btn btn-primary" id="btn_save">Simpan</button>
                                    @else
                                    <button type="submit" class="btn btn-warning" id="btn_save">Edit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- submit   --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="button text-right mb-4">
                <input type="text" value="R" name="fc_status" id="fc_status" hidden>

                @if($data->fn_invdetail >= 1 && $data->fc_status == "I" && $data->fc_bankcode != '' && $data->fc_address != '')
                <button id="submit_button" class="btn btn-primary">Submit</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_cprr" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih CPRR</h5>
                {{-- <div class="card-header-action">
                    <select data-dismiss="modal" onchange="" class="form-control select2 required-field" name="category" id="category">
                        <option value="Semua" selected>Semua&nbsp;&nbsp;</option>
                        <option value="Khusus">Khusus&nbsp;&nbsp;</option>
                    </select>
                </div> --}}
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_cprr_cust" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode CPRR</th>
                                    <th scope="col" class="text-center">Nama Pemeriksaan</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center">Catatan</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="click_category" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modal_addon" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Rincian Biaya Lainnya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_submit_noconfirm2" action="/apps/invoice-cprr/detail/store-update" method="POST" autocomplete="off">
                    <input type="text" value="ADDON" id="fc_status" name="fc_status" hidden>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <select class="form-control select2" name="fc_detailitem2" id="fc_detailitem2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Satuan</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="fc_unityname2" name="fc_unityname2" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Qty</label>
                                <div class="input-group">
                                    <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null" name="fn_itemqty2" id="fn_itemqty2" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control format-rp" name="fm_unityprice2" id="fm_unityprice2" onkeyup="return onkeyupRupiah(this.id);" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description2" id="fv_description2">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 text-right">
                            <button class="btn btn-success ml-1">Add Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_disc" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Diskon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_update" action="/apps/invoice-cprr/update-discprice" method="PUT" autocomplete="off">
                <input type="number" id="fn_invrownum" name="fn_invrownum" hidden>
                <input type="hidden" id="fm_discprice" name="fm_discprice" >
                <input type="hidden" id="fm_discprecen" name="fm_discprecen">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fm_unityprice_diskon" name="fm_unityprice" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Tipe Diskon</label>
                                <select class="form-control select2" name="tipe_diskon" id="tipe_diskon">
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="Nominal">Nominal</option>
                                    <option value="Persen">Persen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12" id="fm_discprice_nominal" hidden>
                            <div class="form-group">
                                <label>Diskon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control format-rp" id="fm_discprice1" name="fm_discprice1" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12" id="fm_discprice_persen" hidden>
                            <div class="form-group">
                                <label>Diskon</label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0" max="100" class="form-control" id="fm_discprice2" name="fm_discprice2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Harga setelah diskon</label>
                               
                                <input type="text" class="form-control" id="total_original" name="total_original" hidden>
                              
                                <div class="input-group">
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var invdtl = window.btoa('DEFAULT');
    var addon = window.btoa('ADDON');

    $(document).ready(function() {
        get_data_bank();
        get_data_biaya();
    })

    function get_data_biaya() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/OTHEREXPENSE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_detailitem2").empty();
                    $("#fc_detailitem2").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_detailitem2").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_modal_cprr() {
        $('#modal_cprr').modal('show');
        table_cprr();
    }

    function click_addon_invdtl() {
        $('#modal_addon').modal('show');
    }

    $("#submit_button").click(function() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan menyimpan data Invoice CPRR ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    var data = {
                        'fc_status': $('#fc_status').val(),
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/apps/invoice-cprr/submit',
                        data: data,
                        success: function(response) {
                            console.log(response.status);
                            if (response.status == 300 || response.status == 301) {
                                $('#modal_loading').modal('hide');
                                swal(response.message, {
                                    icon: 'error',
                                });
                            } else {
                                $('#modal_loading').modal('hide');
                                swal(response.message, {
                                    icon: 'success',
                                });
                                setTimeout(function() {
                                    window.location.href = "/apps/invoice-cprr";
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
                }
            });
    });

    var tbAddOn = $("#tb_addon").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: '/apps/invoice-cprr/datatables/' + addon,
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            },
            {
                data: 'keterangan.fv_description'
            },
            {
                data: 'fc_unityname',
            },
            {
                data: 'fn_itemqty',
            },
            {
                data: 'fm_unityprice',
                render: function(data, type, row) {
                    return row.fm_unityprice.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: 'fm_value',
                render: function(data, type, row) {
                    return row.fm_value.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: null
            }
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/invoice-cprr/detail/delete/" + data.fc_invno + '/' + data.fn_invrownum;

            $('td:eq(7)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','CPRR Detail')"><i class="fa fa-trash"></i></button>
            `);
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay').html(fungsiRupiahSystem(data[0].tempinvmst.fm_servpay));
                $("#fm_servpay").trigger("change");
                $('#fm_tax').html(fungsiRupiahSystem(data[0].tempinvmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html(fungsiRupiahSystem(data[0].tempinvmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html(fungsiRupiahSystem(data[0].tempinvmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_inv_disc').html(fungsiRupiahSystem(data[0].tempinvmst.fm_disctotal));
                $("#fm_inv_disc").trigger("change");
                $('#count_item').html(data[0].tempinvmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        }
    });

    var tb = $("#tb").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: '/apps/invoice-cprr/datatables/' + invdtl,
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, {
            className: 'text-nowrap',
            targets: [10]
        } ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            },
            {
                data: 'fc_detailitem',
            },
            {
                data: 'cospertes.fc_cprrname',
            },

            {
                data: 'nameunity.fv_description',
            },
            {
                data: 'fn_itemqty',
            },
            {
                data: 'fm_unityprice',
                render: function(data, type, row) {
                    return row.fm_unityprice.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fm_discprice',
                render: function(data, type, row) {
                    return row.fm_discprice.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fm_discprecen',
                defaultContent: '-'
            },
            {
                data: 'fv_description',
            },
            {
                data: 'fm_value',
                render: function(data, type, row) {
                    return row.fm_value.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: null
            }
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/invoice-cprr/detail/delete/" + data.fc_invno + '/' + data.fn_invrownum;

            $('td:eq(10)', row).html(`
                <button type="submit" class="btn btn-sm btn-info mr-1" data-id="${data.fn_invrownum}" data-price="${data.fm_unityprice}" onclick="diskon(this)"><i class="fa-solid fa-percent"></i></button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','CPRR Detail')"><i class="fa fa-trash"> </i></button>
            `);
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay').html(fungsiRupiahSystem(data[0].tempinvmst.fm_servpay));
                $("#fm_servpay").trigger("change");
                $('#fm_tax').html(fungsiRupiahSystem(data[0].tempinvmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html(fungsiRupiahSystem(data[0].tempinvmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html(fungsiRupiahSystem(data[0].tempinvmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_inv_disc').html(fungsiRupiahSystem(data[0].tempinvmst.fm_disctotal));
                $("#fm_inv_disc").trigger("change");
                $('#count_item').html(data[0].tempinvmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        }
    });

    function get_data_bank() {
        var valueBank = "{{ $data->fc_bankcode }}";
        var nameBank = "{{ $data->bank ? $data->bank->fv_bankname : '' }}";
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-all/BankAcc",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_bankcode").empty();
                    if (nameBank == "") {
                        $("#fc_bankcode").append(`<option value="" selected disabled> -- Pilih Bank -- </option>`);
                    } else {
                        $("#fc_bankcode").append(`<option value="${valueBank}" selected disabled> ${nameBank} </option>`);
                    }

                    for (var i = 0; i < data.length; i++) {
                        $("#fc_bankcode").append(
                            `<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
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


   function table_cprr(){
    var fc_membercode = window.btoa($('#fc_membercode').val());
        // console.log(fc_membercode)

        var tb_cprr_cust = $('#tb_cprr_cust').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/data-master/cprr-customer/datatables/' + fc_membercode,
                type: 'GET',
                data: function(dData) {
                    dData.category = $("#categori").val();
                },
            },
            columnDefs: [{
                className: 'text-center',
                targets: []
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'fc_cprrcode',
                },
                {
                    data: 'cospertes.fc_cprrname'
                },
                {
                    data: 'fm_price',
                    render: function(data, type, row) {
                        return row.fm_price.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fv_description'
                },
                {
                    data: null,
                }
            ],
            rowCallback: function(row, data) {
                $("td:eq(5)", row).html(`
                    <button type="button" onclick="choosen('${data.id}')" class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</butoon>
                `);
            }
        });
   }

   function diskon(button) {
        var id = $(button).data('id');
        var price = $(button).data('price');

        // console.log(price);

        $("#modal_disc").modal('show');
        $('#fn_invrownum').val(id);
        $('#fm_unityprice_diskon').val(fungsiRupiahSystem(price));
        $("#tipe_diskon").change(function() {
            if ($('#tipe_diskon').val() === "Persen") {
                $('#fm_discprice_persen').attr('hidden', false);
                $('#fm_discprice_nominal').attr('hidden', true);

                $('#fm_discprice_persen').on('input', function() {
                    var hargaAwal = parseFloat($('#fm_unityprice_diskon').val().toString().replace(/[^\d|\,]/g, ''));
                    var input = parseFloat($('#fm_discprice2').val());
                    var hargaDiskon = parseFloat($('#fm_discprice2').val()) / 100;

                    console.log(input);
                    if (input > 100) {
                        iziToast.warning({
                            title: 'Warning!',
                            message: 'Diskon lebih dari 100%',
                            position: 'topRight'
                        });
                        $('#total').val("Error");
                        $('#update').prop('disabled', true);
                    } else {
                        var total = hargaAwal - (hargaAwal * hargaDiskon);
                        $('#total').val(fungsiRupiahSystem(total));
                        $('#total_original').val(total);
                        $('#update').prop('disabled', false);
                    }
                    var selisih = hargaAwal - total
                    // var discprice = parseFloat(selisih.toString().replace(/[^\d|\,]/g, ''));
                    $('#fm_discprice').val(parseFloat(selisih));
                    $('#fm_discprecen').val(parseFloat(input));
                });
            } else {
                $('#fm_discprice_persen').attr('hidden', true);
                $('#fm_discprice_nominal').attr('hidden', false);

                $('#fm_discprice_nominal').on('input', function() {
                    var hargaAwal = parseFloat($('#fm_unityprice_diskon').val().toString().replace(/[^\d|\,]/g, ''));
                    var hargaDiskon = parseFloat($('#fm_discprice1').val().toString().replace(/[^\d|\,]/g, ''));

                    if (hargaDiskon > hargaAwal) {
                        iziToast.warning({
                            title: 'Warning!',
                            message: 'Nominal diskon lebih besar daripada harganya',
                            position: 'topRight'
                        });
                        $('#total').val("Error");
                        $('#update').prop('disabled', true);
                    } else {
                        var total = hargaAwal - hargaDiskon;
                        $('#total').val(fungsiRupiahSystem(total));
                        $('#update').prop('disabled', false);
                    }

                    var discprice = parseFloat($('#fm_discprice1').val().toString().replace(/[^\d|\,]/g, ''));
                    $('#fm_discprice').val(discprice);
                    $('#fm_discprecen').val(0);
                });
            }
        });
    }

    function choosen(id) {
        $("modal_loading").modal('show');
        var fc_id = window.btoa(id);
        $.ajax({
            url: "/data-master/cprr-customer/" + fc_id,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;

                $("#modal_cprr").modal('hide');
                $("#fc_detailitem").val(data.fc_cprrcode);
                $("#fm_unityprice").val(data.fm_price);
                $("#fv_description").val(data.fv_description);

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
    $('#form_submit_noconfirm2').on('submit', function(e) {
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
            url: $('#form_submit_noconfirm2').attr('action'),
            type: $('#form_submit_noconfirm2').attr('method'),
            data: $('#form_submit_noconfirm2').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal_addon").modal('hide');
                    $("#form_submit_noconfirm2")[0].reset();
                    reset_all_select();
                    tbAddOn.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
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

    $('#form_update').on('submit', function(e) {
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
            url: $('#form_update').attr('action'),
            type: $('#form_update').attr('method'),
            data: $('#form_update').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal_disc").modal('hide');
                    $("#form_update")[0].reset();
                    reset_all_select();
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
</script>
@endsection