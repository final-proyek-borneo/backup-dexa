@extends('partial.app')
@section('title','Master Stock')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
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
                <h4>Data Master Stock</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Stock</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead style="white-space: nowrap">
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Divisi</th>
                           <th scope="col" class="text-center">Cabang</th>
                           <th scope="col" class="text-center">Kode Stock</th>
                           <th scope="col" class="text-center">Barcode</th>
                           <th scope="col" class="text-center">Nama Pendek</th>
                           <th scope="col" class="text-center">Nama Panjang</th>
                           <th scope="col" class="text-center">Hold</th>
                           <th scope="col" class="text-center">Batch</th>
                           <th scope="col" class="text-center">Expired</th>
                           <th scope="col" class="text-center">Serial Number</th>
                           <th scope="col" class="text-center">Status CAT Number</th>
                           <th scope="col" class="text-center">CAT Number</th>
                           <th scope="col" class="text-center">BlackList</th>
                           <th scope="col" class="text-center">Tax Type</th>
                           <th scope="col" class="text-center">Resupplier</th>
                           <th scope="col" class="text-center">Brand</th>
                           <th scope="col" class="text-center">Group</th>
                           <th scope="col" class="text-center">Subgroup</th>
                           <th scope="col" class="text-center">Tipe Stock 1</th>
                           <th scope="col" class="text-center">Tipe Stock 2</th>
                           <th scope="col" class="text-center">Name Pack</th>
                           <th scope="col" class="text-center">Reorder Level</th>
                           <th scope="col" class="text-center">Max</th>
                           <th scope="col" class="text-center">cogs</th>
                           <th scope="col" class="text-center">Purchase</th>
                           <th scope="col" class="text-center">Sales Price</th>
                           <th scope="col" class="text-center">FL Disc Date</th>
                           <th scope="col" class="text-center">FD Disc Begin</th>
                           <th scope="col" class="text-center">FD Disc End</th>
                           <th scope="col" class="text-center">FM Disc Rp</th>
                           <th scope="col" class="text-center">FM Disc Pr</th>
                           <th scope="col" class="text-center">FL Disc Time</th>
                           <th scope="col" class="text-center">FT Disc Begin</th>
                           <th scope="col" class="text-center">FT Disc End</th>
                           <th scope="col" class="text-center">FM Time Disc RP</th>
                           <th scope="col" class="text-center">FM Time Disc PR</th>
                           <th scope="col" class="text-center">Price Default</th>
                           <th scope="col" class="text-center">Price Distributor</th>
                           <th scope="col" class="text-center">Price Project</th>
                           <th scope="col" class="text-center">Price Dealer</th>
                           <th scope="col" class="text-center">Price End User</th>
                           <th scope="col" class="text-center">Stock Description</th>
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-stock/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" maxlength = "8" class="form-control required-field" name="fc_barcode" id="fc_barcode" value="fc_barcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Kode Stock</label>
                                <input type="text" class="form-control required-field" name="fc_stockcode" id="fc_stockcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Nama Pendek</label>
                                <input type="text" class="form-control required-field" name="fc_nameshort" id="fc_nameshort">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Nama Panjang</label>
                                <input type="text" class="form-control required-field" name="fc_namelong" id="fc_namelong">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Name Pack</label>
                                <select class="form-control select2" name="fc_namepack" id="fc_namepack" required></select>
                            </div>
                        </div>
                        <input type="text" hidden id="fc_brand_dummy">
                        <input type="text" hidden id="fc_group_dummy">
                        <input type="text" hidden id="fc_subgroup_dummy">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Brand</label>
                                <select class="form-control select2" name="fc_brand" id="fc_brand" onchange="get_data_group()" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Group</label>
                                <select class="form-control select2" name="fc_group" id="fc_group" onchange="get_data_subgroup()" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Sub Group</label>
                                <select class="form-control select2" name="fc_subgroup" id="fc_subgroup" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Batch</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_batch" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_batch" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Expired Date</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_expired" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_expired" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Serial Number</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_serialnumber" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_serialnumber" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Status CAT Number</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_catnumber" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_catnumber" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Blacklist</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_blacklist" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_blacklist" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tax Type</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_taxtype" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_taxtype" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Report Supplier</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_repsupplier" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_repsupplier" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-groupd">
                                <label>Detail CAT Number</label>
                                <input type="text" class="form-control" name="fc_catnumber" id="fc_catnumber">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Stock 1</label>
                                <select class="form-control select2" name="fc_typestock1" id="fc_typestock1" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Tipe Stock 2</label>
                                <select class="form-control select2" name="fc_typestock2" id="fc_typestock2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Reorder Level</label>
                                <input type="number" class="form-control required-field" name="fn_reorderlevel" id="fn_reorderlevel">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Max on Hand</label>
                                <input type="number" class="form-control required-field" name="fn_maxonhand" id="fn_maxonhand">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Purchase</label>
                                <input type="text" class="form-control format-rp required-field" name="fm_purchase" id="fm_purchase" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cogs</label>
                                <input type="text" class="form-control format-rp required-field" name="fm_cogs" id="fm_cogs" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Sales Price</label>
                                <input type="text" class="form-control format-rp required-field" name="fm_salesprice" id="fm_salesprice" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 row">
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Diskon Tanggal</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" name="fl_disc_date" id="fl_disc_date" value="T" class="fl_disc_date selectgroup-input" onclick="click_diskon_tanggal()">
                                            <span class="selectgroup-button">Yes</span>
                                        </label>
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" checked name="fl_disc_date" id="fl_disc_date" value="F" checked="" class="fl_disc_date selectgroup-input" onclick="click_diskon_tanggal()">
                                            <span class="selectgroup-button">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 place_diskon_tanggal" hidden>
                                <div class="form-group">
                                    <label>Tanggal Start</label>
                                    <input type="text" class="form-control datepicker" name="fd_disc_begin" id="fd_disc_begin">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 place_diskon_tanggal" hidden>
                                <div class="form-group">
                                    <label>Tanggal End</label>
                                    <input type="text" class="form-control datepicker" name="fd_disc_end" id="fd_disc_end">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2 place_diskon_tanggal" hidden>
                                <div class="form-group">
                                    <label>Rupiah</label>
                                    <input type="text" class="form-control format-rp" name="fm_disc_rp" id="fm_disc_rp" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2 place_diskon_tanggal" hidden>
                                <div class="form-group">
                                    <label>Persentase</label>
                                    <input type="number" class="form-control" name="fm_disc_pr" id="fm_disc_pr">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Diskon Waktu</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" name="fl_disc_time" id="fl_disc_time" value="T" class="selectgroup-input fl_disc_time" onclick="click_diskon_waktu()">
                                            <span class="selectgroup-button">Yes</span>
                                        </label>
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" checked name="fl_disc_time" id="fl_disc_time" checked="" value="F" class="selectgroup-input fl_disc_time" onclick="click_diskon_waktu()">
                                            <span class="selectgroup-button">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 place_diskon_waktu" hidden>
                                <div class="form-group">
                                    <label>Waktu Start</label>
                                    <input type="text" class="form-control time-format" name="ft_disc_begin" id="ft_disc_begin" maxlength="5" onkeypress="return hanyaAngka(event,false);" onkeyup="separator('ft_disc_begin', ':', 2)">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 place_diskon_waktu" hidden>
                                <div class="form-group">
                                    <label>Waktu End</label>
                                    <input type="text" class="form-control time-format" name="ft_disc_end" id="ft_disc_end" maxlength="5" onkeypress="return hanyaAngka(event,false);" onkeyup="separator('ft_disc_end', ':', 2)">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2 place_diskon_waktu" hidden>
                                <div class="form-group">
                                    <label>Rupiah</label>
                                    <input type="text" class="form-control format-rp" name="fm_time_disc_rp" id="fm_time_disc_rp" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2 place_diskon_waktu" hidden>
                                <div class="form-group">
                                    <label>Persentase</label>
                                    <input type="number" class="form-control" name="fm_time_disc_pr" id="fm_time_disc_pr">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group required">
                                <label>Price</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_default" id="fm_price_default" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Price Distributor</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_distributor" id="fm_price_distributor" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Price Project</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_project" id="fm_price_project" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group required">
                                <label>Price Dealer</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_dealer" id="fm_price_dealer" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group required">
                                <label>Price End User</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_enduser" id="fm_price_enduser" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="fv_stockdescription" id="fv_stockdescription" style="height: 50px" class="form-control"></textarea>
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

    $(document).ready(function(){
        get_data_branch();
        get_data_namepack();
        get_data_brand();
        get_data_type_stock1();
        get_data_type_stock2();
    })

    function click_diskon_tanggal(){
        if($('.fl_disc_date:checked').val() == 'F'){
            $('.place_diskon_tanggal').prop('hidden', true);
        }else{
            $('.place_diskon_tanggal').prop('hidden', false);
        }
    }

    function click_diskon_waktu(){
        if($('.fl_disc_time:checked').val() == 'F'){
            $('.place_diskon_waktu').prop('hidden', true);
        }else{
            $('.place_diskon_waktu').prop('hidden', false);
        }
    }

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
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
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

    function get_data_namepack(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/UNITY",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_namepack").empty();
                    $("#fc_namepack").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_namepack").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_brand(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/data-brand",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_brand").empty();
                    $("#fc_brand").append(`<option selected disabled>- Pilih -</option>`);
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_brand == $('#fc_brand_dummy').val()){
                            $("#fc_brand").append(`<option value="${data[i].fc_brand}" selected>${data[i].fc_brand}</option>`);
                        }else{
                            $("#fc_brand").append(`<option value="${data[i].fc_brand}">${data[i].fc_brand}</option>`);
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

    function get_data_group(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/data-group-by-brand",
            type: "GET",
            dataType: "JSON",
            data: {
                'fc_brand': $('#fc_brand').find(":selected").val(),
            },
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_group").empty();
                    $("#fc_group").append(`<option selected disabled>- Pilih -</option>`);
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_group == $('#fc_group_dummy').val()){
                            $("#fc_group").append(`<option value="${data[i].fc_group}" selected>${data[i].fc_group}</option>`);
                        }else{
                            $("#fc_group").append(`<option value="${data[i].fc_group}">${data[i].fc_group}</option>`);
                        }
                    }

                    get_data_subgroup();
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

    function get_data_subgroup(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/data-subgroup-by-group",
            type: "GET",
            dataType: "JSON",
            data: {
                'fc_group': $('#fc_group').find(":selected").val(),
            },
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_subgroup").empty();
                    $("#fc_subgroup").append(`<option selected disabled>- Pilih -</option>`);
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_subgroup == $('#fc_subgroup_dummy').val()){
                            $("#fc_subgroup").append(`<option value="${data[i].fc_subgroup}" selected>${data[i].fc_subgroup}</option>`);
                        }else{
                            $("#fc_subgroup").append(`<option value="${data[i].fc_subgroup}">${data[i].fc_subgroup}</option>`);
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

    function get_data_type_stock1(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/GOODSMATERY",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_typestock1").empty();
                    $("#fc_typestock1").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_typestock1").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_type_stock2(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/GOODSTRANS",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_typestock2").empty();
                    $("#fc_typestock2").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_typestock2").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah Master Stock');
      $("#form_submit")[0].reset();
      document.getElementById("fc_stockcode").readOnly = false;
      reset_all_select();
      click_diskon_tanggal();
      click_diskon_waktu();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/master-stock/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,7,8,9,10,11,12,13,14,25,30] },
         { className: 'text-nowrap', targets: [43] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'fc_stockcode' },
         { data: 'fc_barcode' },
         { data: 'fc_nameshort' },
         { data: 'fc_namelong' },
         { data: 'fc_hold' },
         { data: 'fl_batch' },
         { data: 'fl_expired' },
         { data: 'fl_serialnumber' },
         { data: 'fl_catnumber' },
         { data: 'fc_catnumber' },
         { data: 'fl_blacklist' },
         { data: 'fl_taxtype' },
         { data: 'fl_repsupplier' },
         { data: 'fc_brand' },
         { data: 'fc_group' },
         { data: 'fc_subgroup' },
         { data: 'type_stock1.fv_description' },
         { data: 'type_stock2.fv_description' },
         { data: 'namepack.fv_description' },
         { data: 'fn_reorderlevel' },
         { data: 'fn_maxonhand' },
         { data: 'fm_cogs', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_purchase', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_salesprice', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fl_disc_date' },
         { data: 'fd_disc_begin' },
         { data: 'fd_disc_end' },
         { data: 'fm_disc_rp', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_disc_pr' },
         { data: 'fl_disc_time' },
         { data: 'ft_disc_begin' },
         { data: 'ft_disc_end' },
         { data: 'fm_time_disc_rp', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_time_disc_pr' },
         { data: 'fm_price_default',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_distributor',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_project',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_dealer',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_enduser',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fv_stockdescription' },
         { data: 'fc_divisioncode' },
      ],
      rowCallback : function(row, data){
        var stockcodeEncode = window.btoa(data.fc_stockcode);
        var barcodeEncode = window.btoa(data.fc_barcode);
        var url_edit   = "/data-master/master-stock/detail/" + stockcodeEncode + '/' + barcodeEncode;
        var url_delete = "/data-master/master-stock/delete/" + data.fc_stockcode + '/' + data.fc_barcode;

        if(data.fc_hold == 'T'){
            $('td:eq(7)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(7)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_batch == 'T'){
            $('td:eq(8)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(8)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_expired == 'T'){
            $('td:eq(9)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(9)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_serialnumber == 'T'){
            $('td:eq(10)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(10)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_catnumber == 'T'){
            $('td:eq(11)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(11)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_blacklist == 'T'){
            $('td:eq(13)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(13)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_taxtype == 'T'){
            $('td:eq(14)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(14)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_repsupplier == 'T'){
            $('td:eq(15)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(15)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_disc_date == 'T'){
            $('td:eq(27)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(27)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fl_disc_time == 'T'){
            $('td:eq(32)', row).html(`<span class="badge badge-success">YES</span>`);
        }else{
            $('td:eq(32)', row).html(`<span class="badge badge-danger">NO</span>`);
        }

        if(data.fc_hold == 'F'){
            $('td:eq(43)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hold('${barcodeEncode}')"><i class="fa fa-lock"> </i> Hold</button>
        `);
        } else {
            $('td:eq(43)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-warning btn-sm" onclick="unhold('${barcodeEncode}')"><i class="fa fa-lock"> </i> Unhold</button>
            `)
        }
        // <button class="btn btn-warning btn-sm" onclick="delete_action('${url_delete}','${data.fc_nameshort}')"><i class="fa fa-trash"> </i> Hapus</button>
      }
   });

   function edit(url){
        reset_all_select()
        edit_action_custom(url, 'Edit Data Master Stock');
        $("#type").val('update');
        document.getElementById("fc_barcode").readOnly = true;
        document.getElementById("fc_stockcode").readOnly = true;
   }

   function edit_action_custom(url, modal_text){
       save_method = 'edit';
       $("#modal").modal('show');
       $(".modal-title").text(modal_text);
       $("#modal_loading").modal('show');
       $.ajax({
          url : url,
          type: "GET",
          dataType: "JSON",
          success: function(response){
             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);

             $('#fc_brand_dummy').val(response.fc_brand);
             $('#fc_group_dummy').val(response.fc_group);
             $('#fc_subgroup_dummy').val(response.fc_subgroup);

             Object.keys(response).forEach(function (key) {
                // console.log(response.fm_price_distributor);
                var elem_name = $('[name=' + key + ']');
                if (elem_name.hasClass('selectric')) {
                   elem_name.val(response[key]).change().selectric('refresh');
                }else if(elem_name.hasClass('select2')){
                   elem_name.select2("trigger", "select", { data: { id: response[key] } });
                }else if(elem_name.hasClass('selectgroup-input')){
                   $("input[name="+key+"][value=" + response[key] + "]").prop('checked', true);
                }else if(elem_name.hasClass('my-ckeditor')){
                   CKEDITOR.instances[key].setData(response[key]);
                }else if(elem_name.hasClass('summernote')){
                  elem_name.summernote('code', response[key]);
                }else if(elem_name.hasClass('custom-control-input')){
                   $("input[name="+key+"][value=" + response[key] + "]").prop('checked', true);
                }else if(elem_name.hasClass('time-format')){
                   elem_name.val(response[key].substr(0, 5));
                }else if(elem_name.hasClass('format-rp')){
                   var nominal = response[key].toString();
                   elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                   // tampilkan nilai fm_price_default
                   var nominal_default = response.fm_price_default.toString();
                   $('#fm_price_default').val(nominal_default.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                   // tampilkan nilai fm_price_distributor
                     var nominal_distributor = response.fm_price_distributor.toString();
                        $('#fm_price_distributor').val(nominal_distributor.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                   // tampilkan nilai fm_price_project
                        var nominal_project = response.fm_price_project.toString();
                        $('#fm_price_project').val(nominal_project.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                    // tampilkan nilai fm_price_dealer
                        var nominal_dealer = response.fm_price_dealer.toString();
                        $('#fm_price_dealer').val(nominal_dealer.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

                     // tampilkan nilai fm_price_enduser
                        var nominal_enduser = response.fm_price_enduser.toString();
                        $('#fm_price_enduser').val(nominal_enduser.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                   
                }else{
                   elem_name.val(response[key]);
                }
             });

             click_diskon_tanggal();
             click_diskon_waktu();

          },error: function (jqXHR, textStatus, errorThrown){
             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
             swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
          }
       });
    }

    function hold(barcodeEncode) {
            swal({
                title: "Konfirmasi",
                text: "Anda yakin ingin Hold stock ini?",
                type: "warning",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/data-master/master-stock/hold/' + barcodeEncode,
                        type: 'PUT',
                        data: {
                            fc_hold: 'T',
                            fc_barcode: barcodeEncode
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

        function unhold(barcodeEncode) {
            swal({
                title: "Konfirmasi",
                text: "Anda yakin ingin Unhold stock ini?",
                type: "warning",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/data-master/master-stock/unhold/' + barcodeEncode,
                        type: 'PUT',
                        data: {
                            fc_hold: 'F',
                            fc_barcode: barcodeEncode
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
