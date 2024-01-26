@extends('partial.app')
@section('title', 'Edit Transaksi')
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
                                        <h5 class="text-muted" style="font-weight: bold; font-size:large" id="balance" name="balance">Rp.0</h5>
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
                    <div class="card-header-action">
                        @if ($data->mapping->fc_debit_previledge && in_array('LBPB', json_decode($data->mapping->fc_debit_previledge)))
                        <button type="button" class="btn btn-warning" id="btn-bpb-debit" onclick="look_bpb('D');"><i class="fa fa-plus mr-1"></i> BPB</button>
                        <button type="button" class="btn btn-success" id="btn-debit" onclick="add_debit();"><i class="fa fa-plus"></i> Tambah Debit</button>
                        @elseif ($data->mapping->fc_debit_previledge && in_array('LINV', json_decode($data->mapping->fc_debit_previledge)))
                        <button type="button" class="btn btn-warning" id="btn-inv-kredit" onclick="look_inv('D');"><i class="fa fa-plus mr-1"></i> Invoice</button>
                        <button type="button" class="btn btn-success" id="btn-debit" onclick="add_debit();"><i class="fa fa-plus"></i> Tambah Debit</button>
                        @else
                        <button type="button" class="btn btn-success" id="btn-debit" onclick="add_debit();"><i class="fa fa-plus"></i> Tambah Debit</button>
                        @endif
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
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
                    <div class="card-header-action">
                        @if ($data->mapping->fc_credit_previledge && in_array('LBPB', json_decode($data->mapping->fc_credit_previledge), true))
                        <button type="button" class="btn btn-warning" id="btn-bpb-kredit" onclick="look_bpb('C');"><i class="fa fa-plus mr-1"></i> BPB</button>
                        <button type="button" class="btn btn-success" id="btn-kredit" onclick="add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                        @elseif ($data->mapping->fc_credit_previledge && in_array('LINV', json_decode($data->mapping->fc_credit_previledge), true))
                        <button type="button" class="btn btn-warning" id="btn-inv-kredit" onclick="look_inv('C');"><i class="fa fa-plus mr-1"></i> Invoice</button>
                        <button type="button" class="btn btn-success" id="btn-kredit" onclick="add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                        @else
                        <button type="button" class="btn btn-success" id="btn-kredit" onclick="add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                        @endif
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
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit_edit" action="/apps/transaksi/edit/submit-edit/{{ base64_encode($fc_trxno) }}" method="post">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
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
                    <input type="text" name="status_balance" id="status_balance" hidden>
                    <input type="text" name="jumlah_balance" id="jumlah_balance" hidden>
                    <input type="text" name="tipe_jurnal" id="tipe_jurnal" value="{{ $data->transaksitype->fv_description }}" hidden>
                    @php
                    $fcCreditPreviledgeArray = json_decode($data->mapping->fc_credit_previledge, true);
                    $fcDebitPreviledgeArray = json_decode($data->mapping->fc_debit_previledge, true);
                    $mergedArray = array_merge($fcCreditPreviledgeArray, $fcDebitPreviledgeArray);
                    @endphp

                    @if(in_array('ONCE', $mergedArray) && in_array('LINV', $mergedArray))
                    <button type="button" onclick="click_opsilanjut()" class="btn btn-info">Opsi Lanjutan</button>
                    @else
                    <button type="submit" class="btn btn-success">Submit Transaksi</button>
                    @endif
                </div>
            </form>
        </div>
        <!-- <div class="button text-right mb-4">
            <form id="form_submit_edit" action="#" method="post">
                @csrf
                @method('put')
                <input type="text" name="status_balance" id="status_balance" hidden>
                <input type="text" name="jumlah_balance" id="jumlah_balance" hidden>
                <input type="text" name="tipe_jurnal" id="tipe_jurnal" value="{{ $data->transaksitype->fv_description }}" hidden>
                <button type="submit" class="btn btn-success">Submit Transaksi</button>
            </form>
            </div> -->
    </div>
</div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_debit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_debit" action="/apps/transaksi/edit/edit-debit/{{ base64_encode($fc_trxno) }}" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <select name="fc_coacode" id="fc_coacode" onchange="get_data_coa()" class="select2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
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
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
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
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group ">
                                <label>Group</label>
                                <select name="fc_group" id="fc_group" class="select2" disabled></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <input name="fc_paymentmethod" id="fc_paymentmethod_hidden" type="text" hidden>
                                <select name="fc_paymentmethod" id="fc_paymentmethod" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="no_giro" hidden>
                            <div class="form-group required">
                                <label>No. Giro</label>
                                <input name="fc_refno" id="fc_refno" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="tgl_giro" hidden>
                            <div class="form-group required">
                                <label>Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_agingref" class="form-control datepicker" name="fd_agingref">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_kredit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Kredit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_kredit" action="/apps/transaksi/edit/edit-kredit/{{ base64_encode($fc_trxno) }}" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <select name="fc_coacode_kredit" id="fc_coacode_kredit" onchange="get_data_coa_kredit()" class="select2 -field" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Direct Payment</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment_kredit" id="fc_directpayment_kredit" value="T" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment_kredit" id="fc_directpayment_kredit" value="F" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Status Neraca</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus_kredit" id="fc_balancestatus_kredit" value="C" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">KREDIT</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus_kredit" id="fc_balancestatus_kredit" value="D" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">DEBIT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group ">
                                <label>Group</label>
                                <select name="fc_group_kredit" id="fc_group_kredit" class="select2" disabled></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <input name="fc_paymentmethod_kredit" id="fc_paymentmethod_kredit_hidden" type="text" hidden>
                                <select name="fc_paymentmethod_kredit" id="fc_paymentmethod_kredit" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="no_giro_kredit" hidden>
                            <div class="form-group required">
                                <label>No. Giro</label>
                                <input name="fc_refno_kredit" id="fc_refno_kredit" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="tgl_giro_kredit" hidden>
                            <div class="form-group required">
                                <label>Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_agingref_kredit" class="form-control datepicker" name="fd_agingref_kredit">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_pembayaran" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Edit Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_update" action="/apps/transaksi/edit/update-edit-pembayaran/{{ base64_encode($fc_trxno) }}" method="PUT" autocomplete="off">
                <input name="fv_description_payment" id="fv_description_payment" type="text" hidden>
                <input name="fm_nominal_payment" id="fm_nominal_payment" type="hidden">
                <input name="tipe" id="tipe" type="text" hidden>
                <input name="fn_rownum" id="fn_rownum" type="text" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <input name="fc_paymentmethod_edit" id="fc_paymentmethod_edit_hidden" type="text" hidden>
                                <select name="fc_paymentmethod_edit" id="fc_paymentmethod_edit" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="no_giro_edit" hidden>
                            <div class="form-group required">
                                <label>No. Giro</label>
                                <input name="fc_refno_edit" id="fc_refno_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="tgl_giro_edit" hidden>
                            <div class="form-group required">
                                <label>Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_agingref_edit" class="form-control datepicker" name="fd_agingref_edit">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_invoice" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Daftar Invoice</h5>
                <div class="card-header-action">
                </div>
            </div>
            <div class="place_alert_cart_stock text-center"></div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" id="tb_invoice">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Invoice</th>
                                    <th scope="col" class="text-center">No. SJ</th>
                                    <th scope="col" class="text-center text-nowrap">Tgl Terbit</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Customer</th>
                                    <th scope="col" class="text-center">Tagihan</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
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

<div class="modal fade" role="dialog" id="modal_bpb" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Daftar BPB</h5>
                <div class="card-header-action">
                </div>
            </div>
            <div class="place_alert_cart_stock text-center"></div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" id="tb_bpb">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Invoice</th>
                                    <th scope="col" class="text-center">No. BPB</th>
                                    <th scope="col" class="text-center text-nowrap">Tgl Terbit</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Supplier</th>
                                    <th scope="col" class="text-center">Tagihan</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
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
    var trxno = "{{ $data->fc_trxno }}";
    var encode_trxno = window.btoa(trxno);
    var url_debit = "/apps/transaksi/edit/edit-debit/" + encode_trxno;
    $("#form_submit_debit").attr("action", url_debit)
    var url_kredit = "/apps/transaksi/edit/edit-kredit/" + encode_trxno;
    $("#form_submit_kredit").attr("action", url_kredit)
    var url_submit = "/apps/transaksi/edit/submit-edit/" + encode_trxno;
    $("#form_submit_edit").attr("action", url_submit);

    let previledgeDebit = "{{ $data->mapping->fc_debit_previledge }}";
    let previledgeCredit = "{{ $data->mapping->fc_credit_previledge }}";
    var createBy = "{{ $data->mapping->created_by }}";
    var fc_balancerelation = "{{ $data->mapping->fc_balancerelation }}";
    var balancerelation_encode = window.btoa(fc_balancerelation);
    var referenceBpb = null;
    var referenceInvoice = null;

    if (previledgeCredit.includes('ONCE')) {
        $('#btn-kredit').prop('hidden', true);
    } else if (previledgeDebit.includes('ONCE')) {
        $('#btn-debit').prop('hidden', true);
    } else {
        $('#btn-kredit').prop('hidden', false);
        $('#btn-debit').prop('hidden', false);
    }

    $(document).ready(function() {
        get_data_payment();
        get_coa();
        get_coa_kredit();
    })

    function edit_pembayaran(button) {
        var id = $(button).data('rownum');
        var method = $(button).data('method');
        var nominal = $(button).data('nominal');
        var refno = $(button).data('refno');
        var agingref = $(button).data('agingref');
        var description = $(button).data('description');
        var newdescription = $(`#fv_description_${id}`).val();
        $('#modal_pembayaran').modal('show');
        $('#fn_rownum').val(id);
        $('#fc_paymentmethod_edit').val(method);
        $('#fv_description_payment').val(newdescription);

        if ($('#fc_paymentmethod_edit').val() === 'GIRO' ){
            $('#no_giro_edit').attr('hidden', false);
            $('#tgl_giro_edit').attr('hidden', false);
            $('#fc_refno_edit').val(refno);
            $('#fd_agingref_edit').val(agingref);
        }
    }

    $.ajax({
        url: "/apps/transaksi/data/" + encode_trxno,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var count_data = data.data.length;
            // console.log(count_data);
            let debit = 0;
            let kredit = 0;
            let balance = 0;

            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i].fc_statuspos == 'D') {
                    debit += parseFloat(data.data[i].fm_nominal);
                } else {
                    kredit += parseFloat(data.data[i].fm_nominal);
                }
            }

            balance = debit - kredit;

            if (balance == 0 && debit !== 0 && kredit !== 0) {
                $('#status_balance').val('true');
                $('#jumlah_balance').val(parseFloat(debit));
                $('#balance').html("Rp. 0");
                iziToast.info({
                    title: 'Info!',
                    message: 'Debit dan Kredit sudah Balance, Anda bisa melakukan Submit',
                    position: 'topRight'
                });
            } else if (count_data == 0) {
                $('#balance').html("Rp. 0");
                iziToast.warning({
                    title: 'Warning!',
                    message: 'Anda belum mengisi Data Kredit dan Debit',
                    position: 'topRight'
                });
            } else if (debit == 0 && kredit == 0) {
                $('#balance').html("Rp. 0");
                iziToast.warning({
                    title: 'Warning!',
                    message: 'Anda belum mengisi Nominal Kredit dan Debit',
                    position: 'topRight'
                });
            } else {
                $('#status_balance').val('false');
                $('#balance').html(fungsiRupiahSystem(parseFloat(balance)));
                iziToast.info({
                    title: 'Info!',
                    message: 'Kurang ' + fungsiRupiahSystem(parseFloat(balance)) + ' agar Balance',
                    position: 'topRight'
                });
            }
            $('#debit').html(fungsiRupiahSystem(parseFloat(debit)));
            $('#kredit').html(fungsiRupiahSystem(parseFloat(kredit)));
        }
    });


    function add_debit() {
        $('#fc_paymentmethod').prop('disabled', false);
        $('#fc_paymentmethod_hidden').empty();
        $('#modal_debit').modal('show');
    }

    function add_kredit() {
        $('#fc_paymentmethod_kredit').prop('disabled', false);
        $('#modal_kredit').modal('show');
    }

    function get_data_payment() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/PAYMENTACC",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_paymentmethod_edit").empty();
                    $("#fc_paymentmethod_edit").append(`<option value="" selected disabled> - Pilih - </option>`);
                    $("#fc_paymentmethod_kredit").empty();
                    $("#fc_paymentmethod_kredit").append(`<option value="" selected disabled> - Pilih - </option>`);
                    $("#fc_paymentmethod").empty();
                    $("#fc_paymentmethod").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_paymentmethod").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        $("#fc_paymentmethod_kredit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        $("#fc_paymentmethod_edit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }

                    $("#fc_paymentmethod").change(function() {
                        if ($('#fc_paymentmethod').val() === "GIRO") {
                            $('#no_giro').attr('hidden', false);
                            $('#tgl_giro').attr('hidden', false);
                            $('#fc_refno').attr('required', true);
                            $('#fd_agingref').attr('required', true);
                        } else {
                            $('#no_giro').attr('hidden', true);
                            $('#tgl_giro').attr('hidden', true);
                            $('#fc_refno').attr('required', false);
                            $('#fd_agingref').attr('required', false);
                            $('input[id="fc_refno"]').val("");
                            $('input[id="fd_agingref"]').val("");
                        }
                    });

                    $("#fc_paymentmethod_kredit").change(function() {
                        if ($('#fc_paymentmethod_kredit').val() === "GIRO") {
                            $('#no_giro_kredit').attr('hidden', false);
                            $('#tgl_giro_kredit').attr('hidden', false);
                            $('#fc_refno_kredit').attr('required', true);
                            $('#fd_agingref_kredit').attr('required', true);
                        } else {
                            $('#no_giro_kredit').attr('hidden', true);
                            $('#tgl_giro_kredit').attr('hidden', true);
                            $('#fc_refno_kredit').attr('required', false);
                            $('#fd_agingref_kredit').attr('required', false);
                            $('input[id="fc_refno_kredit"]').val("");
                            $('input[id="fd_agingref_kredit"]').val("");
                        }
                    });

                    $("#fc_paymentmethod_edit").change(function() {
                        if ($('#fc_paymentmethod_edit').val() === "GIRO") {
                            $('#no_giro_edit').attr('hidden', false);
                            $('#tgl_giro_edit').attr('hidden', false);
                            $('#fc_refno_edit').attr('required', true);
                            $('#fd_agingref_edit').attr('required', true);
                        } else {
                            $('#no_giro_edit').attr('hidden', true);
                            $('#tgl_giro_edit').attr('hidden', true);
                            $('#fc_refno_edit').attr('required', false);
                            $('#fd_agingref_edit').attr('required', false);
                            $('input[id="fc_refno_edit"]').val("");
                            $('input[id="fd_agingref_edit"]').val("");
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
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function get_data_coa() {
        $('#modal_loading').modal('show');
        var fc_coacode = window.btoa($('#fc_coacode').val());
        // console.log(fc_coacode);
        $.ajax({
            url: "/apps/transaksi/detail/" + fc_coacode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    var value = data[0].mst_coa.fc_directpayment;
                    $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                    if (value == "F") {
                        $('#fc_paymentmethod').append(`<option value="NON" selected>NON DIRECT PAYMENT</option>`);
                        $('#fc_paymentmethod').prop('disabled', true);
                        $('#fc_paymentmethod_hidden').val("NON");
                    }
                    var value2 = data[0].mst_coa.fc_balancestatus;
                    $("input[name=fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                    if (data[0].mst_coa.transaksitype == null) {
                        $('#fc_group').append(`<option value="" selected>-</option>`);
                    }
                    $('#fc_group').append(`<option value="${data[0].mst_coa.fc_group}" selected>${data[0].mst_coa.transaksitype.fv_description}</option>`);

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

    function get_data_coa_kredit() {
        $('#modal_loading').modal('show');
        var fc_coacode = window.btoa($('#fc_coacode_kredit').val());
        // console.log(fc_coacode);
        $.ajax({
            url: "/apps/transaksi/detail/kredit/" + fc_coacode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    var value = data[0].mst_coa.fc_directpayment;
                    $("input[name=fc_directpayment_kredit][value=" + value + "]").prop('checked', true);
                    if (value == "F") {
                        $('#fc_paymentmethod_kredit').append(`<option value="NON" selected>NON DIRECT PAYMENT</option>`);
                        $('#fc_paymentmethod_kredit').prop('disabled', true);
                        $('#fc_paymentmethod_kredit_hidden').val("NON");
                    }
                    var value2 = data[0].mst_coa.fc_balancestatus;
                    $("input[name=fc_balancestatus_kredit][value=" + value2 + "]").prop('checked', true);
                    if (data[0].mst_coa.transaksitype == null) {
                        $('#fc_group_kredit').append(`<option value="" selected>-</option>`);
                    } else {
                        $('#fc_group_kredit').append(`<option value="${data[0].mst_coa.fc_group}" selected disabled>${data[0].mst_coa.transaksitype.fv_description}</option>`);
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

    function get_coa() {
        var mappingMst = window.btoa("{{ $data->fc_mappingcode }}");

        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/transaksi/detail/get-coa/" + mappingMst,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_coacode").empty();
                    $("#fc_coacode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_coacode").append(`<option value="${data[i].fc_coacode}">${data[i].mst_coa.fc_coaname}</option>`);
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

    function get_coa_kredit() {
        var mappingMst = window.btoa("{{ $data->fc_mappingcode }}");
        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/transaksi/detail/get-coa-kredit/" + mappingMst,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_coacode_kredit").empty();
                    $("#fc_coacode_kredit").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_coacode_kredit").append(`<option value="${data[i].fc_coacode}">${data[i].mst_coa.fc_coaname}</option>`);
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

    var tb_debit = $('#tb_debit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/data-debit/" + encode_trxno,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                data: null,
                render: function(data, type, full, meta) {
                    var isNominalReadOnly = previledgeDebit.includes('VALUE');
                    var readOnlyAttribute = isNominalReadOnly ? 'readonly' : '';
                    if (previledgeDebit.includes('ONCE')) {
                        return `<input type="text" id="fm_nominal_${data.fn_rownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_nominal)}" readonly>`;
                    } else {
                        return `<input type="text" id="fm_nominal_${data.fn_rownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_nominal)}" ${readOnlyAttribute}>`;
                    }
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
                data: null,
                render: function(data, type, full, meta) {
                    var isDescReadOnly = previledgeDebit.includes('DESC');
                    var readOnlyAttribute = isDescReadOnly ? 'readonly' : '';
                    if (data.fv_description == null) {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="" class="form-control" ${readOnlyAttribute}>`;
                    } else {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="${data.fv_description}" class="form-control" ${readOnlyAttribute}>`;
                    }
                }
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_trxno = window.btoa(data.fc_trxno);
            var fc_coacode = window.btoa(data.fc_coacode);
            var fc_mappingcode = "{{ $data->fc_mappingcode }}";
            var encode_fc_mappingcode = btoa(fc_mappingcode);
            var url_delete = "/apps/transaksi/edit/delete/" + fc_trxno + "/" + data.fc_coacode + "/" + data.fn_rownum + "/" + balancerelation_encode + "/" + encode_fc_mappingcode;
            // console.log(url_delete);

            if (previledgeDebit.includes('ONCE') && data.coamst.fc_directpayment == 'T') {
                $('td:eq(8)', row).html(`
                <button type="submit" class="btn btn-warning btn-sm mr-1" data-rownum="${data.fn_rownum}" data-method="${data.fc_paymentmethod}" data-refno="${data.fc_refno}" data-agingref="${data.fd_agingref}" data-description="${data.fv_description}" data-nominal="${data.fm_nominal}" data-tipe="D" onclick="edit_pembayaran(this)"><i class="fas fa-edit"> </i></button>
                `);
            } else if (previledgeDebit.includes('ONCE') && data.coamst.fc_directpayment != 'T') {
                $('td:eq(8)', row).html(` `)
            } else {
                $('td:eq(8)', row).html(`
                <button type="submit" class="btn btn-warning btn-sm mr-1" data-rownum="${data.fn_rownum}" data-nominal="${data.fm_nominal}" data-description="${data.fv_description}" data-tipe="D" onclick="editDetailTransaksi(this)"><i class="fas fa-edit"> </i></button>
                <button class="btn btn-danger btn-sm" onclick="click_delete('${url_delete}','${data.coamst.fc_coaname}')"><i class="fa fa-trash"> </i></button>
                `);
            }
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
            url: "/apps/transaksi/data-kredit/" + encode_trxno,
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
                data: 'fc_coacode',
                "width": "20px"
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    var isNominalReadOnly = previledgeCredit.includes('VALUE');
                    var readOnlyAttribute = isNominalReadOnly ? 'readonly' : '';
                    if (previledgeCredit.includes('ONCE')) {
                        return `<input type="text" id="fm_nominal_${data.fn_rownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_nominal)}" readonly>`;
                    } else {
                        return `<input type="text" id="fm_nominal_${data.fn_rownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_nominal)}" ${readOnlyAttribute}>`;
                    }
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
                data: null,
                render: function(data, type, full, meta) {
                    var isDescReadOnly = previledgeCredit.includes('DESC');
                    var readOnlyAttribute = isDescReadOnly ? 'readonly' : '';
                    if (data.fv_description == null) {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="" class="form-control" ${readOnlyAttribute}>`;
                    } else {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="${data.fv_description}" class="form-control" ${readOnlyAttribute}>`;
                    }
                }
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_trxno = window.btoa(data.fc_trxno);
            var fc_mappingcode = "{{ $data->fc_mappingcode }}";
            var encode_fc_mappingcode = btoa(fc_mappingcode);
            var url_delete = "/apps/transaksi/edit/delete/" + fc_trxno + "/" + data.fc_coacode + "/" + data.fn_rownum + "/" + balancerelation_encode + "/" + encode_fc_mappingcode;
            var fc_coacode = window.btoa(data.fc_coacode);
            // console.log(fc_coacode)

            if (previledgeDebit.includes('ONCE') && data.coamst.fc_directpayment == 'T') {
                $('td:eq(8)', row).html(`
                <button type="submit" class="btn btn-warning btn-sm mr-1" data-rownum="${data.fn_rownum}" data-method="${data.fc_paymentmethod}" data-refno="${data.fc_refno}" data-agingref="${data.fd_agingref}" data-nominal="${data.fm_nominal}" data-description="${data.fv_description}" data-tipe="C" onclick="edit_pembayaran(this)"><i class="fas fa-edit"> </i></button>
                `)
            } else if (previledgeCredit.includes('ONCE') && data.coamst.fc_directpayment != 'T') {
                $('td:eq(8)', row).html(` `)
            } else {
                $('td:eq(8)', row).html(`
                <button type="submit" class="btn btn-warning btn-sm mr-1" data-rownum="${data.fn_rownum}" data-nominal="${data.fm_nominal}" data-description="${data.fv_description}" data-tipe="C" onclick="editDetailTransaksi(this)"><i class="fas fa-edit"> </i></button>
                <button class="btn btn-danger btn-sm" onclick="click_delete('${url_delete}','${data.coamst.fc_coaname}')"><i class="fa fa-trash"> </i></button>
                `);
            }
        },
    });

    function editDetailTransaksi(button) {
        var rownum = $(button).data('rownum');
        var nominal = $(button).data('nominal');
        var description = $(button).data('description');
        var newnominal = $(`#fm_nominal_${rownum}`).val().toString().replace('.', '');
        var newdescription = $(`#fv_description_${rownum}`).val();
        var tipe = $(button).data('tipe');
        var fc_mappingcode = "{{ $data->fc_mappingcode }}";
        var encode_mappingcode = btoa(fc_mappingcode);
        // console.log(tipe)

        swal({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin update data tersebut?",
            icon: "warning",
            buttons: ["Cancel", "Update"],
            dangerMode: true,
        }).then(function(confirm) {
            if (confirm) {
                if (tipe == 'D') {
                    updateDebitTransaksi(rownum, newnominal, newdescription, encode_mappingcode);
                } else {
                    updateKreditTransaksi(rownum, newnominal, newdescription, encode_mappingcode);
                }

            }
        });
    }

    function updateDebitTransaksi(rownum, nominal, description, encode_mappingcode) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/transaksi/edit/update-edit-debit-transaksi/' + encode_trxno,
            type: 'PUT',
            data: {
                fn_rownum: rownum,
                fm_nominal: nominal,
                fv_description: description,
                fc_mappingcode: encode_mappingcode,
                fc_debit_previledge: previledgeDebit,
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    window.location.href = window.location.href;
                    tb_debit.ajax.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function updateKreditTransaksi(rownum, nominal, description, encode_mappingcode) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/transaksi/edit/update-edit-kredit-transaksi/' + encode_trxno,
            type: 'PUT',
            data: {
                fn_rownum: rownum,
                fm_nominal: nominal,
                fv_description: description,
                fc_mappingcode: encode_mappingcode,
                fc_credit_previledge: previledgeCredit,
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    window.location.href = window.location.href;
                    tb_kredit.ajax.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    $('#form_submit_debit').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_submit_debit').attr('action'),
                        type: $('#form_submit_debit').attr('method'),
                        data: $('#form_submit_debit').serialize(),
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal_debit").modal('hide');
                                $("#form_submit_debit")[0].reset();
                                reset_all_select();
                                tb_debit.ajax.reload(null, false);

                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                location.href = response.link;
                            } else if (response.status == 203) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
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
                }
            });
    });

    $('#form_submit_kredit').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_submit_kredit').attr('action'),
                        type: $('#form_submit_kredit').attr('method'),
                        data: $('#form_submit_kredit').serialize(),
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal_kredit").modal('hide');
                                $("#form_submit_kredit")[0].reset();
                                reset_all_select();
                                tb_kredit.ajax.reload(null, false);

                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                location.href = response.link;
                            } else if (response.status == 203) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
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
                }
            });
    });

    function click_delete(url, nama) {
        swal({
                title: 'Konfirmasi?',
                text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            //  tb.ajax.reload(null, false);
                            //  console.log(response.status);
                            if (response.status == 200) {
                                // console.log(tb_debit);
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
                                tb_kredit.ajax.reload(null, false);
                                window.location.href = window.location.href;
                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
                                tb_kredit.ajax.reload(null, false);
                                window.location.href = window.location.href;
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
            });
    }

    var fc_docreference = "{{ base64_encode($data->fc_docreference) }}"

    function look_inv(value) {
        referenceInvoice = value;
        if (tb_invoice.rows().data().length === 0) {
            swal("Tidak terdapat data COA yang relevan.", {
                icon: 'error',
            });
        } else {
            $("#modal_invoice").modal('show');
        }
    }

    var tb_invoice = $('#tb_invoice').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/transaksi/detail/datatables-invoice/' + fc_docreference,
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: []
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
                data: 'domst.fc_dono',
                defaultContent: '-'
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
                data: 'customer.fc_membername1',
                defaultContent: '-'
            },
            {
                data: null,
                render: function(data, type, row) {
                    nominal = data.fm_brutto - data.fm_paidvalue;
                    return $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(nominal);
                }
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_invno = window.btoa(data.fc_invno);
            var nominal = data.fm_brutto - data.fm_paidvalue;

            $('td:eq(7)', row).html(`
            <button type="button" class="btn btn-warning btn-sm mr-1" onclick="select_inv('${data.fc_invno}','${nominal}')"><i class="fa fa-check"></i> Pilih</button>`)
        }
    });

    function select_inv(fc_invno, nominal) {
        $("#modal_loading").modal('show');
        var fc_mappingcode = "{{ $data->fc_mappingcode }}";
        var encode_fc_mappingcode = btoa(fc_mappingcode);
        $.ajax({
            url: '/apps/transaksi/edit/store-from-inv',
            type: 'POST',
            data: {
                fc_invno: fc_invno,
                nominal: nominal,
                fc_docreference: fc_docreference,
                reference_invoice: referenceInvoice,
                fc_trxno: encode_trxno,
                fc_mappingcode: encode_fc_mappingcode
            },
            success: function(response) {
                if (response.status === 200) {
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#modal_invoice').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    tb_debit.ajax.reload();
                    tb_kredit.ajax.reload();
                    window.location.href = window.location.href;
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

    function look_bpb(value) {
        referenceBpb = value;
        if (tb_bpb.rows().data().length === 0) {
            swal("Tidak terdapat data COA yang relevan.", {
                icon: 'error',
            });
        } else {
            $("#modal_bpb").modal('show');
        }
    }

    var tb_bpb = $('#tb_bpb').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/transaksi/detail/datatables-bpb/' + fc_docreference,
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: []
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
                data: 'romst.fc_rono',
                defaultContent: '-'
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
                data: 'supplier.fc_suppliername1',
                defaultContent: '-'
            },
            {
                data: null,
                render: function(data, type, row) {
                    nominal = data.fm_brutto - data.fm_paidvalue;
                    return $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(nominal);
                }
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_invno = window.btoa(data.fc_invno);
            var nominal = data.fm_brutto - data.fm_paidvalue;

            $('td:eq(7)', row).html(`
            <button type="button" class="btn btn-warning btn-sm mr-1" onclick="select_bpb('${data.fc_invno}','${nominal}')"><i class="fa fa-check"></i> Pilih</button>`)
        }
    });

    function select_bpb(fc_invno, nominal) {
        $("#modal_loading").modal('show');
        var fc_mappingcode = "{{ $data->fc_mappingcode }}";
        var encode_fc_mappingcode = btoa(fc_mappingcode);
        $.ajax({
            url: '/apps/transaksi/edit/store-from-bpb',
            type: 'POST',
            data: {
                fc_invno: fc_invno,
                nominal: nominal,
                fc_docreference: fc_docreference,
                reference_bpb: referenceBpb,
                fc_trxno: encode_trxno,
                fc_mappingcode: encode_fc_mappingcode
            },
            success: function(response) {
                if (response.status === 200) {
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#modal_bpb').modal('hide');
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    tb_debit.ajax.reload();
                    tb_kredit.ajax.reload();
                    window.location.href = window.location.href;
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

    function click_opsilanjut() {
        swal({
                title: 'Konfirmasi?',
                text: 'Apakah anda yakin menambahkan opsi lanjutan?',
                icon: 'warning',
                buttons: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/transaksi/edit/update-edit-status-opsi-lanjutan/' + encode_trxno,
                        type: "PUT",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            //  tb.ajax.reload(null, false);
                            //  console.log(response.status);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                window.location.href = window.location.href;
                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
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
            });
    }

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
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_pembayaran").modal('hide');
                    $("#form_update")[0].reset();
                    reset_all_select();
                    tb_debit.ajax.reload(null, false);
                    tb_kredit.ajax.reload(null, false);
                    window.location.href = window.location.href;
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