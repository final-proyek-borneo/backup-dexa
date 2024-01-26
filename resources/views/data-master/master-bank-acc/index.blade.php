@extends('partial.app')
@section('title','Master Bank Acc')
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
        left: 30px;
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
                    <h4>Data Master Bank Acc</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Bank Acc</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: unset">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Divisi</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Nama Bank</th>
                                    <th scope="col" class="text-center">Tipe Bank</th>
                                    <th scope="col" class="text-center">No. Rekening</th>
                                    <th scope="col" class="text-center">Cabang Bank</th>
                                    <th scope="col" class="text-center">Username Bank</th>
                                    <th scope="col" class="text-center">Bank Terkunci</th>
                                    <th scope="col" class="text-center">Alamat Bank 1</th>
                                    <th scope="col" class="text-center">Alamat Bank 2</th>
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
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-bank-acc/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <input type="text" name="id" id="id_bank" hidden>
                                <label>Kode Divisi</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Bank</label>
                                <select class="form-control select2 required-field" name="fv_bankname"
                                    id="fv_bankname" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group required">
                                <label>Tipe Bank</label>
                                <select class="form-control select2" name="fc_banktype" id="fc_banktype" required>
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>No. Rekening</label>
                                <input type="number" class="form-control required-field" name="fc_bankcode" id="fc_bankcode">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Pemilik Rekening</label>
                                <input type="text" class="form-control required-field" name="fv_bankusername" id="fv_bankusername">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Bank Terkunci</label>
                                <select class="form-control select2" name="fl_bankhold" id="fl_bankhold">
                                    <option value="T">YES</option>
                                    <option selected value="F">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group required">
                                <label>Cabang Bank</label>
                                <input type="text" class="form-control required-field" name="fv_bankbranch" id="fv_bankbranch">
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Alamat Bank 1</label>
                                <textarea class="form-control required-field" name="fv_bankaddress1" id="fv_bankaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Alamat Bank 2</label>
                                <textarea class="form-control" name="fv_bankaddress2" id="fv_bankaddress2" style="height: 100px"></textarea>
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
        get_data_bankname();
    })

    function get_data_bankname() {
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
                    $("#fv_bankname").empty();
                    $("#fv_bankname").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fv_bankname").append(
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

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Master Bank Acc');
        $("#form_submit")[0].reset();
        $("#fc_bankcode").prop("readonly", false);
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        ajax: {
            url: '/data-master/master-bank-acc/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0]
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
                data: 'fv_bankname'
            },
            {
                data: 'fc_banktype'
            },
            {
                data: 'fc_bankcode'
            },
            {
                data: 'fv_bankbranch'
            },
            {
                data: 'fv_bankusername'
            },
            {
                data: 'fl_bankhold'
            },
            {
                data: 'fv_bankaddress1'
            },
            {
                data: 'fv_bankaddress2'
            },
            {
                data: 'fv_bankaddress2'
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-bank-acc/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_bankcode + '/' + data.id;
            var url_delete = "/data-master/master-bank-acc/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_bankcode;

            if (data.fl_bankhold == 'T') {
                $('td:eq(8)', row).html(`<span class="badge badge-success">YES</span>`);
            } else {
                $('td:eq(8)', row).html(`<span class="badge badge-danger">NO</span>`);
            }

            $('td:eq(11)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}','${data.id}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_bankname}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
        }
    });

    function edit(url, id) {
        edit_action(url, 'Edit Data Master Bank Acc');
        $("#type").val('update');
        // input no rekening menjadi readonly
        $("#fc_bankcode").prop("readonly", true);
        $("#id_bank").val(id);


    }

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection