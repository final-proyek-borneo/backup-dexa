@extends('partial.app')
@section('title', 'Master Mapping')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .required-select #label-select:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Mapping</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Data Mapping</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Mapping</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Debit</th>
                                    <th scope="col" class="text-center">Kredit</th>
                                    <th scope="col" class="text-center">Hold</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Transaksi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Data Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/apps/master-mapping/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group required">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Operator</label>
                                <input type="text" class="form-control required-field" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Kode Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingcode" id="fc_mappingcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Tipe</label>
                                <select name="fc_mappingcashtype" id="fc_mappingcashtype" onchange="get_transaksi()" class="select2 required-field"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Transaksi</label>
                                <select name="fc_mappingtrxtype" id="fc_mappingtrxtype" class="select2 required-field"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required-select">
                                <label id="label-select">Hold</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_hold" id="fc_hold" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_hold" id="fc_hold" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingname" id="fc_mappingname">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Relasi</label>
                                <select class="form-control select2 required-field" name="fc_balancerelation" id="fc_balancerelation">
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="1 to N">One to Many</option>
                                    <option value="N to M">Many to Many</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
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
        get_data_branch_edit();
        get_data_tipe();
    })

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Data Mapping');
        $("#form_submit")[0].reset();
    }

    function get_data_tipe() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/MAPPINGTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_mappingcashtype").empty();
                    $("#fc_mappingcashtype").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_mappingcashtype").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_transaksi() {
        $('#modal_loading').modal('show');
        var fc_action = window.btoa($('#fc_mappingcashtype').val());
        $.ajax({
            url: "/apps/master-mapping/" + fc_action,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_mappingtrxtype").empty();
                    $("#fc_mappingtrxtype").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_mappingtrxtype").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_branch_edit() {
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
                    $("#fc_branch_edit").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].fc_kode == $('#fc_branch_view_edit').val()) {
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch_edit").prop("disabled", true);
                        } else {
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function edit(fc_mappingcode) {
        $('#modal_loading').modal('show');

        $.ajax({
            url: '/apps/master-mapping/get-data/edit',
            type: 'GET',
            data: {
                fc_mappingcode: fc_mappingcode
            },
            success: function(response) {
                var data = response.data;

                if (response.status == 200) {
                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_edit').modal('show');
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server');
                $('#modal_loading').modal('hide');
            }
        });
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-mapping/datatables",
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
                data: 'fc_mappingcode'
            },
            {
                data: 'fc_mappingname'
            },
            {
                data: 'sum_debit'
            },
            {
                data: 'sum_credit'
            },
            {
                data: 'fc_hold'
            },
            {
                data: 'tipe.fv_description'
            },
            {
                data: 'transaksi.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_edit = "/apps/master-mapping/edit/" + data.fc_mappingcode;
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            if (data.fc_hold == 'T') {
                $('td:eq(5)', row).html(`<span class="badge badge-success">YA</span>`);
            } else {
                $('td:eq(5)', row).html(`<span class="badge badge-danger">TIDAK</span>`);
            }

            if (data.fc_hold == 'T') {
                $('td:eq(8)', row).html(`
                    <a href="/apps/master-mapping/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-warning btn-sm" onclick="unhold('${data.fc_mappingcode}')"><i class="fas fa-unlock"> </i> Buka Hold</button>
                `);
            } else {
                $('td:eq(8)', row).html(`
                    <a href="/apps/master-mapping/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-danger btn-sm" onclick="hold('${data.fc_mappingcode}')"><i class="fas fa-lock"> </i> Hold</button>
                `);
            }
        },
    });

    function hold(fc_mappingcode) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin Hold data ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/master-mapping/hold/' + fc_mappingcode,
                    type: 'PUT',
                    data: {
                        fc_hold: 'T',
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 200) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
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

    function unhold(fc_mappingcode) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin Membuka Hold data ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/master-mapping/unhold/' + fc_mappingcode,
                    type: 'PUT',
                    data: {
                        fc_hold: 'F',
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 200) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
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

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection