@extends('partial.app')
@section('title', 'Konversi Stock')
@section('content')
<div class="section-body">
    <form id="form_submit_konversi" action="/apps/konversi-stock" method="POST" autocomplete="off">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Stok Konversi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="text" id="barcode_result_convert" name="barcode_result_convert" hidden>
                            <input type="text" id="stockcode_to_convert" name="stockcode_to_convert" hidden>
                            <div class="col-12 col-lg-4 col-sm-5">
                                <div class="form-group">
                                    <label>Posisi Gudang</label>
                                    <select class="form-control select2 required-field required-field" name="fc_warehousecode" id="fc_warehousecode"></select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Pilih Stock</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control required-field" id="fc_barcode" name="fc_barcode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_inventory()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-sm-3">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control required-field" id="fn_quantity" name="fn_quantity">
                                        <div class="input-group-append">
                                            <span id="namepack_to_convert1" class="input-group-text bg-success" style="color: white; font-weight:600">...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-sm-6">
                                <div class="form-group">
                                    <label>Konversikan Ke</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control required-field" id="fc_stockcode" name="fc_stockcode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_stock()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 col-sm-6">
                                <div class="form-group">
                                    <label>Skala</label>
                                    <div class="d-flex justify-content-center">
                                        <div class="input-group">
                                            <input type="number" class="form-control required-field" id="fn_scale1" name="fn_scale1">
                                            <div class="input-group-append">
                                                <span id="namepack_to_convert2" class="input-group-text bg-success" style="color: white; font-weight:600">...</span>
                                            </div>
                                        </div>
                                        <div class="mx-3 align-self-center">
                                            =
                                        </div>
                                        <div class="input-group">
                                            <input type="number" class="form-control required-field" id="fn_scale2" name="fn_scale2">
                                            <div class="input-group-append">
                                                <span id="namepack_from_convert" class="input-group-text bg-success" style="color: white; font-weight:600">...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Stok Dikonversi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-lg-8 col-sm-8">
                                <div class="form-group">
                                    <label>Nama Stok</label>
                                    <input type="text" class="form-control" id="namelong" name="namelong" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="namepack" name="namepack1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Batch</label>
                                    <input type="text" class="form-control" id="batch" name="batch" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Expired</label>
                                    <input type="text" class="form-control" id="expired" name="expired" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Stok Hasil</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-lg-8 col-sm-8">
                                <div class="form-group">
                                    <label>Nama Stok</label>
                                    <input type="text" class="form-control" id="namelong2" name="namelong2" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="namepack2" name="namepack2" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Batch</label>
                                    <input type="text" class="form-control" id="batch2" name="batch2" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Expired</label>
                                    <input type="text" class="form-control" id="expired2" name="expired2" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" class="form-control" id="quantity2" name="quantity2" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning">Konversi</button>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <h4>Riwayat Konversi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tb_history" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">Nama Gudang</th>
                            <th scope="col" class="text-center">Katalog</th>
                            <th scope="col" class="text-center">Nama Produk</th>
                            <th scope="col" class="text-center">Brand</th>
                            <th scope="col" class="text-center">Sub Group</th>
                            <th scope="col" class="text-center">Tipe Stock</th>
                            <th scope="col" class="text-center">Expired</th>
                            <th scope="col" class="text-center">Batch</th>
                            <th scope="col" class="text-center">Satuan</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-center">Saldo</th>
                            <th scope="col" class="text-center">Operator</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Inventory Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Barcode</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Brand</th>
                                    <th scope="col" class="text-center">Sub Group</th>
                                    <th scope="col" class="text-center">Tipe Stock</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Action</th>
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

<div class="modal fade" role="dialog" id="modal_stock" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Master Stock</h5>
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
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Brand</th>
                                    <th scope="col" class="text-center">Sub Group</th>
                                    <th scope="col" class="text-center">Tipe Stock</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Action</th>
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

<div class="modal fade" role="dialog" id="modal_note" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Catatan Konversi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="fv_description"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        get_data_warehouse();
    });

    function click_modal_stock(){
        $('#barcode_result_convert').val('');
        if($('#fc_barcode').val() == null || $('#fc_barcode').val() == ''){
            swal(
                'Perhatian',
                'Pilih Stock Yang Akan Dikonversi Terlebih Dahulu',
                'warning'
            )
        }else{
            $('#modal_stock').modal('show');
            table_stock();
        }
    }

    function click_modal_inventory() {
        if ( $('#fc_warehousecode').val() == '' || $('#fc_warehousecode').val() == null) {
            swal(
                'Perhatian',
                'Pilih Lokasi Gudang Terlebih Dahulu',
                'warning'
            )
        } else {
            $('#modal_inventory').modal('show');
            table_inventory();
        }
    }

    function table_stock() {
        var tb_stock = $('#tb_stock').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/master/get-data-stock-so-datatables",
                type: 'GET',

            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 5, 7]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'fc_namelong',
                },
                {
                    data: 'fc_brand',
                },
                {
                    data: 'fc_subgroup',
                },
                {
                    data: 'fc_typestock2',
                },
                {
                    data: 'namepack.fv_description',
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="pilih_stockcode('${data.fc_stockcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function table_inventory() {
        var fc_warehousecode = window.btoa($('#fc_warehousecode').val());
        var tb_inventory = $('#tb_inventory').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                url: "/apps/konversi-stock/invstore-warehouse/" + fc_warehousecode,
                type: 'GET'
            },
            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                }, 
                {
                    visible: false,
                    searchable: true,
                    targets: [2]
                }, 
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'fc_barcode',
                },
                {
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'stock.fc_brand'
                },
                {
                    data: 'stock.fc_subgroup'
                },
                {
                    data: 'stock.fc_typestock2'
                },
                {
                    data: 'stock.fc_namepack'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
                {
                    data: null
                },
            ], 
            rowCallback : function(row, data) {
                $('td:eq(10)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm mr-1" onclick="pilih_barcode('${data.fc_stockcode}', '${data.stock.fc_namelong}','${data.fc_barcode}', '${data.stock.fc_namepack}', '${data.fn_quantity}', '${data.fc_batch}', '${data.fd_expired}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }

    function pilih_stockcode(fc_stockcode){
        var stockcodeEncode = window.btoa(fc_stockcode);
        var fc_warehousecode = window.btoa($('#fc_warehousecode').val());
        var fc_batch = window.btoa($('#batch').val());
        var fd_expired = window.btoa($('#expired').val());
        var currStockcode = $('#stockcode_to_convert').val()
        
        console.log(currStockcode + " " + fc_stockcode);
        if(cek_stock_percist(fc_stockcode, currStockcode)){
            swal("Oops! Masukkan stock yang berbeda dari sebelumnya", { icon: 'warning', });
            return;
        }

        $('#modal_stock').modal('hide');
        $('#modal_loading').modal('show');
        $.ajax({
            url: '/apps/konversi-stock/invstore-stockcode/' + stockcodeEncode + '/' + fc_warehousecode + '/' + fd_expired + '/' + fc_batch,
            type: 'GET', 
            dataType: 'JSON',
            success: function(response, textStatus, jQxhr) {
                var data = response.data;

                if (response.status === 200) {
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    $('#barcode_result_convert').val(data.fc_barcode);
                    $('#namepack_from_convert').text(data.stock.fc_namepack);
                    $('#fc_stockcode').val(data.fc_stockcode);
                    $('#namelong2').val(data.stock.fc_namelong);
                    $('#namepack2').val(data.stock.fc_namepack);
                    $('#batch2').val(data.fc_batch);
                    $('#expired2').val(data.fd_expired);
                    $('#quantity2').val(data.fn_quantity);
                } else {
                    $.ajax({
                        url: '/apps/konversi-stock/stock-stockcode/' + stockcodeEncode,
                        dataType: 'JSON',
                        success: function(response, textStatus, jQxhr) {
                            var data = response.data;

                            if (response.status === 200) {
                                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                                $('#namepack_from_convert').text(data.fc_namepack);
                                $('#fc_stockcode').val(data.fc_stockcode);
                                $('#namelong2').val(data.fc_namelong);
                                $('#namepack2').val(data.fc_namepack);
                                $('#batch2').val("XXXXXXXXX");
                                $('#expired2').val("XXXX-XX-XX");
                                $('#quantity2').val(0);
                            }
                        },
                        error: function(jqXhr, textStatus, errorThrown) {
                            $('#modal_loading').modal('hide');
                            console.log(errorThrown);
                            console.warn(jqXhr.responseText);
                        },
                    });
                }
            },
            error: function(jqXhr, textStatus, errorThrown) {
                $('#modal_loading').modal('hide');
                console.log(errorThrown);
                console.warn(jqXhr.responseText);
            },
        });
    }

    function pilih_barcode(fc_stockcode, fc_namelong, fc_barcode, fc_namepack, fn_quantity, fc_batch, fd_expired){
        $('#modal_inventory').modal('hide');
        $('#modal_loading').modal('show');
        $('#fc_barcode').val(fc_barcode);
        $('#fn_quantity').val(fn_quantity);
        $('#namepack_to_convert1').text(fc_namepack);
        $('#namepack_to_convert2').text(fc_namepack);
        
        $('#stockcode_to_convert').val(fc_stockcode);
        $('#namelong').val(fc_namelong);
        $('#namepack').val(fc_namepack);
        $('#batch').val(fc_batch);
        $('#expired').val(fd_expired);
        $('#quantity').val(fn_quantity);
        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
    }

    function get_data_warehouse(){
        $.ajax({
            url: '/data-master/master-warehouse/datatables',
            type: 'GET',
            dataType: "JSON",
            success: function(response){
                var data = response.data;
                if(data.length > 0){
                    $("#fc_warehousecode").empty();
                    $("#fc_warehousecode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_warehousecode").append(`<option value="${data[i].fc_warehousecode}">${data[i].fc_rackname}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error !',
                        message: response.message,
                        position: 'topright',
                    })
                }
                
                // }else{
                    // iziToast.error({
                    //     title: 'Error!',
                    //     message: response.message,
                    //     position: 'topRight'
                    // });
                // }
            },error: function (jqXHR, textStatus, errorThrown){
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        })
    }

    function cek_quantity(){
        var currQty = $('#fn_quantity').val();
        var maxQty = $('#quantity').val();

        if(currQty <= maxQty){
            return true;
        } else {
            return false;
        }
    }

    function cek_stock_percist(currStockcode, newStockcode){
        if(currStockcode == newStockcode){
            return true;
        } 
        return false;
    }

    function click_detail_note(fv_description){
        $('#fv_description').text(fv_description);
        $('#modal_note').modal('show');
    }

    var tb_history = $('#tb_history').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/konversi-stock/history-konversi",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14]
        }],
        columns: [
            {
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'warehouse.fc_rackname'
            },
            {
                data: 'invstore.fc_stockcode',
            },
            {
                data: 'invstore.stock.fc_namelong',
            },
            {
                data: 'invstore.stock.fc_brand',
            },
            {
                data: 'invstore.stock.fc_subgroup',
            },
            {
                data: 'invstore.stock.fc_typestock2',
            },
            {
                data: 'invstore.fd_expired',
            },
            {
                data: 'invstore.fc_batch',
            },
            {
                data: 'invstore.stock.fc_namepack',
            },
            {
                data: null,
            },
            {
                data: null,
            },
            {
                data: 'fn_balance',
            },
            {
                data: 'fc_userid',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            if(data.fn_in == 0){
                $('td:eq(10)', row).html(`<span class="badge badge-warning">Dikonversi</span>`);
                $('td:eq(11)', row).html(data.fn_out);
            } else {
                $('td:eq(10)', row).html(`<span class="badge badge-success">Output</span>`);
                $('td:eq(11)', row).html(data.fn_in);
            }

            $('td:eq(14)', row).html(`
                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="click_detail_note('${data.fv_description}')"><i class="fa fa-eye"></i> Catatan</button>
            `);
        }
    })

    $('#form_submit_konversi').on('submit', function(e){
       e.preventDefault();

       var form_id = $(this).attr("id");
       if(check_required(form_id) === false){
            swal("Oops! Mohon isi field yang kosong", { icon: 'warning', });
            return;
       }

       if(!cek_quantity()){
            swal("Oops! Jumlah Qty melebihi batas yang tersedia", { icon: 'warning', });
            return;
       }

       swal({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan mengonversi?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
       })
       .then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url:  $('#form_submit_konversi').attr('action'),
                    type: $('#form_submit_konversi').attr('method'),
                    data: $('#form_submit_konversi').serialize(),
                    success: function(response){
                       setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                       if(response.status == 200){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            $("#form_submit")[0].reset();
                            reset_all_select();
                            tb_inventory.ajax.reload(null, false);
                            tb_stock.ajax.reload(null, false);
                        }
                        else if(response.status == 201){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            location.href = response.link;
                        }
                        else if(response.status == 203){
                            swal(response.message, { icon: 'success', });
                            $("#modal").modal('hide');
                            tb_inventory.ajax.reload(null, false);
                            tb_stock.ajax.reload(null, false);
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