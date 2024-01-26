@extends('partial.app')
@section('title', 'Mutasi Barang')
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
        display: inline;
    }
</style>
@endsection
@section('content')
<div class="section-body">
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
                {{-- <form id="form_submit" action="/apps/mutasi-barang/store-mutasi" method="POST" autocomplete="off"> --}}
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="{{ \Carbon\Carbon::parse( $data->fd_date_byuser )->isoFormat('D MMMM Y'); }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Jenis Mutasi</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_type_mutation }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Lokasi Awal</label>
                                    <div class="input-group mb-3">
                                        @if (empty($data->fc_startpoint_code))
                                        <input type="text" class="form-control" id="fc_startpoint" name="fc_startpoint" readonly>
                                        @else
                                        <input type="text" class="form-control" id="fc_startpoint" value="{{ $data->fc_startpoint_code }}" name="fc_startpoint" readonly>
                                        @endif
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_lokasi_awal()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <div class="input-group mb-3">
                                        @if (empty($data->fc_destination_code))
                                        <input type="text" class="form-control" id="fc_destination" name="fc_destination" readonly>
                                        @else
                                        <input type="text" class="form-control" id="fc_destination" value="{{ $data->fc_destination_code }}" name="fc_destination" readonly>
                                        @endif

                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_lokasi_tujuan()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>No. SO</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_sono_input" name="fc_sono" value="{{ $data->fc_sono ?? '-' }}" readonly>
                                        <div class="input-group-append">
                                            <button id="unclick" class="btn btn-primary" disabled onclick="click_modal_so()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button class="btn btn-danger" onclick="click_delete()">Cancel Mutasi</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Mutasi</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Awal</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse_start->fc_rackname }}" readonly>

                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse_destination->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Awal</label>
                                    <textarea type="text" class="form-control" data-height="76" value="{{ $data->warehouse_start->fc_warehouseaddress }}" readonly>{{ $data->warehouse_start->fc_warehouseaddress }}</textarea>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Tujuan</label>
                                    <textarea type="text" class="form-control" data-height="76" value="{{ $data->warehouse_destination->fc_warehouseaddress }}" readonly>{{ $data->warehouse_destination->fc_warehouseaddress }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Order Item</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_so" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Mutasi Qty</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Barang Mutasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center justify-content-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit_edit" action="/apps/mutasi-barang/detail/submit-mutasi-barang" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fc_description">Catatan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fc_description" name="fc_description">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button text-right mb-4">
                    <button type="submit" class="btn btn-success">Submit Mutasi</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Ketersediaan Stock</h5>
            </div>
            <div class="place_alert_cart_stock text-center"></div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" id="stock_inventory">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Katalog</th>
                                    <th scope="col" class="text-center">Barcode</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Exp.</th>
                                    <th scope="col" class="text-center">Quantity</th>
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
    function click_modal_inventory() {
        $('#modal_inventory').modal('show');
        table_inventory();
    }

    let encode_fc_sono = "{{ base64_encode($data->fc_sono) }}";
    // console.log(encode_fc_sono)

    var tb_so = $('#tb_so').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/mutasi-barang/datatables-so-detail/" + encode_fc_sono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'stock.fc_nameshort',
                defaultContent: '',
            },
            {
                data: 'namepack.fv_description'
            },
            {
                data: 'fn_so_qty'
            },
            {
                data: 'fn_do_qty'
            },
            {
                data: null
            },

        ],
        rowCallback: function(row, data) {
            var fc_stockcode = window.btoa(data.stock.fc_stockcode);
            $('td:eq(6)', row).html(`
            <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${fc_stockcode}')"><i class="fa fa-search"></i> Pilih Stock</button>`);

            if (data.fn_so_qty > data.fn_do_qty) {
                $('td:eq(6)', row).html(
                    `
                        <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${fc_stockcode}')"><i class="fa fa-search"></i> Pilih Stock</button>`
                );
            } else {
                $('td:eq(6)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`);
            }
        },
    });

    function table_inventory() {
        var fc_startpoint_code = "{{ $data->fc_startpoint_code }}";
        var tb_inventory = $('#tb_inventory').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/mutasi-barang/detail/datatables-inventory/" + fc_startpoint_code,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: null,
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(5)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm" onclick="detail_inventory('${data.fn_quantity}','${data.fc_stockcode}','${data.fc_barcode}','${data.stock.fc_namelong}')"><i class="fa fa-check"></i> Pilih</button>
                `);

            },
        });
    }

    function pilih_inventory(fc_stockcode) {
        // console.log(fc_stockcode);
        $("#modal_loading").modal('show');

        // tampilkan loading_data
        var stock_inventory_table = $('#stock_inventory');
        var fc_warehousecode = "{{ $data->fc_startpoint_code }}";
        if ($.fn.DataTable.isDataTable(stock_inventory_table)) {
            stock_inventory_table.DataTable().destroy();
        }
        stock_inventory_table.DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": '/apps/mutasi-barang/datatables-stock-inventory/' + fc_stockcode + '/' + fc_warehousecode,
                "type": "GET",
                "data": {
                    "fc_stockcode": fc_stockcode,
                }
            },
            "columns": [{
                    "data": 'DT_RowIndex',
                    "sortable": false,
                    "searchable": false
                },
                {
                    "data": "fc_stockcode"
                },
                {
                    "data": "fc_barcode"
                },
                {
                    "data": "stock.fc_namelong"
                },
                {
                    "data": "fn_quantity"
                },
                {
                    "data": "fc_batch"
                },
                {
                    "data": "fd_expired",
                    "render": function(data, type, row) {
                        return moment(data).format(
                            // format tanggal
                            'DD MMMM YYYY'
                        );
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        var barcodeEncode = window.btoa(data.fc_barcode);

                        for (let index = 0; index < data.stock.sodtl.length; index++) {
                            if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                var qty = data.stock.sodtl[index].fn_so_qty - data.stock.sodtl[
                                        index]
                                    .fn_do_qty;
                                break;
                            }
                        }

                        // console.log("qty"+qty);
                        if (qty >= data.fn_quantity) {
                            return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${data.fn_quantity}">`;
                        } else {
                            if (qty < 0) {
                                return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="0">`;
                            }
                            return `<input type="number" id="quantity_cart_stock_${barcodeEncode}" min="0" class="form-control" value="${qty}">`;
                        }
                        // }

                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        for (let index = 0; index < data.stock.sodtl.length; index++) {
                            if (data.stock.sodtl[index].fc_sono === '{{ $data->fc_sono }}') {
                                var qty = data.stock.sodtl[index].fn_so_qty - data.stock.sodtl[
                                        index]
                                    .fn_do_qty;
                                break;
                            }
                        }

                        if (qty == 0) {
                            return `<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`;
                        } else {
                            return `<button type="button" class="btn btn-primary" onclick="select_stock('${data.fc_barcode}','${data.fc_stockcode}')">Select</button>`;
                        }
                    }
                }
            ],
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 3, 4, 5, 7, 8]
                },
                {
                    className: 'text-nowrap',
                    targets: [8]
                },
                {
                    visible: false,
                    searchable: true,
                    targets: [2]
                },
            ],
            "initComplete": function() {
                // hidden modal loading
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                $('#modal_inventory').modal('show');

                stock_inventory_table.DataTable().ajax.reload();
                var table = stock_inventory_table.DataTable();
                var rows = table.rows().nodes();
                for (var i = 0; i < rows.length; i++) {
                    var row = $(rows[i]);
                    var fn_quantity = row.find('td:nth-child(4)').text();
                    if (fn_quantity == 0) {
                        table.row(row).remove().draw(false);
                    }
                }
            }
        });
    }

    function select_stock(fc_barcode, fc_stockcode) {
        var barcodeEncode = window.btoa(fc_barcode);
        // modal loading
        $('#modal_loading').modal('show');
        $.ajax({
            url: '/apps/mutasi-barang/detail/store_mutasi_detail',
            type: "POST",
            data: {
                'fc_barcode': fc_barcode,
                'fc_stockcode': fc_stockcode,
                'fn_qty': $(`#quantity_cart_stock_${barcodeEncode}`).val(),
                'fc_sono': '{{ $data->fc_sono }}',
            },
            dataType: 'JSON',
            success: function(response, textStatus, jQxhr) {
                // modal loading hide
                $('#modal_loading').modal('hide');
                $('.place_alert_cart_stock').empty();
                if (response.status === 200) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    iziToast.success({
                        title: 'Success!',
                        message: response.message,
                        position: 'topRight'
                    });
                    location.reload();
                } else {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    iziToast.error({
                        title: 'Gagal!',
                        message: response.message,
                        position: 'topRight'
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

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/mutasi-barang/detail/datatables",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'stock.fc_namelong'
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_qty'
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/mutasi-barang/detail/delete/" + data.fc_mutationno + '/' + data.fn_mutationrownum;

            $('td:eq(6)', row).html(`
                    <button class="btn btn-danger btn-sm" onclick="delete_action_dtl('${url_delete}', 'Mutasi Barang ini')"><i class="fa fa-trash"></i> Hapus Item</button>
                `);
        },
        // footer callback
        footerCallback: function(row, data, start, end, display) {
            $('#fn_detailitem').load(location.href + ' #fn_detailitem');
        }

    });

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan cancel data Mutasi Barang ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/mutasi-barang/cancel_mutasi',
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

    $('#form_submit_noconfirm').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_noconfirm').attr('action'),
            type: $('#form_submit_noconfirm').attr('method'),
            data: $('#form_submit_noconfirm').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    $('#fn_detailitem').load(location.href + ' #fn_detailitem');
                    $("#form_submit_noconfirm")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 201) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                    location.href = location.href;
                } else if (response.status == 203) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    });
</script>
@endsection