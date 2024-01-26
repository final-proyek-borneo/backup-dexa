@extends('partial.app')
@section('title', 'Detail Persediaan Gudang')
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
        <div class="col-12 col-md-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Kode Gudang</label>
                                    <input type="text" class="form-control" value="{{ $gudang_mst->fc_warehousecode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Nama Gudang</label>
                                    <input type="text" class="form-control" value="{{ $gudang_mst->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $gudang_mst->fc_warehouseaddress }}" readonly>
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
                    <h4>Data Persediaan Barang</h4>
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
                                        <th scope="col" class="text-center">Sebutan</th>
                                        <th scope="col" class="text-center">Brand</th>
                                        <th scope="col" class="text-center">Sub Group</th>
                                        <th scope="col" class="text-center">Tipe Stock</th>
                                        <th scope="col" class="text-center">Qty</th>
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
    <div class="text-right mb-4">
        <a href="/apps/marketing/persediaan"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_detail_inventory" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title" id="product_name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_detail_inventory" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
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
    function click_modal_detail_inventory(fc_stockcode, fc_namelong) {
        $('#modal_detail_inventory').modal('show');
        table_detail_inventory(fc_stockcode, fc_namelong);
    }

    let fc_warehousecode = "{{ ($gudang_mst->fc_warehousecode) }}";
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/persediaan-barang/datatables-detail/" + fc_warehousecode,
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'stock.fc_stockcode'
            },
            {
                data: 'stock.fc_namelong'
            },
            {
                data: 'stock.fc_nameshort'
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
                data: 'fn_quantity',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_namelong = window.btoa(data.stock.fc_namelong);
            var fc_stockcode = window.btoa(data.fc_stockcode);
            var fc_rono = window.btoa(data.fc_rono);
            var count = window.btoa(data.fn_qty_ro);
            var expired_date = window.btoa(data.fd_expired_date);
            var fc_batch = window.btoa(data.fc_batch);
            var fc_barcode = window.btoa(data.fc_barcode);

            $('td:eq(8)', row).html(`
                <button class="btn btn-warning btn-sm" onclick="click_modal_detail_inventory('${fc_stockcode}', '${fc_namelong}')"><i class="fa fa-eye"></i> Detail</button>
                `);
            // <a href="/apps/persediaan-barang/detail/generate-qr/${fc_barcode}/${count}/${expired_date}/${fc_batch}" target="_blank" class="btn btn-primary btn-sm ml-1"><i class="fa fa-qrcode"></i> Generate QR</a>
        },
    });

    function table_detail_inventory(fc_stockcode, fc_namelong) {
        var fc_warehousecode = "{{ $gudang_mst->fc_warehousecode }}";

        var namelong = window.atob(fc_namelong);
        namelong = namelong.replace(/&#039;/g, "'");
        var tb_detail_inventory = $('#tb_detail_inventory').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: "/apps/persediaan-barang/datatables-detail-inventory/" + fc_stockcode + '/' + fc_warehousecode,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                }, {
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
                    data: 'fn_quantity'
                },
            ],
            rowCallback: function(row, data) {
            },
        });
        $('#product_name').text(namelong);
    }
</script>
@endsection