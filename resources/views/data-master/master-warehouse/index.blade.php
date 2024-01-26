@extends('partial.app')
@section('title','Daftar Gudang')
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
                    <h4>Data Gudang</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Daftar Gudang</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Division</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Kode Gudang</th>
                                    <th scope="col" class="text-center">Nama Gudang</th>
                                    <th scope="col" class="text-center">Posisi Gudang</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Kapasitas</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-warehouse/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
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
                            <div class="form-group">
                                <label>Kode Gudang</label>
                                <input type="text" class="form-control" name="fc_warehousecode" id="fc_warehousecode">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Posisi Gudang</label>
                                <select class="form-control select2" name="fc_warehousepos" id="fc_warehousepos" required>
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="INTERNAL">Internal</option>
                                    <option value="EXTERNAL">External</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Status</label>
                                <select class="form-control select2" name="fl_status" id="fl_status" required>
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="G">Gudang</option>
                                    <option value="D">Display</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group" id="customer" hidden>
                                <label>Customer</label>
                                <select class="form-control select2" name="fc_membercode" id="fc_membercode" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-9">
                            <div class="form-group required">
                                <label>Nama Gudang</label>
                                <input type="text" class="form-control required-field" name="fc_rackname" id="fc_rackname" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Kapasitas</label>
                                <input type="number" class="form-control required-field" name="fn_capacity" id="fn_capacity" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 col-lg-12">
                            <div class="form-group required">
                                <label>Alamat Gudang</label>
                                <input type="text" class="form-control required-field" name="fc_warehouseaddress" id="fc_warehouseaddress" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="fv_description" id="fv_description" style="height: 150px"></textarea>
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
        get_data_customer();
    });

    $("#fc_warehousepos").change(function() {
        if ($('#fc_warehousepos').val() === 'INTERNAL') {
            $('#customer').attr('hidden', true);
            $('#fc_membercode').attr('required', false);
            $('#fc_membercode').val(null).trigger('change');
        } else {
            $('#customer').attr('hidden', false);
            $('#fc_membercode').attr('required', true);
        }
    });

    function get_data_customer() {
        $.ajax({
            url: "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
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

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Daftar Gudang');
        $("#form_submit")[0].reset();
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        order: [
            [3, 'asc']
        ],
        ajax: {
            url: '/data-master/master-warehouse/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0]
            },
            {
                className: 'text-nowrap',
                targets: [7, 10]
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
                data: 'fc_warehousecode'
            },
            {
                data: 'fc_rackname'
            },
            {
                data: 'fc_warehousepos'
            },
            {
                data: 'fl_status'
            },
            {
                data: 'fc_warehouseaddress'
            },
            {
                data: 'fn_capacity'
            },
            {
                data: 'fv_description'
            },
            {
                data: 'fv_description'
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-warehouse/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_warehousecode;
            var url_delete = "/data-master/master-warehouse/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_warehousecode;

            $('td:eq(6)', row).html(`<i class="${data.fc_dostatus}"></i>`);
            if (data['fl_status'] == 'G') {
                $('td:eq(6)', row).html('<span class="badge badge-success">Gudang</span>');
            } else {
                $('td:eq(6)', row).html('<span class="badge badge-primary">Display</span>');
            }

            $('td:eq(10)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_warehousecode}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
        }
    });

    function edit(url) {
        edit_action(url, 'Edit Data Master Warehouse');
        $("#type").val('update');
        $("#fc_branch").prop("disabled", true);
        document.getElementById("fc_warehousecode").readOnly = true;
    }

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection