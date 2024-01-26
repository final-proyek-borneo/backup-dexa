@extends('partial.app')
@section('title', 'List Order')
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                @if (session('warning'))
                <div class="alert alert-danger">
                    {{ session('warning') }}
                </div>
                @endif
                <div class="card-header">
                    <h4>Data Sales Order</h4>
                </div>
                {{-- menambahkan session dari with --}}

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. SO</th>
                                    <th scope="col" class="text-center">Order</th>
                                    <th scope="col" class="text-center">Expired</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Customer</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <!-- <th scope="col" class="text-center">Total</th> -->
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

@section('js')
<script>
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        order: [[2, 'desc']],
        ajax: {
            url: '/apps/delivery-order/datatables/',
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_sodatesysinput',
                render: formatTimestamp
            },
            {
                data: 'fd_soexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_sotype'
            },
            {
                data: 'customer.fc_membername1'
            },
            {
                data: 'fc_sostatus'
            },
            {
                data: 'fn_sodetail'
            },
            // {
            //     data: 'fm_brutto',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data
                .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
            var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data
                .fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

            var fc_divisioncode = window.btoa(data.fc_divisioncode);
            var fc_branch = window.btoa(data.fc_branch);
            var fc_sono = window.btoa(data.fc_sono);

            $('td:eq(6)', row).html(`<i class="${data.fc_sostatus}"></i>`);
            if (data['fc_sostatus'] == 'F') {
                $('td:eq(6)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else if (data['fc_sostatus'] == 'P') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Pending</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(8)', row).html(`
                <a href="/apps/delivery-order/detail/${fc_sono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
                `); 
            //$('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
            //if (data['fc_sostatus'] == 'F') {
            //    $('td:eq(7)', row).html('<span class="badge badge-primary">Waiting</span>');
            //    $('td:eq(9)', row).html(`
            //        <a href="/apps/delivery-order/detail/${data.fc_divisioncode}/${data.fc_branch}/${data.fc_sono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
            //     `);
            //} else if (data['fc_sostatus'] == 'P') {
            //     $('td:eq(7)', row).html('<span class="badge badge-success">Clear</span>');
            //     $('td:eq(9)', row).html(`
            //      <a href="/apps/delivery-order/detail/${data.fc_sono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
            //   `);
            //  $(row).hide(); 
            //     $('td:eq(7)', row).html('<span class="badge badge-primary">Waiting</span>');
            //     $('td:eq(9)', row).html(`
            //         <a href="/apps/delivery-order/detail/${data.fc_divisioncode}/${data.fc_branch}/${data.fc_sono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
            //      `);
            // } else {
            //     $('td:eq(7)', row).html('<span class="badge badge-warning">Process</span>');
            //     $('td:eq(9)', row).html(`
            //      <button class="btn btn-light btn-sm mr-1" disabled><i class="fa fa-check"></i></button>
            //   `);
            //     $(row).hide();
            // }
        }
    });
</script>
@endsection