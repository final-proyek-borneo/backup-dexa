@extends('partial.app')
@section('title', 'BPB')
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
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>List Purchase Order</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="po_master" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. PO</th>
                                    <th scope="col" class="text-center">Order</th>
                                    <th scope="col" class="text-center">Expired</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Legal Status</th>
                                    <th scope="col" class="text-center">Supplier</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="button text-right mb-4">
                <a href="/apps/receiving-order"><button type="button" class="btn btn-info">Back</button></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
    var fc_suppliercode = "{{ $fc_suppliercode }}";
    var tb = $('#po_master').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[1, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables/good_reception/" + fc_suppliercode,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus',
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(7)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'F') {
                $('td:eq(7)', row).html('<span class="badge badge-primary">Pemesanan</span>');
            } else if (data['fc_postatus'] == 'P') {
                $('td:eq(7)', row).html('<span class="badge badge-warning">Pending</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(9)', row).html(`
                <a href="/apps/receiving-order/detail/${fc_pono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
                `);
        },
    });
</script>
@endsection