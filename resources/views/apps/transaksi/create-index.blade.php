@extends('partial.app')
@section('title', 'Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .select2-selection__rendered{
        margin-right: 15px;
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
                </div>
                <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <form id="form_submit_edit" action="/apps/transaksi/store-update" method="POST" autocomplete="off">
                    <input type="text" class="form-control" name="fc_mappingtrxtype_hidden" id="fc_mappingtrxtype_hidden" readonly hidden>
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-2">
                                    <div class="form-group required">
                                        <label>Cabang</label>
                                        <select class="form-control select2" name="fc_branch" id="fc_branch"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-2">
                                    <div class="form-group required">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" id="fc_userid" value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group required">
                                        <label>Tgl Transaksi</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <input type="text" id="fd_trxdate_byuser" class="form-control datepicker" name="fd_trxdate_byuser" required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group required">
                                        <label>Kode mapping</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control required-field" id="fc_mappingcode" name="fc_mappingcode" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_mapping()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Nama mapping</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="fc_mappingname" name="fc_mappingname" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group required">
                                        <label>Tipe Jurnal</label>
                                        <select class="form-control select2" name="fc_mappingtrxtype" id="fc_mappingtrxtype" required disabled></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3" id="doc-ref">
                                    <div class="form-group required">
                                        <label>Referensi</label>
                                        <div class="input-group mb-3" id="grup_input">
                                            <input type="text" class="form-control" id="fc_docreference" name="fc_docreference" readonly>
                                            <div class="input-group-append" id="button_ref">
                                                <button class="btn btn-primary" onclick="click_modal()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <a href="/apps/transaksi" type="button" class="btn btn-info mr-1">Back</a>
                                    <button type="submit" class="btn btn-success">Buat Transaksi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_mapping" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Mapping</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Debit</th>
                                    <th scope="col" class="text-center">Kredit</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Transaksi</th>
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

<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Tipe Referensi</h5>
                <div class="card-header-action">
                    <select data-dismiss="modal" name="category" onchange="" class="form-control select2 required-field" id="category">
                        <option value="Penjualan" selected>Penjualan</option>
                        <option value="Pembelian">Pembelian</option>
                    </select>
                </div>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body" id="customer">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_cust" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No.</th>
                                    <th scope="col" class="text-center">Kode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center text-nowrap">Tipe Bisnis</th>
                                    <th scope="col" class="text-center text-nowrap">Tipe Cabang</th>
                                    <th scope="col" class="text-center text-nowrap">Status Legal</th>
                                    <th scope="col" class="text-center">NPWP</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-body" id="supplier" hidden>
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_supp" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No.</th>
                                    <th scope="col" class="text-center">Kode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center text-nowrap">Tipe Bisnis</th>
                                    <th scope="col" class="text-center text-nowrap">Tipe Cabang</th>
                                    <th scope="col" class="text-center text-nowrap">Status Legal</th>
                                    <th scope="col" class="text-center">NPWP</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    $(document).ready(function() {
        get_data_branch();
    })

    $("#category").change(function() {
        if ($('#category').val() === 'Penjualan') {
            $('#customer').attr('hidden', false);
            $('#supplier').attr('hidden', true);
        } else {
            $('#customer').attr('hidden', true);
            $('#supplier').attr('hidden', false);
        }
    });

    function click_modal() {
        if ($('#fc_mappingcode').val() != "") {
            $('#modal').modal('show');
        } else {
            swal("Silahkan mengisi mapping terlebih dahulu", {
                icon: 'warning',
            });
        }
    }

    function click_modal_mapping() {
        $('#modal_mapping').modal('show');
    }

    function get_cust($fc_membercode) {
        $('#fc_docreference').val($fc_membercode);
        $('#modal').modal('hide');
    }

    function get_supp($fc_suppliercode) {
        $('#fc_docreference').val($fc_suppliercode);
        $('#modal').modal('hide');
    }

    function get_detail(fc_mappingcode) {
        $('#modal_loading').modal('show');
        $('#fc_docreference').val("");
        var mappingcode = window.btoa(fc_mappingcode);

        $.ajax({
            url: "/apps/transaksi/get-detail/" + mappingcode,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    $('#fc_mappingcode').val(data.fc_mappingcode);
                    $('#fc_mappingname').val(data.fc_mappingname);
                    $('#fc_mappingtrxtype').append(`<option value="${data.fc_mappingtrxtype}" selected>${data.transaksi.fv_description}</option>`);
                    $('#fc_mappingtrxtype').prop('disabled', true);
                    $('#fc_mappingtrxtype_hidden').val(data.fc_mappingtrxtype);

                    if (data.fc_mappingtrxtype === 'GNRL') {
                        $('#fc_docreference').prop('readonly', false);
                        // required input
                        $('#fc_docreference').prop('required', false);
                        $('#button_ref').remove();
                    } else {
                        $('#fc_docreference').prop('readonly', true);
                        $('#fc_docreference').prop('required', true);


                        if ($('#button_ref').length === 0) {
                            var buttonElement = `
                                    <div class="input-group-append" id="button_ref">
                                        <button class="btn btn-primary" onclick="click_modal()" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                `;
                            $('#grup_input').append(buttonElement);
                        }
                    }



                    $('#modal_mapping').modal('hide');
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

    var tb_cust = $('#tb_cust').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        ajax: {
            url: "/master/get-data-customer-so-datatables/" + $('#fc_branch_view').val(),
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },{
                data: 'fc_membercode'
            },
            {
                data: 'fc_membername1'
            },
            {
                data: 'fc_memberaddress1'
            },
            {
                data: 'member_type_business.fv_description'
            },
            {
                data: 'member_typebranch.fv_description'
            },
            {
                data: 'member_legal_status.fv_description'
            },
            {
                data: 'fc_membernpwp_no'
            },
            {
                data: 'fc_membernpwp_no'
            },
        ],
        rowCallback: function(row, data) {
            var fc_membercode = window.btoa(data.fc_membercode);
            $('td:eq(8)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_cust('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
        }
    });

    var tb_supp = $('#tb_supp').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        ajax: {
            url: "/apps/purchase-order/get-data-supplier-po-datatables/" + $('#fc_branch_view').val(),
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },{
                data: 'fc_suppliercode',
            },
            {
                data: 'fc_suppliername1'
            },
            {
                data: 'fc_supplier_npwpaddress1'
            },
            {
                data: 'fc_suppliertypebusiness'
            },
            {
                data: 'fc_branchtype'
            },
            {
                data: 'fc_supplierlegalstatus'
            },
            {
                data: 'fc_supplierNPWP'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_suppliercode = window.btoa(data.fc_suppliercode);
            $('td:eq(8)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_supp('${data.fc_suppliercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
        }
    });

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-mapping",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
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
                data: 'mappingmst.fc_mappingname'
            },
            {
                data: 'sum_debit'
            },
            {
                data: 'sum_credit'
            },
            {
                data: 'mappingmst.tipe.fv_description'
            },
            {
                data: 'mappingmst.transaksi.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_mappingcode = window.btoa(data.fc_mappingcode);
            $('td:eq(7)', row).html(`
                    <button type="button"class="btn btn-warning btn-sm" onclick="get_detail('${data.fc_mappingcode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan cancel Transaksi Accounting?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/transaksi/cancel_transaksi',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 200) {

                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });

                                tb.ajax.reload(null, false);
                            } else if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                // arahkan ke link
                                location.href = response.link;
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