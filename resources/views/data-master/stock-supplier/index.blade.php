@extends('partial.app')
@section('title','Stock Supplier')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }

    .table.dataTable  {
        font-size: 13px;
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
                <h4>Tambah Stock Supplier</h4>
            </div>
            <div class="card-body">
               <div class="row">
                    <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                    <form id="form_submit" action="/data-master/stock-supplier/store-update" method="POST" autocomplete="off">
                        <input type="text" name="type" id="type" hidden>
                        <input type="number" name="id" id="id" hidden>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6" hidden>
                                    <div class="form-group">
                                        <label>Division Code</label>
                                        <input type="text" class="form-control" name="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" id="fc_divisioncode" readonly>
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
                                        <label>Supplier Code</label>
                                        <select class="form-control select2 required-field" name="fc_suppliercode" id="fc_suppliercode" required></select>
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
                                {{-- <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Harga Pembelian dari Supplier</label>
                                        <input type="text" class="form-control format-rp" name="fm_purchase" id="fm_purchase" onkeyup="return onkeyupRupiah(this.id);">
                                    </div>
                                </div> --}}
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Price Supplier</label>
                                        <input type="text" class="form-control format-rp" name="fm_purchase" id="fm_purchase" onkeyup="return onkeyupRupiah(this.id);" required>
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
                            <button type="submit" class="btn btn-success">Simpan Data Stock Supplier</button>
                        </div>
                    </form>
               </div>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           <div class="card-header">
               <h4>Data Master Stock Supplier</h4>
           </div>
           <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-striped" id="tb" width="100%">
                    <thead style="white-space: nowrap">
                       <tr>
                          <th scope="col" class="text-center">No</th>
                          <th scope="col" class="text-center">Divisi</th>
                          <th scope="col" class="text-center">Branch</th>
                          <th scope="col" class="text-center">Katalog Barang</th>
                          <th scope="col" class="text-center">Nama Barang</th>
                          {{-- <th scope="col" class="text-center">Barcode</th> --}}
                          <th scope="col" class="text-center">Supplier Code</th>
                          <th scope="col" class="text-center">Price Supplier</th>
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
            <input type="text" id="counting" hidden>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_stock" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Stock Code</th>
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
        get_data_branch();
        get_data_stock_code();
        get_data_supplier_code();
        table_stock();
    })

    function click_reset(){
        $("#form_submit")[0].reset();
        $('#button_reset').attr('hidden', true);
    }

    function click_choose_product(){
        $('#modal_stock').modal('show');
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

    function get_data_supplier_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Supplier",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliercode").empty();
                    $("#fc_suppliercode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliercode").append(`<option value="${data[i].fc_suppliercode}">${data[i].fc_suppliername1}</option>`);
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
      $(".modal-title").text('Tambah Stock Supplier');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/stock-supplier/datatables',
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
         { data: 'fc_stockcode' },
         { data: 'stock.fc_namelong', defaultContent: '' },
        //  { data: 'fc_barcode' },
         { data: 'supplier.fc_suppliername1', defaultContent: '', },
         { data: 'fm_purchase', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_default', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_distributor', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_project', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_dealer', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_price_enduser', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fc_divisioncode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/stock-supplier/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_stockcode + '/' + data.fc_barcode + '/' + data.fc_suppliercode;
         var url_delete = "/data-master/stock-supplier/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_stockcode + '/' + data.fc_barcode + '/' + data.fc_suppliercode;

         $('td:eq(12)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}','${data.stock.fc_nameshort}','${data.stock.fc_namelong}', '${data.id}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_description}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url, nameshort, namelong, id){
      edit_action_custom(url,nameshort,namelong);
      $("#type").val('update');
      $("#id").val(id);
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