@extends('partial.app')
@section('title','Master Sales')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
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
                    <h4>Data Master Sales</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Sales</button>
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
                                    <th scope="col" class="text-center">Kode Sales</th>
                                    <th scope="col" class="text-center">Nama Sales 1</th>
                                    <th scope="col" class="text-center">Nama Sales 2</th>
                                    <th scope="col" class="text-center">Tipe Sales</th>
                                    <th scope="col" class="text-center">Level Sales</th>
                                    <th scope="col" class="text-center">Sales BlackList</th>
                                    <th scope="col" class="text-center">No. HP Sales 1</th>
                                    <th scope="col" class="text-center">No. HP Sales 2</th>
                                    <th scope="col" class="text-center">No. HP Sales 3</th>
                                    <th scope="col" class="text-center">Email Sales 1</th>
                                    <th scope="col" class="text-center">Email Sales 2</th>
                                    <th scope="col" class="text-center">Bank Sales 1</th>
                                    <th scope="col" class="text-center">Bank Sales 2</th>
                                    <th scope="col" class="text-center">Bank Sales 3</th>
                                    <th scope="col" class="text-center">Virtual Acc Sales</th>
                                    <th scope="col" class="text-center">No. Rek Sales 1</th>
                                    <th scope="col" class="text-center">No. Rek Sales 2</th>
                                    <th scope="col" class="text-center">No. Rek Sales 3</th>
                                    <th scope="col" class="text-center">Deskripsi Sales</th>
                                    <th scope="col" class="justify-content-center">Actions</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-sales/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Kode Divisi</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group required">
                                <label>Kode Sales</label>
                                <input type="text" class="form-control required-field" name="fc_salescode" id="fc_salescode" value="fc_salescode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Area</label>
                                <select class="form-control select2" name="fc_area" id="fc_area" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Sales 1</label>
                                <input type="text" class="form-control required-field" name="fc_salesname1" id="fc_salesname1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Sales 2</label>
                                <input type="text" class="form-control" name="fc_salesname2" id="fc_salesname2">
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Sales</label>
                                <select class="form-control select2" name="fc_salestype" id="fc_salestype" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Level Sales</label>
                                <select class="form-control select2" name="fn_saleslevel" id="fn_saleslevel" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <label>Blacklist</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fn_salesblacklist" value="T" class="selectgroup-input">
                                    <span class="selectgroup-button">Active</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fn_salesblacklist" value="F" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">Non Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Email Sales 1</label>
                                <input type="text" class="form-control required-field" name="fc_salesemail1" id="fc_salesemail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Email Sales 2</label>
                                <input type="text" class="form-control" name="fc_salesemail2" id="fc_salesemail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No. HP Sales 1</label>
                                <input type="text" class="form-control required-field" name="fc_salesphone1" id="fc_salesphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Sales 2</label>
                                <input type="text" class="form-control" name="fc_salesphone2" id="fc_salesphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. HP Sales 3</label>
                                <input type="text" class="form-control" name="fc_salesphone3" id="fc_salesphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>Bank Sales 1</label>
                                <select class="form-control select2" name="fc_salesbank1" id="fc_salesbank1" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Sales 2</label>
                                <select class="form-control select2" name="fc_salesbank2" id="fc_salesbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Sales 3</label>
                                <select class="form-control select2" name="fc_salesbank3" id="fc_salesbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No. Rekening Sales 1</label>
                                <input type="text" class="form-control required-field" name="fc_salesnorek1" id="fc_salesnorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. Rekening Sales 2</label>
                                <input type="text" class="form-control" name="fc_salesnorek2" id="fc_salesnorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>No. Rekening Sales 3</label>
                                <input type="text" class="form-control" name="fc_salesnorek3" id="fc_salesnorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Virtual AC Sales</label>
                                <input name="fc_salesvirtualac" id="fc_salesvirtualac" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi Sales</label>
                                <textarea name="fv_salesdescription" id="fv_salesdescription" class="form-control" style="height: 80px"></textarea>
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
        get_data_sales_type();
        get_data_sales_level();
        get_data_sales_bank();
        get_data_area()
    });

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

    function get_data_sales_type() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/SALESTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_salestype").empty();
                    $("#fc_salestype").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_salestype").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_sales_level() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/SALESlEVEL",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fn_saleslevel").empty();
                    $("#fn_saleslevel").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fn_saleslevel").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_area() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/DIVISIONCODE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_area").empty();
                    $("#fc_area").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_area").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_sales_bank() {
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
                    $("#fc_salesbank1").empty();
                    $("#fc_salesbank1").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_salesbank2").empty();
                    $("#fc_salesbank2").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_salesbank3").empty();
                    $("#fc_salesbank3").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_salesbank1").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_salesbank2").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
                        $("#fc_salesbank3").append(`<option value="${data[i].fv_description}">${data[i].fv_description}</option>`);
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
        $(".modal-title").text('Tambah Master Sales');
        $("#form_submit")[0].reset();
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        ajax: {
            url: '/data-master/master-sales/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 8]
            },
            {
                className: 'd-flex',
                targets: [22]
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
                data: 'fc_salescode'
            },
            {
                data: 'fc_salesname1'
            },
            {
                data: 'fc_salesname2'
            },
            {
                data: 'sales_type.fv_description'
            },
            {
                data: 'sales_level.fv_description'
            },
            {
                data: 'fn_salesblacklist'
            },
            {
                data: 'fc_salesphone1'
            },
            {
                data: 'fc_salesphone2'
            },
            {
                data: 'fc_salesphone3'
            },
            {
                data: 'fc_salesemail1'
            },
            {
                data: 'fc_salesemail2'
            },
            {
                data: 'fc_salesbank1',
                defaultContent: ''
            },
            {
                data: 'fc_salesbank2',
                defaultContent: ''
            },
            {
                data: 'fc_salesbank3',
                defaultContent: ''
            },
            {
                data: 'fc_salesvirtualac'
            },
            {
                data: 'fc_salesnorek1'
            },
            {
                data: 'fc_salesnorek2'
            },
            {
                data: 'fc_salesnorek3'
            },
            {
                data: 'fv_salesdescription'
            },
            {
                data: 'fc_salestype'
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-sales/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_salescode;
            var url_delete = "/data-master/master-sales/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_salescode;

            if (data.fn_salesblacklist == 'T') {
                $('td:eq(8)', row).html(`<span class="badge badge-success">YES</span>`);
            } else {
                $('td:eq(8)', row).html(`<span class="badge badge-danger">NO</span>`);
            }

            $('td:eq(22)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_salesname1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
        }
    });

    function edit(url) {
        edit_action(url, 'Edit Data Master Sales');
        $("#type").val('update');
        $("#fc_branch").prop("disabled", true);
        $("#fc_salesnorek1").prop("readonly", true);
        $("#fc_salesnorek2").prop("readonly", true);
        $("#fc_salesnorek3").prop("readonly", true);
    }
</script>
@endsection