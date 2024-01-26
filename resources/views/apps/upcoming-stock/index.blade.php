@extends('partial.app')
@section('title', 'Upcoming Stock')
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

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .flex-row-item {
            font-size: 12px;
        }

        .grand-text {
            font-size: .9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Upcoming Stock</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal_detail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_detail" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">No. PO</th>
                                    <th scope="col" class="text-center">Kedatangan</th>
                                    <th scope="col" class="text-center">Nama Supplier</th>
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
    function click_modal_detail(fc_stockcode) {
        $('#modal_detail').modal('show');
        table_detail(fc_stockcode);
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/upcoming-stock/datatables",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, {
            className: 'text-nowrap',
            targets: []
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
                data: 'fc_namelong',
                // defaultContent: '',
            },
            {
                data: 'fc_namepack',
            },
            {
                data: 'total_qty',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_stockcode = window.btoa(data.fc_stockcode);
            $('td:eq(5)', row).html(`
                <button class="btn btn-primary btn-sm ml-1" onclick="click_modal_detail('${fc_stockcode}')"><i class="fa fa-eye"> </i> Detail</button>
                `);
        },
    });

    function table_detail(fc_stockcode) {
        var tb_detail = $('#tb_detail').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/apps/upcoming-stock/datatables-detail/" + fc_stockcode,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7]
            }, {
                className: 'text-nowrap',
                targets: []
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
                    data: 'fc_namelong',
                    // defaultContent: '',
                },
                {
                    data: 'fc_namepack',
                },
                {
                    data: 'QTY',
                },
                {
                    data: 'fc_pono',
                },
                {
                    data: 'kedatangan',
                    render: formatTimestamp
                },
                {
                    data: 'fc_suppliername1',
                },
            ],
        });
    }

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection