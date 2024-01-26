@extends('partial.app')
@section('title','Sales Order')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }
</style>
@endsection
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Sales Order</h4>
            </div>
             <form id="form_submit" action="/apps/sales-order/store-update" method="POST" autocomplete="off">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6" hidden>
                        <div class="form-group">
                            <label>Division Code</label>
                            <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="form-control select2 required-field" name="fc_branch" id="fc_branch" onchange="change_branch()"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>So Type</label>
                            <select class="form-control select2 required-field" name="fc_sotype" id="fc_sotype">
                                <option value="Consignment">Consignment</option>
                                <option value="Regular SO">Regular SO</option>
                                <option value="Retailer">Retailer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>So Expired</label>
                            <input type="text" readonly class="form-control datepicker" name="fd_soexpired" id="fd_soexpired">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>So Reference</label>
                            <input type="text" class="form-control" name="fc_soreference" id="fc_soreference">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>So Transport</label>
                            <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                <option value="Paket">Paket</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="Dexa">Dexa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Biaya Lain</label>
                            <input type="text" class="form-control format-rp" name="fm_servpay" id="fm_servpay" onkeyup="return onkeyupRupiah(this.id);">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Customer Code</label>
                            <select class="form-control select2" name="fc_membercode" id="fc_membercode" onchange="onchange_member_code(this.value)">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Tax Code</label>
                            <input type="text" class="form-control" name="fc_membertaxcode" id="fc_membertaxcode" hidden readonly>
                            <input type="text" class="form-control" name="fc_membertaxcode_view" id="fc_membertaxcode_view" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Member Address Loading 1</label>
                            <input type="text" class="form-control" name="fc_memberaddress_loading1" id="fc_memberaddress_loading1" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Member Address Loading 2</label>
                            <input type="text" class="form-control" name="fc_memberaddress_loading2" id="fc_memberaddress_loading2" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Sales</label>
                            <select class="form-control select2" name="fc_salescode" id="fc_salescode"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Description Approved</label>
                            <textarea name="fv_sodesccriptionapproved" id="fv_sodesccriptionapproved" class="form-control" style="height: 80px"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
             </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('js')
<script>

    $(document).ready(function(){
        get_data_branch();
        get_data_sales_code();
        get_data_member_code();
    })

    function get_data_branch(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_branch").empty();
                    $("#fc_branch").append(`<option selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                        }else{
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function change_branch(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/Sales/fc_branch/" + $('#fc_branch').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_salescode").empty();
                    $("#fc_salescode").append(`<option selected readonly> - Pilih - </option>`);
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
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });

        $.ajax({
            url : "/master/get-data-where-field-id-get/Customer/fc_branch/" + $('#fc_branch').val(),
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
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
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
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
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

</script>
@endsection
