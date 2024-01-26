@extends('partial.app')
@section('title','CPRR Customer')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Customer CPRR</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Divisi</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Nama Customer</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Jumlah Pemeriksaan</th>
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
        destroy: true,
        pageLength : 5,
        ajax: {
            url: '/data-master/cprr-customer/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 5, 6]
            },
            {
                className: 'text-nowrap',
                targets: [6]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode'
            },
            {
                data: 'branch.fv_description'
            },
            {
                data: 'fc_membername1',
                defaultContent: '-',
            },
            {
                data: 'fc_memberaddress1'
            },
            {
                data: 'cprr_customer_count',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var membercodeEncode = window.btoa(data.fc_membercode);
            var url_detail = "/data-master/cprr-customer/detail/" + membercodeEncode;

            $('td:eq(6)', row).html(`
                <a class="btn btn-info btn-sm mr-1" href="${url_detail}"><i class="fa fa-eyet"></i> Detail</a>
            `);
        }

    });
</script>
@endsection