@extends('partial.app')
@section('title', 'User')
@section('css')
<style>
    .required label:after {
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
                    <h4>Data User</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i>
                            Tambah User</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Division</th>
                                    <th scope="col" class="text-center">Branch</th>
                                    <th scope="col" class="text-center text-nowrap">User Id</th>
                                    <th scope="col" class="text-center">Username</th>
                                    <th scope="col" class="text-center text-nowrap">Group User</th>
                                    <th scope="col" class="text-center text-nowrap">Customer</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">Hold</th>
                                    <th scope="col" class="text-center">Expired</th>
                                    <th scope="col" class="text-center">Description</th>
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

<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/data-master/master-user/store-update" method="POST" autocomplete="off" enctype="multipart/form-data">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="number" id="id_user" name="id" hidden>
                                <select class="form-control select2" name="fc_branch" id="fc_branch" hidden></select>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="SBY001" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2 required-field" name="fc_branch_edit" id="fc_branch_edit" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>User ID</label>
                                <input type="text" class="form-control required-field" name="fc_userid" id="fc_userid" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Username</label>
                                <input type="text" class="form-control required-field" name="fc_username" id="fc_username"  required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Password</label>
                                <input type="text" class="form-control required-field" name="fc_password" id="fc_password" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Group User</label>
                                <select class="form-control select2 required-field" name="fc_groupuser" id="fc_groupuser" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" class="form-control" name="fl_level" id="fl_level">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Hold</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_hold" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_hold" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>

                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Customer Code</label>
                                <select class="form-control select2" name="fc_membercode" id="fc_membercode"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Expired Date</label>
                                <input type="text" class="form-control datepicker" name="fd_expired" id="fd_expired">
                            </div>
                            <div class="form-group">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>

                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="customFile">Tanda Tangan</label>
                                <input type="file" class="form-control" name="image_file" id="customFile" />
                                <br>
                                <label>Description</label>
                                <textarea name="fv_description" id="fv_description" style="height: 90px" class="form-control"></textarea>
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
<div class="modal fade" role="dialog" id="modal_add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_edit" action="/data-master/master-user/store-update" method="POST" autocomplete="off" enctype="multipart/form-data">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="number" id="id_user" name="id" hidden>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="SBY001" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch_add" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>User ID</label>
                                <input type="text" class="form-control required-field" name="fc_userid" id="fc_userid" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Username</label>
                                <input type="text" class="form-control required-field" name="fc_username" id="fc_username" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Password</label>
                                <input type="text" class="form-control required-field" name="fc_password" id="fc_password" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Group User</label>
                                <select class="form-control select2 required-field" name="fc_groupuser" id="fc_groupuser_add" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" class="form-control" name="fl_level" id="fl_level">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Hold</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_hold" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_hold" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>

                                </div>
                            </div>

                        </div>
                        <div id="fc_membercode_add-container" class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Customer Code</label>
                                <select class="form-control select2" name="fc_membercode" id="fc_membercode_add"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Expired Date</label>
                                <input type="text" class="form-control datepicker" name="fd_expired" id="fd_expired">
                            </div>
                            <div class="form-group">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="add_roles" class="form-control select2" multiple>

                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="customFile">Tanda Tangan</label>
                                <input type="file" class="form-control" name="image_file" id="customFile" />
                                <br>
                                <label>Description</label>
                                <textarea name="fv_description" id="fv_description" style="height: 90px" class="form-control"></textarea>
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
        get_data_group_user();
        $("#fc_membercode_add").parent().hide();
        $("#fc_membercode").parent().hide();
        $("#fc_groupuser_add").on("change", function() {
            var fc_kode = $(this).val();
            console.log(fc_kode)
            if (fc_kode === "CUSTOMER") {
                get_data_membercode();
            } else {
                $("#fc_membercode_add").empty();
                $("#fc_membercode_add").parent().hide();
            }
        });
        $("#fc_groupuser").on("change", function() {
            var fc_kode = $(this).val();
            console.log(fc_kode)
            if (fc_kode === "CUSTOMER") {
                // Memanggil fungsi get_data_membercode() saat fc_groupuser dipilih CUSTOMER
                get_data_membercode();
            } else {
                // Menyembunyikan atau menonaktifkan fc_membercode jika fc_groupuser bukan CUSTOMER
                $("#fc_membercode").empty();
                $("#fc_membercode").parent().hide();
            }
        });
    })

    function add() {
        $("#modal_add").modal('show');
        $(".modal-title").text('Tambah User');
        $("#form_submit")[0].reset();
        add_user();
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
                    $("#fc_branch_add").empty();
                    $("#fc_branch_add").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_branch_add").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }

                    if ($("#fc_branch_edit").val() === '') {
                        $("#fc_branch_edit").empty();
                        $("#fc_branch_edit").append(`<option value="" selected readonly> - Pilih - </option>`);
                        for (var i = 0; i < data.length; i++) {
                            $("#fc_branch_edit").append(
                                `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            $("#fc_branch_edit").append(
                                `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }

                    $("#fc_branch").empty();
                    $("#fc_branch").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_branch").append(
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

    function get_data_group_user() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/GROUPUSER",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_groupuser").empty();
                    $("#fc_groupuser").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_groupuser").append(
                            `<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                    $("#fc_groupuser_add").empty();
                    $("#fc_groupuser_add").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_groupuser_add").append(
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

    function get_data_membercode() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data/user-from-customer",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;

                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(
                            `<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`
                        );
                    }
                    $("#fc_membercode_add").empty();
                    $("#fc_membercode_add").append(
                        `<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode_add").append(
                            `<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`
                        );
                    }
                    $("#fc_membercode_add").parent().show();
                    $("#fc_membercode").parent().show();
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



    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        ajax: {
            url: '/data-master/master-user/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 7, 11]
            },
            {
                className: 'text-nowrap',
                targets: [11]
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
                data: 'fc_userid'
            },
            {
                data: 'fc_username'
            },
            {
                data: 'group_user.fv_description'
            },
            {
                data: 'customer.fc_membername1',
                render: function(data, type, row) {
                    return data ? data : '';
                }
            },
            {
                data: 'fl_level'
            },
            {
                data: 'fl_hold'
            },
            {
                data: 'fd_expired'
            },
            {
                data: 'fv_description'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {

            if (data.fl_hold == 'T') {
                $('td:eq(8)', row).html(`<span class="badge badge-success">Hold</span>`);
            } else {
                $('td:eq(8)', row).html(`<span class="badge badge-danger">Not Hold</span>`);
            }

            var url_reset_password = "/data-master/master-user/reset-password/" + data.fc_username;
            var url_edit = "/data-master/master-user/detail/" + data.fc_userid + "/" + data.fc_username + "/" + data.id;

            var url_delete = "/data-master/master-user/delete/" + data.fc_userid + "/" + data.fc_username + "/" + data.id;

            $('td:eq(11)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick="reset_password('${url_reset_password}')"><i class="fas fa-key"></i></button>
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
         `);
        //     $('td:eq(11)', row).html(`
        //     <button class="btn btn-warning btn-sm mr-1" onclick="reset_password('${url_reset_password}')"><i class="fas fa-key"></i></button>
        //     <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
        //     <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.name}')"><i class="fa fa-trash"> </i> Hapus</button>
        //  `);
        }
    });



    function reset_password(url) {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan melakukan reset password ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb.ajax.reload(null, false);
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
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown +
                                ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    }

    function edit(url) {
        edit_action_custom(url, 'Edit Data User');
        $("#type").val('update');
        $('#fc_userid').attr('readonly', true);
        $('#fc_branch_edit').attr('disabled', true);
    }

    // $('#form_submit').on('submit', function() {
    //     $('#fc_branch').prop('disabled', false);
    // });

    $('.modal').css('overflow-y', 'auto');

    function add_user() {
        $("#modal_add").modal('show');
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/data-master/master-user/get-role',
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                var roles = response.roles;

                var rolesSelect = $('#add_roles');
                rolesSelect.empty(); // Clear existing options
                $.each(roles, function(index, role) {
                    rolesSelect.append('<option value="' + role.id + '">' + role
                        .name + '</option>');
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error'
                });
            }
        });
    }

    function edit_action_custom(url, modal_text) {
        save_method = 'edit';
        $("#modal").modal('show');
        $(".modal-title").text(modal_text);
        $("#modal_loading").modal('show');
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var user = response.user; // Ambil data user dari response
                var roles = response.roles;


                var rolesSelect = $('#roles');
                rolesSelect.empty(); // Clear existing options
                $.each(roles, function(index, role) {
                    var selected = response.selected.hasOwnProperty(role.name) ? 'selected' : '';
                    rolesSelect.append('<option value="' + role.id + '" ' + selected + '>' + role
                        .name + '</option>');
                });


                Object.keys(user).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    if (elem_name.hasClass('selectric')) {
                        elem_name.val(user[key]).change().selectric('refresh');
                    } else if (elem_name.hasClass('select2')) {
                        elem_name.select2("trigger", "select", {
                            data: {
                                id: user[key]
                            }
                        });
                    } else if (elem_name.hasClass('selectgroup-input')) {
                        $("input[name=" + key + "][value=" + user[key] + "]").prop('checked', true);
                    } else if (elem_name.hasClass('my-ckeditor')) {
                        CKEDITOR.instances[key].setData(user[key]);
                    } else if (elem_name.hasClass('summernote')) {
                        elem_name.summernote('code', user[key]);
                    } else if (elem_name.hasClass('custom-control-input')) {
                        $("input[name=" + key + "][value=" + user[key] + "]").prop('checked', true);
                    } else if (elem_name.hasClass('time-format')) {
                        elem_name.val(user[key].substr(0, 5));
                    } else if (elem_name.hasClass('format-rp')) {
                        var nominal = user[key].toString();
                        elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                    } else {
                        elem_name.val(user[key]);
                    }
                });

                // menambahkan input hidden id user
                $('#id_user').val(user.id);
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 600);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error'
                });
            }
        });
    }
</script>
@endsection