@extends('partial.app')
@section('title', 'Master Customer')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    select.select2 {
        display: block;
        visibility: visible;
        position: absolute;
        top: 40px;
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Master Customer</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i>
                            Tambah Master Customer</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Divisi</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Kode Customer</th>
                                    <th scope="col" class="text-center">Nama Customer 1</th>
                                    <th scope="col" class="text-center">Nama Customer 2</th>
                                    <th scope="col" class="text-center">Alamat Customer 1</th>
                                    <th scope="col" class="text-center">Alamat Customer 2</th>
                                    <th scope="col" class="text-center">Alamat Customer Loading 1</th>
                                    <th scope="col" class="text-center">Alamat Customer Loading 2</th>
                                    <th scope="col" class="text-center">No. HP Customer 1</th>
                                    <th scope="col" class="text-center">No. HP Customer 2</th>
                                    <th scope="col" class="text-center">No. HP Customer 3</th>
                                    <th scope="col" class="text-center">Web Customer</th>
                                    <th scope="col" class="text-center">Email Customer 1</th>
                                    <th scope="col" class="text-center">Email Customer 2</th>
                                    <th scope="col" class="text-center">Tipe Bisnis Customer</th>
                                    <th scope="col" class="text-center">Tipe Cabang Customer</th>
                                    <th scope="col" class="text-center">Customer Reseller</th>
                                    <th scope="col" class="text-center">Legal Status Customer</th>
                                    <th scope="col" class="text-center">Kode Pajak Customer</th>
                                    <th scope="col" class="text-center">No. NPWP Customer</th>
                                    <th scope="col" class="text-center">Nama NPWP Customer</th>
                                    <th scope="col" class="text-center">Alamat NPWP Customer 1</th>
                                    <th scope="col" class="text-center">Alamat NPWP Customer 2</th>
                                    <th scope="col" class="text-center">Kebangsaan Customer</th>
                                    <th scope="col" class="text-center">Customer Forex</th>
                                    <th scope="col" class="text-center">Hutang Customer</th>
                                    <th scope="col" class="text-center">Masa Hutang Customer</th>
                                    <th scope="col" class="text-center">Kunci Transaksi Customer</th>
                                    <th scope="col" class="text-center">Nama CP 1</th>
                                    <th scope="col" class="text-center">Nama CP 2</th>
                                    <th scope="col" class="text-center">Nama CP 3</th>
                                    <th scope="col" class="text-center">Nama CP 4</th>
                                    <th scope="col" class="text-center">Nama CP 5</th>
                                    <th scope="col" class="text-center">No. HP CP Customer 1</th>
                                    <th scope="col" class="text-center">No. HP CP Customer 2</th>
                                    <th scope="col" class="text-center">No. HP CP Customer 3</th>
                                    <th scope="col" class="text-center">No. HP CP Customer 4</th>
                                    <th scope="col" class="text-center">No. HP CP Customer 5</th>
                                    <th scope="col" class="text-center">Jabatan CP Customer 1</th>
                                    <th scope="col" class="text-center">Jabatan CP Customer 3</th>
                                    <th scope="col" class="text-center">Jabatan CP Customer 2</th>
                                    <th scope="col" class="text-center">Jabatan CP Customer 4</th>
                                    <th scope="col" class="text-center">Jabatan CP Customer 5</th>
                                    <th scope="col" class="text-center">Tanggal Join Customer</th>
                                    <th scope="col" class="text-center">Kontrak Customer</th>
                                    <th scope="col" class="text-center">Bank Customer 1</th>
                                    <th scope="col" class="text-center">Bank Customer 2</th>
                                    <th scope="col" class="text-center">Bank Customer 3</th>
                                    <th scope="col" class="text-center">Virtual Ac Customer</th>
                                    <th scope="col" class="text-center">Norek Customer 1</th>
                                    <th scope="col" class="text-center">Norek Customer 2</th>
                                    <th scope="col" class="text-center">Norek Customer 3</th>
                                    <th scope="col" class="text-center">Deskripsi Customer</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')


<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch }}" readonly hidden>
            <form id="form_submit" action="/data-master/master-customer/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Kode Divisi</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Kode Customer</label>
                                <input type="text" class="form-control required-field" readonly name="fc_membercode" id="fc_membercode">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Customer 1</label>
                                <input type="text" class="form-control required-field" name="fc_membername1" id="fc_membername1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Customer 2</label>
                                <input type="text" class="form-control" name="fc_membername2" id="fc_membername2">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Alamat Customer 1</label>
                                <textarea type="text" class="form-control required-field" name="fc_memberaddress1" id="fc_memberaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat Customer 2</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress2" id="fc_memberaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Alamat Customer Loading 1</label>
                                <textarea type="text" class="form-control required-field" name="fc_memberaddress_loading1" id="fc_memberaddress_loading1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat Customer Loading 2</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress_loading2" id="fc_memberaddress_loading2" style="height: 100px"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- contact person input --}}


                    <div class="col-12 col-md-6 col-lg-12 text-right">
                        <div class="button mb-2">
                            <button type="button" id="contact-person" class="btn btn-success" onclick=""><i class="fa fa-plus mr-1"></i> Tambah Contact Person</button>
                        </div>
                    </div>
                    <div class="row contact-person-row">
                        <div class="row w-100 ml-2">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Nama CP Customer 1</label>
                                    <input type="text" class="form-control required-field" name="fc_memberpicname" id="fc_memberpicname">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-4">
                                <div class="form-group required">
                                    <label>No. HP CP Customer 1</label>
                                    <input type="text" class="form-control required-field" name="fc_memberpicphone" id="fc_memberpicphone">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group required">
                                    <label>Jabatan CP Customer 1</label>
                                    <input type="text" class="form-control required-field" name="fc_memberpicpos" id="fc_memberpicpos">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-1">
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-danger" onclick=""><i class="fa fa-minus mr-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- end contact person --}}


                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Legal Status Customer</label>
                                <select class="select2 required-field" name="fc_memberlegalstatus" id="fc_memberlegalstatus" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Kebangsaan Customer</label>
                                <select class="select2 required-field" name="fc_membernationality" id="fc_membernationality" onchange="change_nationality()" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Forex</label>
                                <input type="text" readonly class="form-control" name="fc_memberforex" id="fc_memberforex">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Bisnis Customer</label>
                                <select class="select2" name="fc_membertypebusiness" id="fc_membertypebusiness" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tanggal Join Customer</label>
                                <input type="text" class="form-control datepicker" name="fd_memberjoindate" id="fd_memberjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Kontrak Customer</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_membercontract" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">YES</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_membercontract" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">NO</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Reseller</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_memberreseller" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_memberreseller" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Kode Pajak Customer</label>
                                <select class="select2 required-field" name="fc_membertaxcode" id="fc_membertaxcode" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="form-group required">
                                <label>Tipe Cabang</label>
                                <select class="select2 required-field" class="form-control required-field" name="fc_member_branchtype" id="fc_member_branchtype" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="form-group required">
                                <label>NPWP Customer</label>
                                <input type="text" class="form-control required-field" name="fc_membernpwp_no" id="fc_membernpwp_no">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Nama NPWP Customer</label>
                                <input type="text" class="form-control required-field" name="fc_membernpwp_name" id="fc_membernpwp_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Alamat NPWP Customer 1</label>
                                <textarea type="text" class="form-control required-field" name="fc_member_npwpaddress1" id="fc_member_npwpaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat NPWP Customer 2</label>
                                <textarea type="text" class="form-control" name="fc_member_npwpaddress2" id="fc_member_npwpaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Email Customer 1</label>
                                <input type="text" class="form-control required-field" name="fc_memberemail1" id="fc_memberemail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Email Customer 2</label>
                                <input type="text" class="form-control" name="fc_memberemail2" id="fc_memberemail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No. HP Customer 1</label>
                                <input type="text" class="form-control required-field" name="fc_memberphone1" id="fc_memberphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Customer 2</label>
                                <input type="text" class="form-control" name="fc_memberphone2" id="fc_memberphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Customer 3</label>
                                <input type="text" class="form-control" name="fc_memberphone3" id="fc_memberphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>Bank Customer 1</label>
                                <select class="form-control select2 required-field" name="fc_memberbank1" id="fc_memberbank1" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Customer 2</label>
                                <select class="form-control select2" name="fc_memberbank2" id="fc_memberbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Customer 3</label>
                                <select class="form-control select2" name="fc_memberbank3" id="fc_memberbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No Rekening Customer 1</label>
                                <input type="text" class="form-control required-field" name="fc_membernorek1" id="fc_membernorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No Rekening Customer 2</label>
                                <input type="text" class="form-control" name="fc_membernorek2" id="fc_membernorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No Rekening Customer 3</label>
                                <input type="text" class="form-control" name="fc_membernorek3" id="fc_membernorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Virtual AC Customer</label>
                                <input type="text" class="form-control" name="fc_membervirtualac" id="fc_membervirtualac">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Hutang Customer</label>
                                <input type="text" class="form-control" readonly name="fm_memberAP" id="fm_memberAP" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Masa Hutang Customer</label>
                                <input type="number" class="form-control" name="fn_memberAgingAP" id="fn_memberAgingAP">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Kunci Transaksi</label>
                                <select class="form-control select2" name="fc_memberlockTransType" id="fc_memberlockTransType"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi Customer</label>
                                <textarea name="fv_memberdescription" id="fv_memberdescription" style="height: 90px" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    // add contact person
    $(document).ready(function() {
        var count = 1;
        $("#contact-person").click(function() {

            if (count < 5) {
                count++;
                $(".contact-person-row").append(`
                <div class="row w-100 ml-2 row-input">
                <div class="col-12 col-md-6 col-lg-4 input-contact-person">
                    <div class="form-group">
                    <label>Nama CP Customer ` + count + `</label>
                    <input type="text" class="form-control" name="fc_memberpicname` + count +
                    `" id="fc_memberpicname` + count + `">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-4 input-contact-person">
                    <div class="form-group">
                    <label>No. HP CP Customer ` + count + `</label>
                    <input type="text" class="form-control" name="fc_memberpicphone` + count +
                    `" id="fc_memberpicphone` +
                    count + `">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-3 input-contact-person">
                    <div class="form-group">
                    <label>Jabatan CP Customer ` + count + `</label>
                    <input type="text" class="form-control" name="fc_memberpicpos` + count + `" id="fc_memberpicpos` +
                    count + `">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-1 input-contact-person">
                    <div class="text-center mt-4">
                    <button type="button" class="btn btn-danger remove-input" onclick=""><i class="fa fa-minus mr-1"></i></button>
                    </div>
                </div>
                </div>
                `);
            } else {
                // munculkan alert error
                alert("Maximal input 5");
            }
        });

        // Remove input
        $(document).on('click', '.remove-input', function() {
            count--;
            console.log(count);
            $(this).closest('.row-input').remove();
        });

    });

    $(document).ready(function() {
        get_data_branch();
        get_data_legal_status();
        get_data_nationality();
        get_data_type_business();
        get_data_tax_code();
        get_data_member_lock_code();
        get_data_member_bank();
        get_data_branch_type();
    })

    function generate_no_document() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/generate-no-document",
            type: "GET",
            data: {
                'fv_document': 'CUSTOMER',
                'fc_branch': "{{ auth()->user()->fc_branch }}",
                'fv_part': null,
                'fc_divisioncode': "{{ auth()->user()->fc_divisioncode}}"
            },
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    $('#fc_membercode').val(response.data);
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

    function change_nationality() {
        $('#fc_memberforex').val($('#fc_membernationality').val());
    }

    function get_data_branch() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].fc_kode == $('#fc_branch_view').val()) {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        } else {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
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

    function get_data_legal_status() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_LEGAL",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_memberlegalstatus").empty();
                    $("#fc_memberlegalstatus").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberlegalstatus").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_nationality() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/NATIONALITY",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_membernationality").empty();
                    $("#fc_membernationality").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membernationality").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_type_business() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/MEMBER_BUSI_TYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_membertypebusiness").empty();
                    $("#fc_membertypebusiness").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membertypebusiness").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_tax_code() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_TAXTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_membertaxcode").empty();
                    $("#fc_membertaxcode").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membertaxcode").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_member_lock_code() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_LOCKTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_memberlockTransType").empty();
                    $("#fc_memberlockTransType").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberlockTransType").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_member_bank() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BANKNAME",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_memberbank1").empty();
                    $("#fc_memberbank1").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_memberbank2").empty();
                    $("#fc_memberbank2").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_memberbank3").empty();
                    $("#fc_memberbank3").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberbank1").append(
                            `<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_memberbank2").append(
                            `<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_memberbank3").append(
                            `<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
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

    function get_data_branch_type() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_TYPEOFFICE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_member_branchtype").empty();
                    $("#fc_member_branchtype").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_member_branchtype").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master Customer');
        $("#form_submit")[0].reset();
        change_nationality();
        generate_no_document();
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/data-master/master-customer/datatables',
            type: 'GET',
            datatype: 'json',
            lengthMenu: [10],
            paging: true,
        },
        pageLength : 5,
        columnDefs: [{
                className: 'text-center',
                targets: [0, 18, 46]
            },
            {
                className: 'd-flex',
                targets: [51]
            },
            {
                className: 'text-nowrap',
                targets: [55]
            }
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode',
                defaultContent: '',
            },
            {
                data: 'branch.fv_description',
                defaultContent: '',
            },
            {
                data: 'fc_membercode',
                defaultContent: '',
            },
            {
                data: 'fc_membername1',
                defaultContent: '',
            },
            {
                data: 'fc_membername2',
                defaultContent: '',
            },
            {
                data: 'fc_memberaddress1',
                defaultContent: '',
            },
            {
                data: 'fc_memberaddress2',
                defaultContent: '',
            },
            {
                data: 'fc_memberaddress_loading1',
                defaultContent: '',
            },
            {
                data: 'fc_memberaddress_loading2',
                defaultContent: '',
            },
            {
                data: 'fc_memberphone1',
                defaultContent: '',
            },
            {
                data: 'fc_memberphone2',
                defaultContent: '',
            },
            {
                data: 'fc_memberphone3',
                defaultContent: '',
            },
            {
                data: 'fc_memberweb',
                defaultContent: '',
            },
            {
                data: 'fc_memberemail1',
                defaultContent: '',
            },
            {
                data: 'fc_memberemail2',
                defaultContent: '',
            },
            {
                data: 'member_type_business.fv_description',
                defaultContent: '',
            },
            {
                data: 'member_typebranch.fv_description'
            },
            {
                data: 'fl_memberreseller',
                defaultContent: '',
            },
            {
                data: 'member_legal_status.fv_description',
                defaultContent: '',
            },
            {
                data: 'member_tax_code.fv_description',
                defaultContent: '',
            },
            {
                data: 'fc_membernpwp_no',
                defaultContent: '',
            },
            {
                data: 'fc_membernpwp_name',
                defaultContent: '',
            },
            {
                data: 'fc_member_npwpaddress1',
                defaultContent: '',
            },
            {
                data: 'fc_member_npwpaddress2',
                defaultContent: '',
            },
            {
                data: 'member_nationality.fv_description',
                defaultContent: '',
            },
            {
                data: 'fc_memberforex',
                defaultContent: '',
            },
            {
                data: 'fm_memberAP',
                defaultContent: '',
            },
            {
                data: 'fn_memberAgingAP',
                defaultContent: '',
            },
            {
                data: 'fc_memberlockTransType',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicname',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicname2',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicname3',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicname4',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicname5',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicphone',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicphone2',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicphone3',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicphone4',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicphone5',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos2',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos3',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos4',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos5',
                defaultContent: '',
            },
            {
                data: 'fd_memberjoindate',
                defaultContent: '',
            },
            {
                data: 'fl_membercontract',
                defaultContent: '',
            },
            {
                data: 'fc_memberbank1',
                defaultContent: '',
            },
            {
                data: 'fc_memberbank2',
                defaultContent: '',
            },
            {
                data: 'fc_memberbank3',
                defaultContent: '',
            },
            {
                data: 'fc_membervirtualac',
                defaultContent: '',
            },
            {
                data: 'fc_membernorek1',
                defaultContent: '',
            },
            {
                data: 'fc_membernorek2',
                defaultContent: '',
            },
            {
                data: 'fc_membernorek3',
                defaultContent: '',
            },
            {
                data: 'fv_memberdescription',
                defaultContent: '',
            },
            {
                data: 'fc_memberpicpos',
                defaultContent: '',
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-customer/detail/" + data.fc_divisioncode + '/' + data
                .fc_branch + '/' + data.fc_membercode;
            var url_delete = "/data-master/master-customer/delete/" + data.fc_divisioncode + '/' + data
                .fc_branch + '/' + data.fc_membercode;
            
            if (data['fl_memberreseller'] == 'F') {
                $('td:eq(18)', row).html('<span class="badge badge-danger">No</span>');
            } else {
                $('td:eq(18)', row).html('<span class="badge badge-success">Yes</span>');
            }

            if (data['fl_membercontract'] == 'F') {
                $('td:eq(46)', row).html('<span class="badge badge-danger">No</span>');
            } else {
                $('td:eq(46)', row).html('<span class="badge badge-success">Yes</span>');
            }
            
            $('td:eq(55)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_membername1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
        }
    });

    function edit(url) {
        edit_action(url, 'Edit Data Master Customer');
        $("#type").val('update');
        $('#fc_branch').attr("disabled", true);
    }
</script>
@endsection