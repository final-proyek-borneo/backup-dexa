@extends('partial.app')
@section('title','Sales Order Detail')
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
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6" hidden>
                        <div class="form-group">
                            <label>Division Code</label>
                            <input type="text" class="form-control required-field" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Branch</label>
                            <input type="text" class="form-control required-field" @isset($data) value="{{ $data->branch->fv_description }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>So Type</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->fc_sotype }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>So Expired</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->fd_soexpired }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>So Reference</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->fc_soreference }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>So Transport</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->fc_sotransport }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Biaya Lain</label>
                            <input type="text" class="form-control format-rp" @isset($data) value="{{ "Rp " . number_format($data->fm_servpay,0,',','.') }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Customer Code</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->fc_membercode }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Tax Code</label>
                            <input type="text" class="form-control" readonly @isset($data) value="{{ $data->member_tax_code->fv_description }}" @endisset>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Member Address Loading 1</label>
                            <input type="text" class="form-control" readonly @isset($data) value="{{ $data->fc_memberaddress_loading1 }}" @endisset>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Member Address Loading 2</label>
                            <input type="text" class="form-control" readonly @isset($data) value="{{ $data->fc_memberaddress_loading2 }}" @endisset>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Sales</label>
                            <input type="text" class="form-control" @isset($data) value="{{ $data->sales->fc_salesname1 }}" @endisset readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Description Approved</label>
                            <textarea class="form-control" style="height: 80px" readonly>@isset($data) {{ $data->fv_sodesccriptionapproved }} @endisset</textarea>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>

      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <input type="text" hidden id="total" value="{{ $total }}">
            <input type="text" hidden id="grand" value="{{ $grand }}">
            <input type="text" hidden id="diskon" value="{{ $discount }}">
            <div class="card-body">
                <div class="float-right" style="width: 40%">
                    <div class="d-flex float-right">
                        <div style="margin-right: 40px">
                            <h5 class="float-right" style="font-size: 1.1rem">TOTAL</h5><br>
                            <h5 class="float-right" style="font-size: 1.1rem">DISKON</h5><br>
                            <hr style="border-top: 1px solid #d1d1d1; margin-top: 1.4rem; margin-bottom: .8rem; width: 150%">
                            <h4 class="float-right" style="font-size: 1.4rem;">GRAND</h4><br>
                        </div>
                        <div>
                            <h5 class="float-right" id="total_view" style="font-size: 1.1rem">{{ "Rp " . number_format($total,0,',','.') }}</h5><br>
                            <h5 class="float-right" id="discount_view" style="font-size: 1.1rem">- {{ "Rp " . number_format($discount,0,',','.') }}</h5><br>
                            <hr style="border-top: 1px solid #d1d1d1; margin-top: 1.4rem; margin-bottom: .8rem">
                            <h3 class="float-right" id="grand_view" style="font-size: 1.4rem;">{{ "Rp " . number_format($grand,0,',','.') }}</h3><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-12 col-md-4 col-lg-4">
        <div class="card">
           <div class="card-header">
               <h4>Data Stock</h4>
           </div>
           <div class="card-body">
                <div class="row">
                    <div class="table-responsive" style="overflow-x: unset">
                        <table class="table table-striped" id="tb_stock" width="100%">
                           <thead style="white-space: nowrap">
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Stock Code</th>
                                 <th scope="col" class="text-center">Barcode</th>
                                 <th scope="col" class="text-center">Name</th>
                                 <th scope="col" class="text-center justify-content-center">Actions</th>
                              </tr>
                           </thead>
                        </table>
                    </div>
                </div>
           </div>
        </div>
     </div>

      <div class="col-12 col-md-8 col-lg-8">
        <div class="card">
           <div class="card-header">
               <h4>Data Sales Order Detail</h4>
               <div class="card-header-action">
                    <button type="button" class="btn btn-warning" onclick="click_lock_so();"><i class="fa fa-lock mr-1"></i> Kunci SO</button>
            </div>
           </div>
           <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-striped" id="tb" width="100%">
                    <thead style="white-space: nowrap">
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Barcode</th>
                          <th scope="col" class="text-center">Namepack</th>
                          <th scope="col" class="text-center">Warehouse</th>
                          <th scope="col" class="text-center">Quantity</th>
                          <th scope="col" class="text-center">Bonus Qty</th>
                          <th scope="col" class="text-center">Harga</th>
                          <th scope="col" class="text-center">Disc (Rp)</th>
                          <th scope="col" class="text-center">Total</th>
                          <th scope="col" class="text-center">Description</th>
                          <th scope="col" class="text-center justify-content-center">Actions</th>
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
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title">Add Sales Order Detail</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit_custom" action="/apps/sales-order/detail/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Stock Code</label>
                                <input type="text" class="form-control" name="fc_stockcode" id="fc_stockcode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" class="form-control" name="fc_barcode" id="fc_barcode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="fc_name" id="fc_name" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Purchase</label>
                                <input type="text" class="form-control format-rp" name="fm_so_price" id="fm_so_price" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>SO Quantity</label>
                                <input type="number" min="1" class="form-control required-field" name="fn_so_qty" id="fn_so_qty" onkeyup="onkeyup_total_harga()">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>SO Quantity bonus</label>
                                <input type="number" min="0" class="form-control required-field" name="fn_so_bonusqty" id="fn_so_bonusqty" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>SO Disc (Rp)</label>
                                <input type="text" class="form-control required-field" name="fm_so_disc" id="fm_so_disc" value="0" onkeyup="onkeyup_total_harga()">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Total Harga</label>
                                <input type="text" class="form-control format-rp required-field" name="fn_so_value" id="fn_so_value" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Warehouse</label>
                                <select class="form-control select2" name="fc_warehousecode" id="fc_warehousecode">
                                    <option>NO GUDANG</option>
                                    @foreach ($warehouse as $item)
                                        <option value="{{ $item->fc_warehousecode }}">{{ $item->fc_rackname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="fv_description" id="fv_description" class="form-control" style="height: 80px"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add SO</button>
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
        get_data_sales_code();
        get_data_member_code();
    })

    function click_lock_so(){
        swal({
             title: 'Yakin?',
             text: 'Data yang SO sudah di lock tidak bisa dirollback?',
             icon: 'warning',
             buttons: true,
             dangerMode: true,
       })
       .then((willDelete) => {
             if (willDelete) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/sales-order/detail/lock',
                    type: "GET",
                    dataType: 'JSON',
                    success: function( response, textStatus, jQxhr ){
                        if(response.status == 201){
                            swal(response.message, { icon: 'success', });
                            setTimeout(function () { window.location.href = '/apps/sales-order' }, 1500);
                        }else{
                            swal(response.message, { icon: 'error', });
                        }
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                    console.warn(jqXhr.responseText);
                    },
                });
             }
       });
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
                    for (var i = 0; i < data.length; i++) {
                        if(i == 0) {
                            onchange_member_code(data[i].fc_membercode);
                        }
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
                    console.log(data.member_tax_code);
                    $('#fc_membertaxcode').val(data.fc_membercode);
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

    function get_data_sales_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Sales",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_salescode").empty();
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
    }

    function get_data_member_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_membercode").empty();
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

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah Sales Order');
      $("#form_submit_custom")[0].reset();
      change_branch();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/apps/sales-order/detail/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,4,5,10] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_barcode' },
         { data: 'fc_namepack' },
         { data: 'warehouse_desc' },
         { data: 'fn_so_qty' },
         { data: 'fn_so_bonusqty' },
         { data: 'fm_so_price', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_so_disc', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fn_so_value', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fv_description' },
         { data: 'fc_warehousecode' },
      ],
      rowCallback : function(row, data){
         var url_delete = "/apps/sales-order/detail/delete/" + data.fc_sono + '/' + data.fn_sorownum;

         $('td:eq(10)', row).html(`
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','SO Detail')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   var tb_stock = $('#tb_stock').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-stock/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,4] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_stockcode' },
         { data: 'fc_barcode' },
         { data: 'fc_nameshort' },
         { data: 'fc_nameshort' },
      ],
      rowCallback : function(row, data){
        $('td:eq(4)', row).html(`<button class="btn btn-success" onclick="click_choose_stock('${data.fc_stockcode}','${data.fc_barcode}', '${data.fc_nameshort}', '${data.fm_price_default}')"><i class="fa fa-check"></i> Choose</button>`);
      }
   });

    function click_choose_stock(stockcode, barcode, name, price){
        $('#modal').modal('show');
        $('#fc_stockcode').val(stockcode);
        $('#fc_barcode').val(barcode);
        $('#fc_name').val(name);
        $('#fm_so_price').val(price);
    }

    function onkeyup_total_harga(){
        $total_harga = ($('#fm_so_price').val() * $('#fn_so_qty').val()) - parseInt($('#fm_so_disc').val());
        console.log($total_harga);
        $('#fn_so_value').val($total_harga.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
    }

    $('#form_submit_custom').on('submit', function(e){
       e.preventDefault();

       var form_id = $(this).attr("id");
       if(check_required(form_id) === false){
          swal("Oops! Mohon isi field yang kosong", { icon: 'warning', });
          return;
       }

       swal({
             title: 'Yakin?',
             text: 'Apakah anda yakin akan menyimpan data ini?',
             icon: 'warning',
             buttons: true,
             dangerMode: true,
       })
       .then((willDelete) => {
             if (willDelete) {
                $("#modal_loading").modal('show');
                $.ajax({
                   url:  $('#form_submit_custom').attr('action'),
                   type: $('#form_submit_custom').attr('method'),
                   data: $('#form_submit_custom').serialize(),
                   success: function(response){
                      setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                      if(response.status == 200){
                        $('#discount').val(response.data.discount);
                        $('#total').val(response.data.total);
                        $('#grand').val(response.data.grand);
                        $('#discount_view').html(response.data.discount_view);
                        $('#total_view').html(response.data.total_view);
                        $('#grand_view').html(response.data.grand_view);
                         swal(response.message, { icon: 'success', });
                         $("#modal").modal('hide');
                         $("#form_submit_custom")[0].reset();
                         reset_all_select();
                         tb.ajax.reload(null, false);
                      }
                      else if(response.status == 201){
                         swal(response.message, { icon: 'success', });
                         $("#modal").modal('hide');
                         window.location.href = response.link;
                      }
                      else if(response.status == 203){
                         swal(response.message, { icon: 'success', });
                         $("#modal").modal('hide');
                         tb.ajax.reload(null, false);
                      }
                      else if(response.status == 300){
                         swal(response.message, { icon: 'error', });
                      }
                   },error: function (jqXHR, textStatus, errorThrown){
                      setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                      swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {  icon: 'error', });
                   }
                });
             }
       });
    });
</script>
@endsection
