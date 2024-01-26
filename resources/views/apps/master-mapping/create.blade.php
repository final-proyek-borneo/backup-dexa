@extends('partial.app')
@section('title', 'Buat Mapping')
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

    .form-check-label {
        text-transform: capitalize;
    }

    .cbox{
        margin-top: 25px;
    }

    .ks-cboxtags {        
        list-style: none;
    }

    .ks-cboxtags {
        display: inline;
    }

    .ks-cboxtags label {
        display: inline-block;
        background-color: rgba(255, 255, 255, .9);
        border: 2px solid rgba(139, 139, 139, .3);
        color: #adadad;
        border-radius: 25px;
        white-space: nowrap;
        margin: 3px 0px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        transition: all .2s;
    }

    .ks-cboxtags label {
        padding: 8px 12px;
        cursor: pointer;
    }

    .ks-cboxtags label::before {
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 12px;
        padding: 2px 6px 2px 2px;
        content: "\f067";
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label::before {
        content: "\f00c";
        transform: rotate(-360deg);
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label {
        border: 2px solid #b6d7a8;
        background-color: #0A9447;
        color: #fff;
        transition: all .2s;
    }

    .ks-cboxtags input[type="checkbox"] {
        display: absolute;
    }

    .ks-cboxtags input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }

    .ks-cboxtags input[type="checkbox"]:focus+label {
        border: 2px solid #97d508;
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
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->branch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Kode Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingcode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Nama Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->created_by }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required-select">
                                    <label id="label-select">Hold</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" name="fc_hold" id="fc_hold" value="{{ $data->fc_hold }}" class="selectgroup-input" checked>
                                            @if($data->fc_hold == 'T')
                                            <span class="selectgroup-button">YA</span>
                                            @else
                                            <span class="selectgroup-button">TIDAK</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Tipe</label>
                                    <input type="text" class="form-control" name="fc_mappingcashtype" id="fc_mappingcashtype" value="{{ $data->tipe->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Transaksi</label>
                                    <input type="text" class="form-control" name="fc_mappingtrxtype" id="fc_mappingtrxtype" value="{{ $data->transaksi->fv_description }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="form_submit_accmethod_debit" action="/apps/master-mapping/create/trxaccmethod_debit/{{ base64_encode($data->fc_mappingcode) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Hak Istimewa Debit</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkAllDebit" name="trxaccmethod[]" value="DEFAULT" {{ in_array('DEFAULT', json_decode(json_encode($fc_debit_previledge), true)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkAllDebit">General</label>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-9" id="checkbox">
                                    <div class="ks-cboxtags">
                                    @if($trxaccmethod)
                                        @foreach($trxaccmethod as $index => $accmethod)
                                            @php
                                                $isDebitPreviledge = in_array($accmethod->fc_kode, $fc_debit_previledge);
                                            @endphp
                                            @if($accmethod->fc_kode !== 'DEFAULT')
                                            <input type="checkbox" id="{{ 'checkbox_debit' . $index }}" name="trxaccmethod[]" value="{{ $accmethod->fc_kode }}" {{ $isDebitPreviledge ? 'checked' : '' }}>
                                            <label for="{{ 'checkbox_debit' . $index }}">{{ $accmethod->fv_description }}</label>
                                            @endif
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @if ($data->fc_debit_previledge == '[""]')
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @else
                            <button type="submit" class="btn btn-warning">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="form_submit" action="/apps/master-mapping/create/trxaccmethod_kredit/{{ base64_encode($data->fc_mappingcode) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Hak Istimewa Kredit</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkAllKredit" name="trxaccmethod[]" value="DEFAULT" {{ in_array('DEFAULT', $fc_credit_previledge) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkAllKredit">General</label>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-9" id="checkbox">
                                    <div class="ks-cboxtags">
                                        @if($trxaccmethod)
                                            @foreach($trxaccmethod as $index => $accmethod)
                                                @php
                                                    $isCreditPreviledge = in_array($accmethod->fc_kode, $fc_credit_previledge);
                                                @endphp
                                                @if($accmethod->fc_kode !== 'DEFAULT')
                                                    <input type="checkbox" id="{{ 'checkbox_kredit' . $index }}" name="trxaccmethod[]" value="{{ $accmethod->fc_kode }}" {{ $isCreditPreviledge ? 'checked' : '' }}>
                                                    <label for="{{ 'checkbox_kredit' . $index }}">{{ $accmethod->fv_description }}</label>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @if ($data->fc_credit_previledge == '[""]')
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @else
                            <button type="submit" class="btn btn-warning">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($data->fc_credit_previledge != '[""]' && $data->fc_debit_previledge != '[""]')
        {{-- Debit --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Mapping Debit</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_debit();"><i class="fa fa-plus mr-1"></i> Tambah Debit</button>
                    </div>
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
                                        <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Kredit --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Mapping Kredit</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                    </div>
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
                                        <th scope="col" class="text-center" style="width: 20%">Actions</th>
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
    </div>
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/master-mapping/submit/{{ $data->fc_mappingcode }}" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Mapping</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_debit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_coa_debit" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode COA</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Layer</th>
                                    <th scope="col" class="text-center">COA Induk</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center">Action</th>
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

<div class="modal fade" role="dialog" id="modal_kredit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Kredit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_coa_kredit" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode COA</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Layer</th>
                                    <th scope="col" class="text-center">COA Induk</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center">Action</th>
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

<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3" hidden>
                        <div class="form-group">
                            <label>Divisi</label>
                            <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Cabang</label>
                            <input type="text" class="form-control" name="fc_branch1" id="fc_branch1">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Layer</label>
                            <input type="number" min="0" class="form-control required-field" onchange="get_parent()" name="fn_layer" id="fn_layer">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>COA Induk</label>
                            <select name="fc_parentcode" id="fc_parentcode" class="select2 required-field"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group required">
                            <label>Kode COA</label>
                            <input type="text" class="form-control required-field" name="fc_coacode" id="fc_coacode">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-9">
                        <div class="form-group required">
                            <label>Nama COA</label>
                            <input type="text" class="form-control required-field" name="fc_coaname" id="fc_coaname">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required-select">
                            <label id="label-select">Direct Payment</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_directpayment" id="fc_directpayment" value="T" class="selectgroup-input" disabled>
                                    <span class="selectgroup-button">YA</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_directpayment" id="fc_directpayment" value="F" class="selectgroup-input" checked="" disabled>
                                    <span class="selectgroup-button">TIDAK</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required-select">
                            <label id="label-select">Status Neraca</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="C" class="selectgroup-input" disabled>
                                    <span class="selectgroup-button">KREDIT</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="D" class="selectgroup-input" checked="" disabled>
                                    <span class="selectgroup-button">DEBIT</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Group</label>
                            <select name="fc_group" id="fc_group" class="select2 required-field"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" class="form-control" name="fv_description" id="fv_description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var mappingcode = "{{ $data->fc_mappingcode }}";
    var encode_mappingcode = window.btoa(mappingcode);

   // trxaccmethod transaksi
    var checkAllKredit = $('#checkAllKredit');
    var isCheckedKredit = checkAllKredit.is(':checked');
    var checkAllDebit = $('#checkAllDebit');
    var isCheckedDebit = checkAllDebit.is(':checked');

    if (isCheckedDebit) {
        $('input[id^="checkbox_debit"]').prop('checked', false);
        $('input[id^="checkbox_debit"]').prop('disabled', true);
    }

    checkAllDebit.change(function() {
        isCheckedDebit = $(this).is(':checked');
        isCheckedKredit = $(this).is(':checked');

        $('input[id^="checkbox_debit"]').prop('checked', false);
        $('input[id^="checkbox_debit"]').prop('disabled', isCheckedDebit);

        if(!isCheckedKredit){
                $('input[id^="checkbox_kredit"]').prop('disabled', isCheckedDebit);
         }
    });

    if (isCheckedKredit) {
        $('input[id^="checkbox_kredit"]').prop('checked', false);
        $('input[id^="checkbox_kredit"]').prop('disabled', true);
    }

    checkAllKredit.change(function() {
        isCheckedKredit = $(this).is(':checked');
        isCheckedDebit = $(this).is(':checked');

        $('input[id^="checkbox_kredit"]').prop('checked', false);
        $('input[id^="checkbox_kredit"]').prop('disabled', isCheckedKredit);

        if(!isCheckedDebit){
                 $('input[id^="checkbox_debit"]').prop('disabled', isCheckedDebit);
        }
   
    });

    // Handle 'ONCE' value credit atau debit
    var onceDebitChecked = false;
    var onceCreditChecked = false;

    $('input[id^="checkbox_debit"]').each(function() {
        if ($(this).val() === 'ONCE' && $(this).is(':checked')) {
            onceDebitChecked = true;
        }
    });

    $('input[id^="checkbox_kredit"]').each(function() {
        if ($(this).val() === 'ONCE' && $(this).is(':checked')) {
            onceCreditChecked = true;
        }
    });

    if (onceDebitChecked) {
        $('input[id^="checkbox_kredit"][value="ONCE"]').prop('disabled', true);
    }
    if (onceCreditChecked) {
        $('input[id^="checkbox_debit"][value="ONCE"]').prop('disabled', true);
    }

    $('input[id^="checkbox_debit"]').change(function() {
        if ($(this).val() === 'ONCE' && $(this).is(':checked')) {
            $('input[id^="checkbox_kredit"][value="ONCE"]').prop('disabled', true);
        } else {
            $('input[id^="checkbox_kredit"][value="ONCE"]').prop('disabled', false);
        }
    });

    $('input[id^="checkbox_kredit"]').change(function() {
        if ($(this).val() === 'ONCE' && $(this).is(':checked')) {
            $('input[id^="checkbox_debit"][value="ONCE"]').prop('disabled', true);
        } else {
            $('input[id^="checkbox_debit"][value="ONCE"]').prop('disabled', false);
        }
    });
     // END Handle 'ONCE' value credit atau debit

     // Handle 'LBPB' value credit atau debit
        var lbpbDebitChecked = false;
        var lbpbCreditChecked = false;

        $('input[id^="checkbox_debit"]').each(function() {
            if ($(this).val() === 'LBPB' && $(this).is(':checked')) {
                lbpbDebitChecked = true;
            }
        });

        $('input[id^="checkbox_kredit"]').each(function() {
            if ($(this).val() === 'LBPB' && $(this).is(':checked')) {
                lbpbCreditChecked = true;
            }
        });

        if (lbpbDebitChecked) {
            $('input[id^="checkbox_kredit"][value="LBPB"]').prop('disabled', true);
        }
        if (lbpbCreditChecked) {
            $('input[id^="checkbox_debit"][value="LBPB"]').prop('disabled', true);
        }

        $('input[id^="checkbox_debit"]').change(function() {
            if ($(this).val() === 'LBPB') {
                if ($(this).is(':checked')) {
                    $('input[id^="checkbox_kredit"][value="LBPB"]').prop('disabled', true);
                } else {
                    $('input[id^="checkbox_kredit"][value="LBPB"]').prop('disabled', false);
                }
            }
        });

        $('input[id^="checkbox_kredit"]').change(function() {
            if ($(this).val() === 'LBPB') {
                if ($(this).is(':checked')) {
                    $('input[id^="checkbox_debit"][value="LBPB"]').prop('disabled', true);
                } else {
                    $('input[id^="checkbox_debit"][value="LBPB"]').prop('disabled', false);
                }
            }
        });
        // END Handle 'LBPB' value credit atau debit

        // Handle 'LINV' value credit atau debit
        var linvDebitChecked = false;
        var linvCreditChecked = false;

        $('input[id^="checkbox_debit"]').each(function() {
            if ($(this).val() === 'LINV' && $(this).is(':checked')) {
                linvDebitChecked = true;
            }
        });

        $('input[id^="checkbox_kredit"]').each(function() {
            if ($(this).val() === 'LINV' && $(this).is(':checked')) {
                linvCreditChecked = true;
            }
        });

        if (linvDebitChecked) {
            $('input[id^="checkbox_kredit"][value="LINV"]').prop('disabled', true);
        }
        if (linvCreditChecked) {
            $('input[id^="checkbox_debit"][value="LINV"]').prop('disabled', true);
        }

        $('input[id^="checkbox_debit"]').change(function() {
            if ($(this).val() === 'LINV') {
                if ($(this).is(':checked')) {
                    $('input[id^="checkbox_kredit"][value="LINV"]').prop('disabled', true);
                } else {
                    $('input[id^="checkbox_kredit"][value="LINV"]').prop('disabled', false);
                }
            }
        });

        $('input[id^="checkbox_kredit"]').change(function() {
            if ($(this).val() === 'LINV') {
                if ($(this).is(':checked')) {
                    $('input[id^="checkbox_debit"][value="LINV"]').prop('disabled', true);
                } else {
                    $('input[id^="checkbox_debit"][value="LINV"]').prop('disabled', false);
                }
            }
        });
     // END Handle 'LINV' value credit atau debit


     // Handle 'PAIR' value credit atau debit
        var pairDebitChecked = false;
        var pairCreditChecked = false;

        $('input[id^="checkbox_debit"]').each(function() {
            if ($(this).val() === 'PAIR' && $(this).is(':checked')) {
                pairDebitChecked = true;
            }
        });

        $('input[id^="checkbox_kredit"]').each(function() {
            if ($(this).val() === 'PAIR' && $(this).is(':checked')) {
                pairCreditChecked = true;
            }
        });

        if (pairDebitChecked) {
            $('input[id^="checkbox_kredit"][value="PAIR"]').prop('checked', true);
            $('#checkAllKredit').prop('checked', false);
            $('input[id^="checkbox_debit"]').prop('disabled', false);
        }
        if (pairCreditChecked) {
            $('input[id^="checkbox_debit"][value="PAIR"]').prop('checked', true);
            $('#checkAllDebit').prop('checked', false);
            $('input[id^="checkbox_debit"]').prop('disabled', false);
        }

        $('input[id^="checkbox_debit"]').change(function() {
            if ($(this).val() === 'PAIR') {
                if ($(this).is(':checked')) {

                    var anyOnceChecked = $('input[id^="checkbox_debit"][value="ONCE"]:checked').length > 0;

                    if (anyOnceChecked) {
                        $('input[id^="checkbox_kredit"][value="PAIR"]').prop('checked', true);
                            $('#checkAllKredit').prop('checked', false);
                            $('input[id^="checkbox_kredit"]').prop('disabled', false);
                            $('input[id^="checkbox_kredit"][value="ONCE"]').prop('disabled', true);
                    } else {
                        $('input[id^="checkbox_kredit"][value="PAIR"]').prop('checked', true);
                        $('#checkAllKredit').prop('checked', false);
                        $('input[id^="checkbox_kredit"]').prop('disabled', false);
                    }
                } else {
                    $('input[id^="checkbox_kredit"][value="PAIR"]').prop('checked', false);
                }
            }
        });

        $('input[id^="checkbox_kredit"]').change(function() {
            // console.log($(this).val())
            if ($(this).val() === 'PAIR') {
                    if ($(this).is(':checked')) {
                        var anyOnceChecked = $('input[id^="checkbox_kredit"][value="ONCE"]:checked').length > 0;
                        
                        if (anyOnceChecked) {
                            $('input[id^="checkbox_debit"][value="PAIR"]').prop('checked', true);
                            $('#checkAllDebit').prop('checked', false);
                            $('input[id^="checkbox_debit"]').prop('disabled', false);
                            $('input[id^="checkbox_debit"][value="ONCE"]').prop('disabled', true);
                        } else {
                            $('input[id^="checkbox_debit"][value="PAIR"]').prop('checked', true);
                            $('#checkAllDebit').prop('checked', false);
                            $('input[id^="checkbox_debit"]').prop('disabled', false);
                        }
                        // console.log(anyOnceChecked)
                    } else {
                        $('input[id^="checkbox_debit"][value="PAIR"]').prop('checked', false);
                    }
                }
        });
     // END handle value 'PAIR' credit atau debit

     
  // End trxaccmethod transaksi
    function detail(fc_coacode) {
        $("#modal").modal('show');
        $(".modal-title").text('Detail COA');
        get_detail(fc_coacode);
    }

    function get_detail(fc_coacode) {
        $('#modal_loading').modal('show');
        var coacode = window.btoa(fc_coacode);

        $.ajax({
            url: "/apps/master-coa/detail/" + coacode,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);

                if (response.status == 200) {
                    console.log(data);
                    var value = data.fc_directpayment;
                    $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                    var value2 = data.fc_balancestatus;
                    $("input[name= fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                    $('#fc_branch1').val(data.branch.fv_description);
                    $('#fc_branch1').prop('readonly', true);
                    $('#fc_coacode').val(data.fc_coacode);
                    $('#fc_coacode').prop('readonly', true);
                    $('#fc_coaname').val(data.fc_coaname);
                    $('#fc_coaname').prop('readonly', true);
                    $('#fn_layer').val(data.fn_layer);
                    $('#fn_layer').prop('readonly', true);
                    // $('#fc_directpayment').val(data.fc_directpayment).prop('checked', true);

                    if (data.fc_parentcode == 0) {
                        $('#fc_parentcode').append(`<option value="0" selected>COA INDUK</option>`)
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(0);
                    } else {
                        $('#fc_parentcode').append(`<option value="${data.parent.fc_coacode}" selected>${data.parent.fc_coaname}</option>`);
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(data.parent.fc_coacode);
                    }
                    if (data.transaksitype != null) {
                        $('#fc_group').append(`<option value="${data.fc_group}" selected>${data.transaksitype.fv_description}</option>`);
                        $('#fc_group').prop('disabled', true);
                    } else {
                        $('#fc_group').append(`<option value="-" selected>-</option>`);
                        $('#fc_group').prop('disabled', true);
                    }
                    $('#fv_description').val(data.fv_description);
                    $('#fv_description').prop('readonly', true);
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
        })
    }

    function click_add_debit() {
        $('#modal_debit').modal('show');
    }

    function click_add_kredit() {
        $('#modal_kredit').modal('show');
    }

    var tb_debit = $('#tb_debit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-mapping/create/datatables-debit/" + encode_mappingcode,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2]
        }, {
            className: 'text-nowrap',
            targets: [3]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode'
            },
            {
                data: 'mst_coa.fc_coaname'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_mappingcode = window.btoa(data.fc_mappingcode);
            var fc_coacode = window.btoa(data.fc_coacode);
            var url_delete = "/apps/master-mapping/delete/debit/" + fc_coacode;


            $('td:eq(3)', row).html(`
                    <button type="button" class="btn btn-primary btn-sm mr-1" onclick="detail('${data.fc_coacode}')"><i class="fa fa-eye"> </i> Detail</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.mst_coa.fc_coaname}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    var tb_kredit = $('#tb_kredit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-mapping/create/datatables-kredit/" + encode_mappingcode,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2]
        }, {
            className: 'text-nowrap',
            targets: [3]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode'
            },
            {
                data: 'mst_coa.fc_coaname'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_mappingcode = window.btoa(data.fc_mappingcode);
            var fc_coacode = window.btoa(data.fc_coacode);
            var url_delete = "/apps/master-mapping/delete/kredit/" + fc_coacode;


            $('td:eq(3)', row).html(`
                    <button type="button" class="btn btn-primary btn-sm mr-1" onclick="detail('${data.fc_coacode}')"><i class="fa fa-eye"> </i> Detail</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.mst_coa.fc_coaname}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    var tb_coa_debit = $('#tb_coa_debit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-coa/for-mapping/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
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
                data: 'fc_coacode'
            },
            {
                data: 'fc_coaname'
            },
            {
                data: 'fn_layer'
            },
            {
                data: 'parent.fc_coaname',
                defaultContent: '<span class="badge bg-primary text-light">COA INDUK</span>',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(6)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="select_coa_debit('${data.fc_coacode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function select_coa_debit(fc_coacode) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/master-mapping/create/insert-debit',
            type: 'POST',
            data: {
                fc_coacode: fc_coacode,
                fc_mappingcode: mappingcode,
            },
            success: function(response) {
                if (response.status === 200) {
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#modal_debit').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    tb_debit.ajax.reload();
                } else {
                    iziToast.error({
                        title: 'Gagal!',
                        message: response.message,
                        position: 'topRight'
                    });

                    $('#modal_debit').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    var tb_coa_kredit = $('#tb_coa_kredit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-coa/for-mapping/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, {
            className: 'text-nowrap',
            targets: [6]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode'
            },
            {
                data: 'fc_coaname'
            },
            {
                data: 'fn_layer'
            },
            {
                data: 'parent.fc_coaname',
                defaultContent: '<span class="badge bg-primary text-light">COA INDUK</span>',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(6)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="select_coa_kredit('${data.fc_coacode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function select_coa_kredit(fc_coacode) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/master-mapping/create/insert-kredit',
            type: 'POST',
            data: {
                fc_coacode: fc_coacode,
                fc_mappingcode: mappingcode,
            },
            success: function(response) {
                if (response.status === 200) {
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    
                    $('#modal_kredit').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    tb_kredit.ajax.reload();
                } else {
                    iziToast.error({
                        title: 'Gagal!',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#modal_kredit').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_cancel() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan mengcancel Buat Mapping ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/master-mapping/cancel/' + encode_mappingcode,
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
                                iziToast.error({
                                    title: 'Gagal!',
                                    message: response.message,
                                    position: 'topRight'
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