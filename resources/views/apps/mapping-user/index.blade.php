@extends('partial.app')
@section('title', 'Mapping User')
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
                    <h4>Data Mapping User</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Role</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">User ID</th>
                                    <th scope="col" class="text-center">Username</th>
                                    <th scope="col" class="text-center">Nama Mapping</th>
                                    <th scope="col" class="text-center">Hold</th>
                                    <th scope="col" class="text-center">Catatan</th>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/apps/mapping-user/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group required">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4" hidden>
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch }}"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group required">
                                <label>Nama User</label>
                                <select class="form-control select2" name="fc_userid" id="fc_userid" required></select>
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
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Mapping</label>
                                <select class="form-control select2" name="fc_mappingcode" id="fc_mappingcode" required></select>
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
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal2" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <input type="text" name="type" id="type" hidden>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3" hidden>
                        <div class="form-group required">
                            <label>Division Code</label>
                            <input type="text" class="form-control" name="fc_divisioncode2" id="fc_divisioncode2" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4" hidden>
                        <div class="form-group required">
                            <label>Cabang</label>
                            <select type="text" class="form-control" name="fc_branch2" id="fc_branch2" value="{{ auth()->user()->fc_branch }}"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="form-group required">
                            <label>Nama User</label>
                            <select class="form-control select2" name="fc_userid2" id="fc_userid2" required></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required-select">
                            <label id="label-select">Hold</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_hold2" id="fc_hold2" value="T" class="selectgroup-input">
                                    <span class="selectgroup-button">YA</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="fc_hold2" id="fc_hold2" value="F" class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">TIDAK</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group required">
                            <label>Mapping</label>
                            <select class="form-control select2" name="fc_mappingcode2" id="fc_mappingcode2" required></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" class="form-control" name="fv_description2" id="fv_description2">
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
    $(document).ready(function() {
        get_user();
        get_mapping();
    })

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Role');
        $("#form_submit")[0].reset();
    }

    function detail(fc_mappingcode) {
        $("#modal2").modal('show');
        $(".modal-title").text('Detail Mapping User');
        get_detail(fc_mappingcode);
    }

    function get_detail(fc_mappingcode) {
        $('#modal_loading').modal('show');
        var mappingcode = window.btoa(fc_mappingcode);

        $.ajax({
            url: "/apps/mapping-user/detail/" + mappingcode,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);

                if (response.status == 200) {
                    var value = data.fc_hold;
                    $("input[name=fc_hold2][value=" + value + "]").prop('checked', true);
                    $('#fc_hold2').prop('disabled', true);
                    $('#fc_mappingname2').val(data.fc_mappingname);
                    $('#fc_mappingcode2').append(`<option value="${data.fc_mappingcode}" selected>${data.mappingmst.fc_mappingname}</option>`);
                    $('#fc_mappingcode2').prop('disabled', true);
                    $('#fc_userid2').append(`<option value="${data.fc_userid}" selected>${data.user.fc_username}</option>`);
                    $('#fc_userid2').prop('disabled', true);
                    $('#fv_description2').val(data.fv_description);
                    $('#fv_description2').prop('readonly', true);

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

    function get_user() {
        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/mapping-user/get-user",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_userid").empty();
                    $("#fc_userid").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_userid").append(`<option value="${data[i].fc_userid}">${data[i].fc_username}</option>`);
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

    function get_mapping() {
        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/mapping-user/get-mapping",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_mappingcode").empty();
                    $("#fc_mappingcode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_mappingcode").append(`<option value="${data[i].fc_mappingcode}">${data[i].fc_mappingname}</option>`);
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

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/mapping-user/datatables",
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
                data: 'fc_userid'
            },
            {
                data: 'user.fc_username'
            },
            {
                data: 'mappingmst.fc_mappingname'
            },
            {
                data: 'fc_hold'
            },
            {
                data: 'fv_description',
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/mapping-user/delete/" + data.id;
            console.log(data.id);
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            if (data.fc_hold == 'T') {
                $('td:eq(4)', row).html(`<span class="badge badge-success">YA</span>`);
            } else {
                $('td:eq(4)', row).html(`<span class="badge badge-danger">TIDAK</span>`);
            }

            $('td:eq(6)', row).html(`
                    <button type="button" class="btn btn-primary btn-sm mr-1" onclick="detail('${data.fc_mappingcode}')"><i class="fa fa-eye"> </i> Detail</button>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}', '${data.mappingmst.fc_mappingname}')"><i class="fas fa-trash"> </i> Hapus</button>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection