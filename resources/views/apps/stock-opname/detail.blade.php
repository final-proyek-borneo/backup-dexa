@extends('partial.app')
@section('title', 'Stock Opname')
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
        display: inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal :
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Tipe Opname</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $data->fc_stockopname_type }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Tanggal Mulai</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($data->fd_stockopname_start)->format('d/m/Y') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Gudang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $data->fc_warehousecode }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Opname</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Jumlah Stock</label>
                                    <input type="text" class="form-control" value="{{ $jumlah_stock }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-8">
                                <div class="form-group">
                                    <label>Nama Gudang</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse->fc_rackname ?? 'Seluruh Dexa' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Gudang</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse->fc_warehouseaddress ?? 'Seluruh Dexa' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Jenis Gudang</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse->fc_warehousepos ?? 'Seluruh Dexa' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    @php
                                    use Carbon\Carbon;
                                    $start_date = Carbon::parse($data->fd_stockopname_start);
                                    $today = Carbon::today();
                                    $days_difference = $start_date->diffInDays($today);
                                    @endphp
                                    <label>Telah Berlangsung</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $days_difference }}" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Hari
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group d-flex-row">
                                    <label>Stock Teropname</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success" style="font-size:large" id="stock_teropname" name="stock_teropname">{{ $stock_teropname ?? '0' }}/{{ $jumlah_stock }} Stock</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- STOCK OPNAME --}}
        @if($data->fc_stockopname_type == 'ALLDEXA' || $data->fc_stockopname_type == 'BRANCH')
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Stock yang Diopname</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Stock yang Diopname</h4>
                    <div class="card-header-action d-flex justify-content-between">
                        <button type="button" onclick="click_inventory()" class="btn btn-warning mr-2"><i class="fa-solid fa-boxes-stacked mr-1"></i> Cek Persediaan</button>
                        <button type="button" onclick="click_stock_opname()" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambah Stock Opname</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_satuan" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/stock-opname/detail/submit-stockopname" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Stock Opname</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_stock_opname" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Inventory Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_inventory" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Kode Barang</th>
                                <th scope="col" class="text-center">Kode Barang</th>
                                <th scope="col" class="text-center">Nama Barang</th>
                                <th scope="col" class="text-center">Satuan</th>
                                <th scope="col" class="text-center">Batch</th>
                                <th scope="col" class="text-center">Exp. Date</th>
                                <th scope="col" class="text-center">Qty</th>
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

<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Ketersediaan Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_persediaan" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Brand</th>
                                    <th scope="col" class="text-center">Sub Group</th>
                                    <th scope="col" class="text-center">Tipe Stock</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
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
    var warehousecode = "{{ $data->fc_warehousecode }}";
    var encode_warehousecode = window.btoa(warehousecode);

    var tipe_opname = '{{  $data->fc_stockopname_type }}' ?? '';

    function click_stock_opname() {
        $('#modal_stock_opname').modal('show');
    }

    function click_inventory() {
        $('#modal_inventory').modal('show');
    }

    var tb = $('#tb').DataTable({
        // apabila data kosongs
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/stock-opname/detail/datatables",
            type: 'GET',
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                visible: false,
                searchable: true,
                targets: [1]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_barcode'
            },
            {
                data: 'invstore.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'invstore.stock.fc_namepack',
                defaultContent: '-'
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    if (data.fc_status == 'L') {
                        return `
                        <div class="input-group">
                            <input type="number" id="fn_quantity_${data.fn_rownum}" min="0" class="form-control" value="${data.fn_quantity}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text bg-success" style="color: white; font-weight:600">${data.invstore.stock.fc_namepack}</span>
                            </div>
                        </div>`;
                    } else {
                        return `
                        <div class="input-group">
                            <input type="number" id="fn_quantity_${data.fn_rownum}" min="0" class="form-control" value="${data.fn_quantity}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-success" style="color: white; font-weight:600">${data.invstore.stock.fc_namepack}</span>
                            </div>
                        </div>`;
                    }
                }
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            if (data['fc_status'] == 'L') {
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-danger btn-md" data-id="${data.fn_rownum}" data-tipe="unlock" data-quantity="${data.fn_quantity}" data onclick="editLockStatus(this)"><i class="fa fa-lock"> </i></button>
                `);
            } else {
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-primary btn-sm" data-id="${data.fn_rownum}" data-tipe="lock" data-quantity="${data.fn_quantity}" data onclick="editLockStatus(this)"><i class="fa fa-unlock-alt"> </i> Kunci</button>
                `);
            }
        },
    });

    var tb_persediaan = $('#tb_persediaan').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [
            [7, 'asc']
        ],
        ajax: {
            url: "/apps/stock-opname/detail/datatables-persediaan/" + encode_warehousecode,
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
        ],
    });

    var tb_inventory = $('#tb_inventory').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/stock-opname/detail/inventory/datatables/" + encode_warehousecode,
            type: 'GET',
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                visible: false,
                searchable: true,
                targets: [1]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_barcode'
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'stock.fc_namelong'
            },
            {
                data: 'stock.fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired',
                render: formatTimestamp
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    var barcodeEncode = window.btoa(data.fc_barcode);
                    return `<input type="number" id="fn_quantity_${barcodeEncode}" min="0" class="form-control" value="${data.fn_quantity}">`;
                }
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm" onclick="select_stock('${data.fc_barcode}')"><i class="fa fa-check"> </i> Pilih</button>
                `);
        },
    });

    var tb_satuan = $('#tb_satuan').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/stock-opname/detail/datatables-satuan",
            type: 'GET',
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                visible: false,
                searchable: true,
                targets: [1]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_barcode'
            },
            {
                data: 'invstore.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'invstore.stock.fc_namepack'
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_quantity',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = '/apps/stock-opname/detail/delete/' + data.fn_rownum;

            $('td:eq(7)', row).html(`
                <button type="button" class="btn btn-danger btn-sm" onclick="delete_item('${url_delete}','${data.invstore.stock.fc_namelong}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    function editLockStatus(quantity) {
        var id = $(quantity).data('id');
        var quantity_edit = $(quantity).data('quantity');
        var tipe = $(quantity).data('tipe');
        var newQuantity = parseFloat($(`#fn_quantity_${id}`).val());

        if (tipe == 'unlock') {
            swal({
                title: "Konfirmasi",
                text: "Apakah kamu yakin ingin membuka kunci data ini?",
                icon: "warning",
                buttons: ["Cancel", "Update"],
                dangerMode: true,
            }).then(function(confirm) {
                if (confirm) {
                    updateLock(id, newQuantity, tipe);
                }
            });
        } else {
            swal({
                title: "Konfirmasi",
                text: "Apakah kamu yakin ingin update data ini?",
                icon: "warning",
                buttons: ["Cancel", "Update"],
                dangerMode: true,
            }).then(function(confirm) {
                if (confirm) {
                    updateLock(id, newQuantity, tipe);
                }
            });
        }
    }

    function updateLock(id, newQuantity, tipe) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/stock-opname/detail/lock-update',
            type: 'PUT',
            data: {
                fn_rownum: id,
                fn_quantity: newQuantity,
                tipe: tipe
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    tb.ajax.reload();
                    location.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                    $("#modal_loading").modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function select_stock(fc_barcode) {
        var barcodeEncode = window.btoa(fc_barcode);

        // modal loading
        $('#modal_loading').modal('show');
        $.ajax({
            url: '/apps/stock-opname/detail/select_stock',
            type: "POST",
            data: {
                'fc_barcode': fc_barcode,
                'fn_quantity': $(`#fn_quantity_${barcodeEncode}`).val(),
            },
            dataType: 'JSON',
            success: function(response, textStatus, jQxhr) {
                // modal loading hide
                $('#modal_loading').modal('hide');
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

    function delete_item(url, nama) {
        swal({
                title: 'Warning!',
                text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);

                            if (response.status === 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_satuan.ajax.reload(null, false);
                                //  location.href = location.href;
                            } else if (response.status === 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_satuan.ajax.reload(null, false);
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

    function click_cancel() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan mengcancel Stock Opname ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/stock-opname/cancel',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
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
</script>
@endsection