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

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #0A9447;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Transit Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. GR</th>
                                    <th scope="col" class="text-center">Supplier</th>
                                    <th scope="col" class="text-center">Tgl Penerimaan</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Penerima</th>
                                    <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/master-penerimaan-barang/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 2, 3, 4, 5, 6, 7]
            }, {
                className: 'text-nowrap',
                targets: []
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_grno'
                },
                {
                    data: 'supplier.fc_suppliername1'
                },
                {
                    data: 'fd_arrivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fn_qtyitem'
                },
                {
                    data: 'fc_unit',
                },
                {
                    data: 'fc_recipient'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_grno = window.btoa(data.fc_grno);
                $('td:eq(7)', row).html(`
                    <a href="/apps/receiving-order/penerimaan-barang/${fc_grno}/${data.fc_suppliercode}" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Pilih</a>
                `);
            },
        });
    </script>
    @endsection