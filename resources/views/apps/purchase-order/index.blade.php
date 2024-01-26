@extends('partial.app')
@section('title', 'Purchase Order')
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

        .btn-secondary {
            background-color: #A5A5A5 !important;
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
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Umum</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <form id="form_submit" action="/apps/purchase-order/store-update" method="POST" autocomplete="off">
                        <div class="collapse show" id="mycard-collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Operator</label>
                                            <input type="text" class="form-control" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>PO Type</label>
                                            <input type="text" class="form-control" id="fc_potype"
                                                    name="fc_potype" value="PO Beli" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group required">
                                            <label>Supplier Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="fc_suppliercode"
                                                    name="fc_suppliercode" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="click_modal_supplier()"
                                                        type="button"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Status PKP</label>
                                            {{-- <select class="form-control select2 select2-hidden-accessible" name="" id="" tabindex="-1" aria-hidden="true">
                                        <option value="T">YES</option>
                                        <option selected="" value="F">NO</option>
                                    </select> --}}
                                            <input type="text" class="form-control" id="status_pkp" name="fc_status_pkp"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 text-right">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Supplier</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control" name="fc_supplierNPWP"
                                            id="fc_supplierNPWP" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control" name="fc_branchtype"
                                            id="fc_branchtype" readonly hidden>
                                        <input type="text" class="form-control" name="fc_branchtype_desc"
                                            id="fc_branchtype_desc" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control" name="fc_suppliertypebusiness"
                                            id="fc_suppliertypebusiness" readonly hidden>
                                        <input type="text" class="form-control" name="fc_suppliertypebusiness_desc"
                                            id="fc_suppliertypebusiness_desc" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="fc_suppliername1"
                                            id="fc_suppliername1" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" name="fc_supplierphone1"
                                            id="fc_supplierphone1" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Masa Hutang</label>
                                        <input type="text" class="form-control" name="fn_supplierAgingAR" id="fn_supplierAgingAR"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control" name="fc_supplierlegalstatus"
                                            id="fc_supplierlegalstatus" readonly hidden>
                                        <input type="text" class="form-control" name="fc_supplierlegalstatus_desc"
                                            id="fc_supplierlegalstatus_desc" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="fc_supplier_npwpaddress1"
                                            id="fc_supplier_npwpaddress1" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Hutang</label>
                                        <input type="text" class="form-control" name="fm_supplierAR" id="fm_supplierAR"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit_custom" action="/apps/sales-order/detail/store-update" method="POST"
                            autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Kode Barang</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_barcode" name="fc_barcode"
                                                readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick=""><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Qty</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="" id="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Bonus</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="" id="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control format-rp" name=""
                                                id="" onkeyup="return onkeyupRupiah(this.id);"required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" fdprocessedid="hgh1fp"
                                                name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-success">Add Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                    <div class="card-header">
                        <h4>Calculation</h4>
                    </div>
                    <div class="card-body" style="height: 190px">
                        <div class="d-flex">
                            <div class="flex-row-item" style="margin-right: 30px">
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_so_disc">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                                </div>
                            </div>
                            <div class="flex-row-item">
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre" >
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                    <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit_custom" action="/apps/sales-order/detail/store-update" method="POST"
                            autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label>Tanggal PO</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            <input type="text" id="" class="form-control datepicker"
                                                name="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                            <label>Transport</label>
                                            @if (empty($data->fc_sotransport))
                                                <select class="form-control select2" name="" id="">
                                                    <option value="" selected disabled>- Pilih Transport -</option>
                                                    <option value="By Dexa">By Dexa</option>
                                                    <option value="By Paket">By Paket</option>
                                                    <option value="By Customer">By Customer</option>
                                                </select>
                                            @else
                                                <select class="form-control select2" name="" id="">
                                                    <option value="#" selected disabled></option>
                                                    <option value="By Dexa">By Dexa</option>
                                                    <option value="By Paket">By Paket</option>
                                                    <option value="By Customer">By Customer</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label>Perkiraan Penanganan</label>
                                        <div class="input-group format-rp">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div> 
                                            <input type="text" id="" class="form-control"
                                                name="" onkeyup="return onkeyupRupiah(this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Alamat Tujuan</label>
                                    <div class="form-group">
                                        <input type="text" id="" class="form-control"
                                                name="" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="button text-right mb-4">
                    <a href="#" class="btn btn-success">Submit</a>
                </div>
            </div>
        </div>
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
                                    <th scope="col" class="text-center">Tipe Cabang</th>
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
        $(document).ready(function() {
            get_data_supplier();
            $('.place_detail').attr('hidden', true);
        })

        function click_modal_supplier() {
            $('#modal_supplier').modal('show');
            table_supplier();
        }

        function click_modal_stock() {
            $('#modal_stock').modal('show');
            table_stock();
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
                    url: "/apps/purchase-order/get-data-supplier-po-datatables/" + $('#fc_branch').val(),
                    type: 'GET'
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                }, ],
                columns: [
                    {
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
                    if(data.fn_supplierAgingAR === null){
                        $('#fn_supplierAgingAR').val("-");
                    } else{
                        $('#fn_supplierAgingAR').val(data.fn_supplierAgingAR);
                    }
                    $('#fn_supplierAR').val(data.fn_supplierAR);
                    $('#fc_branchtype_desc').val(data.supplier_typebranch.fv_description);
                    $('#fc_suppliertypebusiness_desc').val(data.supplier_type_business.fv_description);
                    $('#fc_supplierlegalstatus_desc').val(data.supplier_legal_status.fv_description);
                    $('#status_pkp').val(data.supplier_tax_code.fv_description + " (" + data.supplier_tax_code.fc_action + "%" + ")");
                    $('#fm_supplierAR').val("Rp. " + fungsiRupiah(data.fm_supplierAR));
                    $('#fn_supplierAgingAR').val(data.fn_supplierAgingAR + " Hari");
                    
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
