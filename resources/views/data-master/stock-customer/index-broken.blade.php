@extends('partial.app')
@section('title','CPRR Customer')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

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
                <h4>Tambah Stock Customer</h4>
            </div>
            <div class="card-body">
                <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <form id="form_submit" action="/data-master/stock-customer/store-update" method="POST" autocomplete="off">
                    <input type="text" name="type" id="type" hidden>
                    <input type="number" name="id" id="id" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6" hidden>
                                <div class="form-group">
                                    <label>Division Code</label>
                                    <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                                </div>
                            </div>
                           <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group required">
                                    <label>Cabang</label>
                                    <select class="form-control select2 required-field" name="fc_branch" id="fc_branch" required></select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group required">
                                    <label>Member Code</label>
                                    <select class="form-control select2 required-field" name="fc_membercode" id="fc_membercode" required></select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>-</label>
                                    <button type="button" class="btn btn-info btn-block" onclick="click_choose_product()">Choose Product</button>
                                    {{-- <select class="form-control select2 required-field" name="fc_stockcode" id="fc_stockcode"></select> --}}
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 place_hidden" hidden>
                                <div class="form-group">
                                    <label>Katalog Product</label>
                                    <input type="text" class="form-control" name="fc_barcode" id="fc_barcode" hidden readonly>
                                    <input type="text" class="form-control" name="fc_stockcode" id="fc_stockcode" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 place_hidden" hidden>
                                <div class="form-group">
                                    <label>Name Short</label>
                                    <input type="text" class="form-control" name="fc_nameshort" id="fc_nameshort" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 place_hidden" hidden>
                                <div class="form-group">
                                    <label>Name Long</label>
                                    <input type="text" class="form-control" name="fc_namelong" id="fc_namelong" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price Customer</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_customer" id="fm_price_customer" onkeyup="return onkeyupRupiah(this.id);" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_default" id="fm_price_default" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price Distributor</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_distributor" id="fm_price_distributor" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price Project</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_project" id="fm_price_project" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price Dealer</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_dealer" id="fm_price_dealer" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Price End User</label>
                                    <input type="text" class="form-control format-rp" name="fm_price_enduser" id="fm_price_enduser" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" onclick="click_reset()" hidden id="button_reset" class="btn btn-danger">Reset Data</button>
                        <button type="submit" class="btn btn-success">Simpan Data Stock Customer</button>
                    </div>
                </form>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           <div class="card-header">
               <h4>Data Master Stock Customer</h4>
           </div>
           <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-striped" id="tb" width="100%">
                    <thead style="white-space: nowrap">
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Divisi</th>
                          <th scope="col" class="text-center">Branch</th>
                          <th scope="col" class="text-center">Katalog</th>
                          <th scope="col" class="text-center">Nama Barang</th>
                          <th scope="col" class="text-center">Member Code</th>
                          <th scope="col" class="text-center">Price Customer</th>
                          <th scope="col" class="text-center">Price Default</th>
                          <th scope="col" class="text-center">Price Distributor</th>
                          <th scope="col" class="text-center">Price Project</th>
                          <th scope="col" class="text-center">Price Dealer</th>
                          <th scope="col" class="text-center">Price End User</th>
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
<div class="modal fade" role="dialog" id="modal_stock" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_stock" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Katalog Produk</th>
                                    {{-- <th scope="col" class="text-center">Barcode</th> --}}
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Price Default</th>
                                    <th scope="col" class="text-center">Price Distributor</th>
                                    <th scope="col" class="text-center">Price Project</th>
                                    <th scope="col" class="text-center">Price Dealer</th>
                                    <th scope="col" class="text-center">Price End User</th>
                                    <th scope="col" class="text-center" style="width: 25%">Actions</th>
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
@section('js')

<script>

    $(document).ready(function(){
        get_data_branch();
        get_data_stock_code();
        get_data_customer_code();
    })

    function click_reset(){
        $("#form_submit")[0].reset();
        $('#button_reset').attr('hidden', true);
    }

    function click_choose_product(){
        $('#modal_stock').modal('show');
        table_stock();
    }

    function table_stock(){
        var tb = $('#tb_stock').DataTable({
            processing: true,
            serverSide: false,
            destroy: true,
            ajax: {
                url: '/data-master/master-stock/datatables',
                type: 'GET'
            },
            columnDefs: [
                { className: 'text-center', targets: [0,8] },
            ],
            columns: [
                { data: 'DT_RowIndex',searchable: false, orderable: false},
                { data: 'fc_stockcode'},
                // { data: 'fc_barcode'},
                { data: 'fc_nameshort'},
                { data: 'fm_price_default',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'fm_price_distributor',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'fm_price_project',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'fm_price_dealer',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'fm_price_enduser',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
                { data: 'fm_price_enduser',render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
            ],
            rowCallback : function(row, data){

                $('td:eq(8)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="terpilih_stock('${data.fc_stockcode}', '${data.fc_barcode}')"><i class="fa fa-check"></i> Choose</button>
                `);
            }
        });
    }

    function terpilih_stock(stockcode, barcode){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/data-stock-by-primary/" + stockcode + "/" + barcode,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                $('#modal_stock').modal('hide');
                if(response.status === 200){
                    var data = response.data;
                    $('.place_hidden').attr('hidden', false);
                    $('#fc_barcode').val(data.fc_barcode);
                    $('#fc_stockcode').val(data.fc_stockcode);
                    $('#fc_nameshort').val(data.fc_nameshort);
                    $('#fc_namelong').val(data.fc_namelong);
                    $('#fm_price_customer').val(data.fm_price_customer);
                    $('#fm_price_default').val(data.fm_price_default);
                    $('#fm_price_distributor').val(data.fm_price_distributor);
                    $('#fm_price_project').val(data.fm_price_project);
                    $('#fm_price_dealer').val(data.fm_price_dealer);
                    $('#fm_price_enduser').val(data.fm_price_enduser);
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

    function get_data_stock_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Stock",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_stockcode").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_stockcode").append(`<option value="${data[i].fc_stockcode}">${data[i].fc_nameshort}</option>`);
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

    function get_data_customer_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    console.log(data)
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" selected readonly> - Pilih - </option>`);
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
      $(".modal-title").text('Tambah Stock Customer');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/stock-customer/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0] },
         { className: 'text-nowrap', targets: [12] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'stock.fc_stockcode' },
         { data: 'stock.fc_namelong' },
         { data: 'customer.fc_membername1' },
         { data: 'fm_price_customer', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_default', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_distributor', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_project', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_dealer', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_enduser', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fc_membercode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/stock-customer/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_stockcode + '/' + data.fc_barcode + '/' + data.fc_membercode;
         var url_delete = "/data-master/stock-customer/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_stockcode + '/' + data.fc_barcode + '/' + data.fc_membercode;

         $('td:eq(12)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}','${data.stock.fc_nameshort}','${data.stock.fc_namelong}', '${data.id}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_description}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url, nameshort, namelong, id){
      edit_action_custom(url, nameshort, namelong);
      $('id').val('id');
      $("#type").val('update');
   }

   function edit_action_custom(url, nameshort, namelong){
       save_method = 'edit';
       $("#modal_loading").modal('show');
       $.ajax({
          url : url,
          type: "GET",
          dataType: "JSON",
          success: function(response){
            $('.place_hidden').attr('hidden', false);
             setTimeout(function () {  $('#modal_loading').modal('hide');}, 500);
             Object.keys(response).forEach(function (key) {
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
                }else{
                   elem_name.val(response[key]);
                }
             });

             $('#fc_nameshort').val(nameshort);
             $('#fc_namelong').val(namelong);
             $('#button_reset').attr('hidden', false);
          },error: function (jqXHR, textStatus, errorThrown){
             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
             swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
          }
       });
    }
</script>
@endsection
