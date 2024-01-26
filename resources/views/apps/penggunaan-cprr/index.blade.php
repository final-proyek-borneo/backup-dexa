@extends('partial.app')
@section('title', 'Penggunaan CPRR')
@section('css')
<style>
    .text-secondary {
        color: #969DA4 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .btn-secondary {
        background-color: #A5A5A5 !important;
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

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Gudang Eksternal</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Gudang</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Jumlah Item</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('modal')

    @endsection

    @section('js')
    <script>
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/apps/penggunaan-cprr/datatables",
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            }, {
                className: 'text-nowrap',
                targets: [1, 4]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rackname'
                },
                {
                    data: 'fc_warehouseaddress',
                    // defaultContent: '',
                },
                {
                    data: 'sum_quantity',
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                var fc_warehousecode = window.btoa(data.fc_warehousecode);
                $('td:eq(4)', row).html(`
                <a href="/apps/penggunaan-cprr/detail/${fc_warehousecode}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                `);
            },

        });
    </script>
    @endsection