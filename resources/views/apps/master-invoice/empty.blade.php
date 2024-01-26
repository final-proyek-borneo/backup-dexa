@extends('partial.app')
@section('title', 'Master Invoice')
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
                        <h4>Data Master Invoice</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="incoming-tab" data-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="true">Incoming</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="outgoing-tab" data-toggle="tab" href="#outgoing" role="tab" aria-controls="outgoing" aria-selected="false">Outgoing</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb_incoming_invoice" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Inv No</th>
                                                <th scope="col" class="text-center">Dono</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Tgl Terbit</th>
                                                <th scope="col" class="text-center">Tgl Berakhir</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="outgoing" role="tabpanel" aria-labelledby="outgoing-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb_outgoing_invoice" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Inv No</th>
                                                <th scope="col" class="text-center">Dono</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Tgl Terbit</th>
                                                <th scope="col" class="text-center">Tgl Berakhir</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function click_modal_update_invoice(fc_dono) {
            $('#modal_update_invoice').modal('show');
        }
        
        $(document).ready(function() {
                $('#fc_kode').on('change', function() {
                    var option_id = $(this).val();
                    $('#fv_description').empty();
                    if (option_id != "") {
                        $.ajax({
                            url: "{{ url('/apps/sales-order/detail/payment/getdata') }}/" + option_id,
                            type: "GET",
                            dataType: "json",
                            success: function(fc_kode) {
                                $.each(fc_kode, function(key, value) {

                                    $('#fv_description').append(
                                        '<label>Deskripsi Bayar</label><input type="text" value="' +
                                        value['fv_description'] +
                                        '" class="form-control " name="fc_description" id="fv_description" readonly>'
                                    );

                                });
                            }
                        });
                    } else {
                        $('#fv_description').empty();
                    }
                });
            });

        var tb = $('#tb_incoming_invoice').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/apps/master-invoice/datatables',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7, 8]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 6, 8]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_invno'
                },
                {
                    data: 'fc_dono'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fd_inv_releasedate',
                    render: formatTimestamp
                },
                {
                    data: 'fd_inv_agingdate',
                    render: formatTimestamp
                },
                {
                    data: 'fn_invdetail'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {

                $('td:eq(3)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'R') {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Released</span>');
                } else if (data['fc_status'] == 'P') {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Paid Of</span>');
                } else {
                    $('td:eq(3)', row).html('<span class="badge badge-success">Installment</span>');
                }
                $('td:eq(8)', row).html(`
                    <a href="/apps/master-invoice/inv/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-primary btn-sm" onclick="click_modal_update_invoice('${data.fc_dono}')"><i class="fa fa-edit"></i> Update Inv</button>`
                );
            }
        });

        var tb = $('#tb_outgoing_invoice').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/apps/master-invoice/datatables',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7, 8]
                },
                {
                    className: 'text-nowrap',
                    targets: [1, 3, 6, 8]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_invno'
                },
                {
                    data: 'fc_dono'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fd_inv_releasedate',
                    render: formatTimestamp
                },
                {
                    data: 'fd_inv_agingdate',
                    render: formatTimestamp
                },
                {
                    data: 'fn_invdetail'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {

                $('td:eq(3)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'R') {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Released</span>');
                } else if (data['fc_status'] == 'P') {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Paid Of</span>');
                } else {
                    $('td:eq(3)', row).html('<span class="badge badge-success">Installment</span>');
                }
                $('td:eq(8)', row).html(`
                    <a href="/apps/master-invoice/inv/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-primary btn-sm" onclick="click_modal_update_invoice('${data.fc_dono}')"><i class="fa fa-edit"></i> Update Inv</button>`
                );
            }
        });

        $('.modal').css('overflow-y', 'auto');
    </script>

@endsection
