@extends('partial.app')
@section('title', 'Transit Barang')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary {
        color: #969DA4 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .flex-row-item {
            font-size: 12px;
        }

        .grand-text {
            font-size: .9rem;
        }
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
    <form id="form_submit" action="/apps/penerimaan-barang/insert_good_reception" method="POST">
        @csrf
    <div class="row">
        <div class="col-12 col-md-4 col-lg-6">
        
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Tanggal Datang</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_arrivaldate" class="form-control datepicker" name="fd_arrivaldate" required>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Penerima</label>
                                    <input type="text" class="form-control" id="fc_recipient" name="fc_recipient">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Supplier</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_suppliercode" name="fc_suppliercode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_supplier()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Jumlah</label>
                                    <div class="form-group">
                                        <input type="number" min="0" class="form-control" name="fn_qtyitem" id="fn_qtyitem">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Unit</label>
                                    <select class="form-control select2" name="fc_unit" id="fc_unit">
                                        <option value="" selected disabled>- Pilih -</option>
                                        <option value="Koli">Koli</option>
                                        <option value="Biji">Biji</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" name="fc_supplierNPWP" id="fc_supplierNPWP" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="fc_suppliername1" id="fc_suppliername1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" name="fc_branchtype" id="fc_branchtype" readonly hidden>
                                    <input type="text" class="form-control" name="fc_branchtype_desc" id="fc_branchtype_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" name="fc_suppliertypebusiness" id="fc_suppliertypebusiness" readonly hidden>
                                    <input type="text" class="form-control" name="fc_suppliertypebusiness_desc" id="fc_suppliertypebusiness_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" name="fc_supplierphone1" id="fc_supplierphone1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="fc_supplier_npwpaddress1" id="fc_supplier_npwpaddress1" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button text-right">
                <button  type="submit" class="btn btn-success">Konfirmasi</button>
            </div>
        </div>
    </div>
 </form>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_supplier" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_supplier" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Kode</th>
                                <th scope="col" class="text-center">Nama</th>
                                <th scope="col" class="text-center">Alamat</th>
                                <th scope="col" class="text-center">Tipe Bisnis</th>
                                <th scope="col" class="text-center text-nowrap">Tipe Cabang</th>
                                <th scope="col" class="text-center">Legalitas</th>
                                <th scope="col" class="text-center">NPWP</th>
                                <th scope="col" class="text-center" style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
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
        get_data_supplier();
        $('.place_detail').attr('hidden', true);
    })

    function click_modal_supplier() {
        $('#modal_supplier').modal('show');
        table_supplier();
    }

    function get_data_supplier() {
        $.ajax({
            url: "/apps/purchase-order/get-data-where-field-id-get/Supplier/fc_branch/" + $('#fc_branch').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_suppliercode").empty();
                    $("#fc_suppliercode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_salescode").append(
                            `<option value="${data[i].fc_suppliercode}">${data[i].fc_suppliername1}</option>`);
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

    function onchange_member_code(fc_suppliercode) {
        $.ajax({
            url: "/master/data-supplier-first/" + fc_suppliercode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $('#fc_suppliertaxcode').val(data.supplier_tax_code.fc_kode);
                    $('#fc_suppliertaxcode_view').val(data.supplier_tax_code.fv_description);
                    $('#fc_supplieraddress_loading1').val(data.fc_memberaddress_loading1);
                    $('#fc_supplieraddress_loading2').val(data.fc_memberaddress_loading2);
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

    function table_supplier() {
        var tb = $('#tb_supplier').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/penerimaan-barang/get-data-supplier-pb-datatables/" + $('#fc_branch').val(),
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 7]
            }, ],
            columns: [{
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
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_supplier('${data.fc_suppliercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function detail_supplier($id) {
        $.ajax({
            url: "/master/data-supplier-first/" + $id,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                console.log(data);
                var data = response.data;
                console.log(data);
                $("#modal_supplier").modal('hide');
                Object.keys(data).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    elem_name.val(data[key]);
                });

                $('#fn_supplierAgingAR').val(data.fn_supplierAgingAR);
                $('#fn_supplierAR').val(data.fn_supplierAR);
                $('#fc_branchtype_desc').val(data.supplier_typebranch.fv_description);
                $('#fc_suppliertypebusiness_desc').val(data.supplier_type_business.fv_description);
                $('#fc_supplierlegalstatus_desc').val(data.supplier_legal_status.fv_description);
                $('#status_pkp').val(data.supplier_tax_code.fv_description);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }
</script>
@endsection