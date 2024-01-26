@extends('partial.app')
@section('title','Sales Order')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary{
        color: #969DA4!important;
    }

    .text-success{
        color: #28a745!important;
    }

    .btn-secondary {
            background-color: #A5A5A5 !important;
        }

    @media (min-width: 992px) and (max-width: 1200px){
        .flex-row-item{
            font-size: 12px;
        }

        .grand-text{
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
                    <h4>Master Sales Order</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/sales-order/store-update" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Sales</label>
                                        <select class="form-control select2 required-field" name="fc_salescode" id="fc_salescode"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Tipe SO</label>
                                        <select class="form-control select2 required-field" name="fc_sotype" id="fc_sotype">
                                            <option value="" selected disabled>- Pilih -</option>
                                            <option value="Retail">Retail</option>
                                            <option value="Cost Per Test">Cost Per Test</option>
                                            <option value="Memo Internal">Memo Internal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Customer Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" readonly>
                                            <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_customer()" type="button"><i class="fa fa-search"></i></button>
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
                                    <input type="text" class="form-control" id="status_pkp" name="fc_pkp" readonly>
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
                    <h4>Detail Customer Sales Order</h4>
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
                                    <input type="text" class="form-control" name="fc_membernpwp_no" id="fc_membernpwp_no" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" name="fc_member_branchtype" id="fc_member_branchtype" readonly hidden>
                                    <input type="text" class="form-control" name="fc_member_branchtype_desc" id="fc_member_branchtype_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" name="fc_membertypebusiness" id="fc_membertypebusiness" readonly hidden>
                                    <input type="text" class="form-control" name="fc_membertypebusiness_desc" id="fc_membertypebusiness_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="fc_membername1" id="fc_membername1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="fc_memberaddress1" id="fc_memberaddress1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" name="fn_memberAgingAP" id="fn_memberAgingAP" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" name="fc_memberlegalstatus" id="fc_memberlegalstatus" readonly hidden>
                                    <input type="text" class="form-control" name="fc_memberlegalstatus_desc" id="fc_memberlegalstatus_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" name="fc_memberaddress_loading1" id="fc_memberaddress_loading1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" name="fm_memberAP" id="fm_memberAP" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_customer" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_customer" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Kode</th>
                            <th scope="col" class="text-center">Nama</th>
                            <th scope="col" class="text-center">Alamat</th>
                            <th scope="col" class="text-center">Tipe Bisnis</th>
                            <th scope="col" class="text-center">Tipe Cabang</th>
                            <th scope="col" class="text-center">Status Legal</th>
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

    $(document).ready(function(){
        get_data_sales();
        $('.place_detail').attr('hidden', true);
    })

    function click_modal_customer(){
        $('#modal_customer').modal('show');
        table_customer();
    }

    function click_modal_stock(){
        $('#modal_stock').modal('show');
        table_stock();
    }

    function get_data_sales(){
        $.ajax({
            url : "/master/get-data-where-field-id-get/Sales/fc_branch/" + $('#fc_branch').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_salescode").empty();
                    $("#fc_salescode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_salescode").append(`<option value="${data[i].fc_salescode}">${data[i].fc_salesname1}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function onchange_member_code(fc_membercode){
        $.ajax({
            url : "/master/data-customer-first/" + fc_membercode,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                if(response.status === 200){
                    var data = response.data;
                    $('#fc_membertaxcode').val(data.member_tax_code.fc_kode);
                    $('#fc_membertaxcode_view').val(data.member_tax_code.fv_description);
                    $('#fc_memberaddress_loading1').val(data.fc_memberaddress_loading1);
                    $('#fc_memberaddress_loading2').val(data.fc_memberaddress_loading2);
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function table_customer(){
        var tb = $('#tb_customer').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/master/get-data-customer-so-datatables/" +  $('#fc_branch').val(),
                type: 'GET'
            },
            columnDefs: [
                { className: 'text-center', targets: [0,7] },
            ],
            columns: [
                { data: 'fc_membercode' },
                { data: 'fc_membername1' },
                { data: 'fc_memberaddress1' },
                { data: 'member_type_business.fv_description' },
                { data: 'member_typebranch.fv_description' },
                { data: 'member_legal_status.fv_description' },
                { data: 'fc_membernpwp_no' },
                { data: 'fc_membernpwp_no' },
            ],
            rowCallback : function(row, data){
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_customer('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function detail_customer($id){
        $.ajax({
            url : "/master/data-customer-first/" + $id,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                var data = response.data;
                console.log(data);
                $("#modal_customer").modal('hide');
                Object.keys(data).forEach(function (key) {
                    var elem_name = $('[name=' + key + ']');
                    elem_name.val(data[key]);
                });

                $('#fc_member_branchtype_desc').val(data.member_typebranch.fv_description);
                $('#fc_membertypebusiness_desc').val(data.member_type_business.fv_description);
                $('#fc_memberlegalstatus_desc').val(data.member_legal_status.fv_description);
                $('#status_pkp').val(data.member_tax_code.fv_description + " (" + data.member_tax_code.fc_action + "%" + ")");
                $('#fm_memberAP').val("Rp. " + fungsiRupiah(data.fm_memberAP));
                $('#fn_memberAgingAP').val(data.fn_memberAgingAP + " Hari");

            },error: function (jqXHR, textStatus, errorThrown){
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

</script>
@endsection
