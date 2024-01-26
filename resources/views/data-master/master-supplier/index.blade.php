@extends('partial.app')
@section('title','Master Supplier')
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
                    <h4>Data Master Supplier</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Supplier</button>
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
                                    <th scope="col" class="text-center">Kode Supplier</th>
                                    <th scope="col" class="text-center">Legal Status Supplier</th>
                                    <th scope="col" class="text-center">Nama Supplier 1</th>
                                    <th scope="col" class="text-center">Nama Supplier 2</th>
                                    <th scope="col" class="text-center">No. HP Supplier 1</th>
                                    <th scope="col" class="text-center">No. HP Supplier 2</th>
                                    <th scope="col" class="text-center">No. HP Supplier 3</th>
                                    <th scope="col" class="text-center">Email Supplier 1</th>
                                    <th scope="col" class="text-center">Email Supplier 2</th>
                                    <th scope="col" class="text-center">Kebangsaan Supplier</th>
                                    <th scope="col" class="text-center">Supplier Forex</th>
                                    <th scope="col" class="text-center">Tipe Bisnis Supplier</th>
                                    <th scope="col" class="text-center">Tipe Cabang Supplier</th>
                                    <th scope="col" class="text-center">Supplier Reseller</th>
                                    <th scope="col" class="text-center">Kode Pajak Supplier</th>
                                    <th scope="col" class="text-center">NPWP Supplier</th>
                                    <th scope="col" class="text-center">Nama NPWP Supplier</th>
                                    <th scope="col" class="text-center">Alamat NPWP Supplier 1</th>
                                    <th scope="col" class="text-center">Alamat NPWP Supplier 2</th>
                                    <th scope="col" class="text-center">Hutang Supplier</th>
                                    <th scope="col" class="text-center">Masa Hutang Supplier</th>
                                    <th scope="col" class="text-center">Kunci Supplier</th>
                                    <th scope="col" class="text-center">Nama PIC Supplier 1</th>
                                    <th scope="col" class="text-center">Nama PIC Supplier 2</th>
                                    <th scope="col" class="text-center">Nama PIC Supplier 3</th>
                                    <th scope="col" class="text-center">Nama PIC Supplier 4</th>
                                    <th scope="col" class="text-center">Nama PIC Supplier 5</th>
                                    <th scope="col" class="text-center">No. HP PIC Supplier 1</th>
                                    <th scope="col" class="text-center">No. HP PIC Supplier 2</th>
                                    <th scope="col" class="text-center">No. HP PIC Supplier 3</th>
                                    <th scope="col" class="text-center">No. HP PIC Supplier 4</th>
                                    <th scope="col" class="text-center">No. HP PIC Supplier 5</th>
                                    <th scope="col" class="text-center">Jabatan PIC Supplier 1</th>
                                    <th scope="col" class="text-center">Jabatan PIC Supplier 2</th>
                                    <th scope="col" class="text-center">Jabatan PIC Supplier 3</th>
                                    <th scope="col" class="text-center">Jabatan PIC Supplier 4</th>
                                    <th scope="col" class="text-center">Jabatan PIC Supplier 5</th>
                                    <th scope="col" class="text-center">Tanggal Join Supplier</th>
                                    <th scope="col" class="text-center">Supplier Expired</th>
                                    <th scope="col" class="text-center">Bank Supplier 1</th>
                                    <th scope="col" class="text-center">Bank Supplier 2</th>
                                    <th scope="col" class="text-center">Bank Supplier 3</th>
                                    <th scope="col" class="text-center">Virtual Acc Supplier</th>
                                    <th scope="col" class="text-center">Norek Supplier 1</th>
                                    <th scope="col" class="text-center">Norek Supplier 2</th>
                                    <th scope="col" class="text-center">Norek Supplier 3</th>
                                    <th scope="col" class="text-center">Deskripsi Supplier</th>
                                    <th scope="col" class="text-center" style="width: 20%;">Actions</th>
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
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-supplier/store-update" method="POST" autocomplete="off">
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
                                <select class="form-control select2" name="fc_branch" id="fc_branch" required></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Kode Supplier</label>
                                <input type="text" class="form-control required-field" name="fc_suppliercode" id="fc_suppliercode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Supplier 1</label>
                                <input type="text" class="form-control required-field" name="fc_suppliername1" id="fc_suppliername1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Supplier 2</label>
                                <input type="text" class="form-control" name="fc_suppliername2" id="fc_suppliername2">
                            </div>
                        </div>
                    </div>

                    {{-- contact person input --}}


                    <div class="col-12 col-md-6 col-lg-12 mr-0 text-right">
                        <div class="button mb-2">
                            <button type="button" id="contact-person" class="btn btn-success" onclick=""><i class="fa fa-plus"></i> Tambah PIC</button>
                        </div>
                    </div>
                    <div class="row contact-person-row">
                        <div class="row w-100 ml-1">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Nama PIC Supplier</label>
                                    <input type="text" class="form-control required-field" name="fc_supplierpicname" id="fc_supplierpicname">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-4">
                                <div class="form-group required">
                                    <label>No. HP PIC Supplier</label>
                                    <input type="text" class="form-control required-field" name="fc_supplierpicphone" id="fc_supplierpicphone">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="form-group required">
                                    <label>Jabatan PIC Supplier</label>
                                    <input type="text" class="form-control required-field" name="fc_supplierpicpos" id="fc_supplierpicpos">
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
                                <label>Legal Status Supplier</label>
                                <select class="select2 required-field" name="fc_supplierlegalstatus" id="fc_supplierlegalstatus" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Kebangsaaan Supplier</label>
                                <select class="select2 required-field" name="fc_suppliernationality" id="fc_suppliernationality" onchange="change_nationality()" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Forex</label>
                                <input type="text" readonly class="form-control" name="fc_supplierforex" id="fc_supplierforex">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Bisnis Supplier</label>
                                <select class="select2 required-field" name="fc_suppliertypebusiness" id="fc_suppliertypebusiness" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Cabang Supplier</label>
                                <select class="select2 required-field" name="fc_branchtype" id="fc_branchtype" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9"></div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tanggal Join Supplier</label>
                                <input type="text" class="form-control datepicker" name="fd_supplierjoindate" id="fd_supplierjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Expired</label>
                                <input type="text" class="form-control datepicker" name="fd_supplierexpired" id="fd_supplierexpired">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Reseller</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Kode Pajak Supplier</label>

                                <select class="select2 required-field" name="fc_suppliertaxcode" id="fc_suppliertaxcode" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>NPWP Supplier</label>
                                <input type="text" class="form-control required-field" name="fc_supplierNPWP" id="fc_supplierNPWP">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama NPWP Supplier</label>
                                <input type="text" class="form-control required-field" name="fc_suppliernpwp_name" id="fc_suppliernpwp_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Alamat NPWP Supplier 1</label>
                                <textarea type="text" class="form-control required-field" name="fc_supplier_npwpaddress1" id="fc_supplier_npwpaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat NPWP Supplier 2</label>
                                <textarea type="text" class="form-control" name="fc_supplier_npwpaddress2" id="fc_supplier_npwpaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Email Supplier 1</label>
                                <input type="text" class="form-control required-field" name="fc_supplieremail1" id="fc_supplieremail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Email Supplier 2</label>
                                <input type="text" class="form-control" name="fc_supplieremail2" id="fc_supplieremail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No. HP Supplier 1</label>
                                <input type="text" class="form-control required-field" name="fc_supplierphone1" id="fc_supplierphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Supplier 2</label>
                                <input type="text" class="form-control" name="fc_supplierphone2" id="fc_supplierphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Supplier 3</label>
                                <input type="text" class="form-control" name="fc_supplierphone3" id="fc_supplierphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>Bank Supplier 1</label>
                                <select class="form-control select2 required-field" name="fc_supplierbank1" id="fc_supplierbank1" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Supplier 2</label>
                                <select class="form-control select2" name="fc_supplierbank2" id="fc_supplierbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Supplier 3</label>
                                <select class="form-control select2" name="fc_supplierbank3" id="fc_supplierbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No Rekening Supplier 1</label>
                                <input type="text" class="form-control required-field" name="fc_suppliernorek1" id="fc_suppliernorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No Rekening Supplier 2</label>
                                <input type="text" class="form-control" name="fc_suppliernorek2" id="fc_suppliernorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No Rekening Supplier 3</label>
                                <input type="text" class="form-control" name="fc_suppliernorek3" id="fc_suppliernorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Virtual AC Supplier</label>
                                <input type="text" class="form-control" name="fc_suppliervirtualac" id="fc_suppliervirtualac">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Hutang Supplier</label>
                                <input type="text" class="form-control" readonly name="fm_supplierAR" id="fm_supplierAR" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Masa Hutang Supplier</label>
                                <input type="number" class="form-control" name="fn_supplierAgingAR" id="fn_supplierAgingAR">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Kunci Transaksi</label>
                                <select class="form-control select2" name="fn_supplierlockTrans" id="fn_supplierlockTrans"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi Supplier</label>
                                <textarea name="fv_supplierdescription" id="fv_supplierdescription" style="height: 90px" class="form-control"></textarea>
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
    $(document).ready(function() {
        get_data_branch();
        get_data_legal_status();
        get_data_nationality();
        get_data_type_business();
        get_data_type_branch()
        get_data_tax_code();
        get_data_supplier_lock_code();
        get_data_supplier_bank();
    })

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
                    <label>Nama PIC Supplier ` + count + `</label>
                    <input type="text" class="form-control" name="fc_supplierpicname` + count +
                    `" id="fc_supplierpicname` + count + `">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-4 input-contact-person">
                    <div class="form-group">
                    <label>No. HP PIC Supplier ` + count + `</label>
                    <input type="text" class="form-control" name="fc_supplierpicphone` + count +
                    `" id="fc_supplierpicphone` +
                    count + `">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-3 input-contact-person">
                    <div class="form-group">
                    <label>Jabatan PIC Supplier ` + count + `</label>
                    <input type="text" class="form-control" name="fc_supplierpicpos` + count + `" id="fc_supplierpicpos` +
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

    function generate_no_document() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/generate-no-document",
            type: "GET",
            data: {
                'fv_document': 'SUPPLIER',
                'fc_branch': "{{ auth()->user()->fc_branch }}",
                'fv_part': null,
                'fc_divisioncode': "{{ auth()->user()->fc_divisioncode }}"
            },
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    $('#fc_suppliercode').val(response.data);
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
        $('#fc_supplierforex').val($('#fc_suppliernationality').val());
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

    
    function get_data_type_branch() {
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
                    $("#fc_branchtype").empty();
                    $("#fc_branchtype").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_branchtype").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_supplierlegalstatus").empty();
                    $("#fc_supplierlegalstatus").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierlegalstatus").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_suppliernationality").empty();
                    $("#fc_suppliernationality").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliernationality").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_suppliertypebusiness").empty();
                    $("#fc_suppliertypebusiness").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertypebusiness").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_suppliertaxcode").empty();
                    $("#fc_suppliertaxcode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertaxcode").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_supplier_lock_code() {
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
                    $("#fn_supplierlockTrans").empty();
                    $("#fn_supplierlockTrans").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fn_supplierlockTrans").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_supplier_bank() {
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
                    $("#fc_supplierbank1").empty();
                    $("#fc_supplierbank1").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_supplierbank2").empty();
                    $("#fc_supplierbank2").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_supplierbank3").empty();
                    $("#fc_supplierbank3").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierbank1").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_supplierbank2").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_supplierbank3").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
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
        $(".modal-title").text('Tambah Master Supplier');
        $("#form_submit")[0].reset();
        change_nationality();
        generate_no_document();
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        ajax: {
            url: '/data-master/master-supplier/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 16]
            },
            {
                className: 'text-nowrap',
                targets: [50]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode'
            },
            {
                data: 'branch.fv_description'
            },
            {
                data: 'fc_suppliercode'
            },
            {
                data: 'supplier_legal_status.fv_description',
                defaultContent: ''
            },
            {
                data: 'fc_suppliername1'
            },
            {
                data: 'fc_suppliername2',
                defaultContent: ''
            },
            {
                data: 'fc_supplierphone1'
            },
            {
                data: 'fc_supplierphone2',
                defaultContent: ''
            },
            {
                data: 'fc_supplierphone3',
                defaultContent: ''
            },
            {
                data: 'fc_supplieremail1'
            },
            {
                data: 'fc_supplieremail2',
                defaultContent: ''
            },
            {
                data: 'supplier_nationality.fv_description',
                defaultContent: '',
            },
            {
                data: 'fc_supplierforex'
            },
            {
                data: 'supplier_type_business.fv_description',
                defaultContent: '',
            },
            {
                data: 'supplier_typebranch.fv_description',
                defaultContent: '',
            },
            {
                data: 'fl_supplierreseller'
            },
            {
                data: 'supplier_tax_code.fv_description',
                defaultContent: '',
            },
            {
                data: 'fc_supplierNPWP'
            },
            {
                data: 'fc_suppliernpwp_name'
            },
            {
                data: 'fc_supplier_npwpaddress1'
            },
            {
                data: 'fc_supplier_npwpaddress2',
                defaultContent: ''
            },
            {
                data: 'fm_supplierAR'
            },
            {
                data: 'fn_supplierAgingAR'
            },
            {
                data: 'fn_supplierlockTrans'
            },
            {
                data: 'fc_supplierpicname'
            },
            {
                data: 'fc_supplierpicname2',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicname3',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicname4',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicname5',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicphone'
            },
            {
                data: 'fc_supplierpicphone2',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicphone3',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicphone4',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicphone5',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicpos'
            },
            {
                data: 'fc_supplierpicpos2',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicpos3',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicpos4',
                defaultContent: ''
            },
            {
                data: 'fc_supplierpicpos5',
                defaultContent: ''
            },
            {
                data: 'fd_supplierjoindate'
            },
            {
                data: 'fd_supplierexpired'
            },
            {
                data: 'fc_supplierbank1',
                defaultContent: '',
            },
            {
                data: 'fc_supplierbank2',
                defaultContent: '',
            },
            {
                data: 'fc_supplierbank3',
                defaultContent: '',
            },
            {
                data: 'fc_suppliervirtualac'
            },
            {
                data: 'fc_suppliernorek1'
            },
            {
                data: 'fc_suppliernorek2',
                defaultContent: ''
            },
            {
                data: 'fc_suppliernorek3',
                defaultContent: ''
            },
            {
                data: 'fv_supplierdescription'
            },
            {
                data: 'fc_suppliercode'
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-supplier/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_suppliercode;
            var url_delete = "/data-master/master-supplier/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_suppliercode;

            if (data['fl_supplierreseller'] == 'F') {
                $('td:eq(16)', row).html('<span class="badge badge-danger">No</span>');
            } else {
                $('td:eq(16)', row).html('<span class="badge badge-success">Yes</span>');
            }

            $('td:eq(50)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_suppliername1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
        }
    });

    function edit(url) {
        edit_action(url, 'Edit Data Master Supplier');
        $("#type").val('update');
    }
</script>
@endsection