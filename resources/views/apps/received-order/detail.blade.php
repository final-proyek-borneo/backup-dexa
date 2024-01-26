@extends('partial.app')
@section('title', 'Detail Order')
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
    </style>
@endsection
@section('content')

    <div class="section-body">
        <input type="text" hidden id="fc_dono" value="{{ $data->fc_dono }}">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Umum</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <label> <b>Order</b> : {{ \Carbon\Carbon::parse($data->fd_dodate)->format('d/m/Y') }}</label><br>
                                    <label> <b>Expired</b> : {{ \Carbon\Carbon::parse($data->somst->fd_soexpired)->format('d/m/Y') }}</label><br>
                                    <label> <b>Nomor SO</b> : {{ $data->fc_sono }}</label><br>
                                    <label> <b>Nomor Surat Jalan</b> : {{ $data->fc_dono }}</label><br>
                                    <hr>
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <div class="row">
                                            <div class="col-4 col-md-4 col-lg-4">
                                                <input type="text" class="form-control" value="{{ $data->somst->customer->fc_memberlegalstatus }}" disabled>
                                            </div>
                                            <div class="col-8 col-md-8 col-lg-8">
                                                <input type="text" class="form-control" value="{{ $data->somst->customer->fc_membername1 }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Alamat Pengiriman</label>
                                        <input type="text" class="form-control" value="{{ $data->fc_memberaddress_loading }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Item Order</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tb" width="100%">
                                        <thead style="white-space: nowrap">
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Barcode</th>
                                                <th scope="col" class="text-center">Nama Produk</th>
                                                <th scope="col" class="text-center">Batch</th>
                                                <th scope="col" class="text-center">Expired</th>
                                                <th scope="col" class="text-center">Jumlah</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pengiriman</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="text" class="form-control datepicker" name="fd_doarivaldate" id="fd_doarivaldate" value="{{ \Carbon\Carbon::parse($data->fd_doarivaldate)->format('d-m-Y') }}"  @if ($data->fc_dostatus == 'R') readonly @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Transporter</label>
                                        <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $data->fc_transporter }}" @if ($data->fc_dostatus == 'R') readonly @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <input type="text" class="form-control" name="fc_custreceiver" id="fc_custreceiver" value="{{ $data->fc_custreceiver }}" @if ($data->fc_dostatus == 'R') readonly @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button text-right mb-4">
            <button type="button" onclick="click_insert_do()" @if ($data->fc_dostatus == 'R') hidden @endif id="button_confirm" class="btn btn-primary mr-2">Confirm</button>
        </div>
    </div>
@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/received-order/datatables",
            data: {
                'fc_dono': $('#fc_dono').val(),
            },
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0,1,3,4,5]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_barcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_qty_do'
            },
        ],
    });

    function click_insert_do(){
        swal({
             title: 'Yakin?',
             text: 'Apakah anda yakin akan menerima data ini?',
             icon: 'warning',
             buttons: true,
             dangerMode: true,
       })
       .then((willDelete) => {
             if (willDelete) {
                $('#button_confirm').html('<i class="fa fa-refresh fa-spin"></i> Process..');
                $('#button_confirm').prop('disabled',true);
                $.ajax({
                    url: '/apps/received-order/action',
                    data: {
                        'fc_dono': $('#fc_dono').val(),
                        'fd_doarivaldate':$('#fd_doarivaldate').val(),
                        'fc_transporter':$('#fc_transporter').val(),
                        'fc_custreceiver':$('#fc_custreceiver').val(),
                    },
                    type: "POST",
                    dataType: 'JSON',
                    success: function( response, textStatus, jQxhr ){
                        $('#button_confirm').html('<i class="fa fa-searach"></i> Confirm');
                        $('#button_confirm').prop('disabled',false);

                        if(response.status == 201){
                            swal(response.message, { icon: 'success', });
                            location.href = response.link;
                        }
                        else if(response.status == 300){
                            swal(response.message, { icon: 'error', });
                        }
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                        console.warn(jqXhr.responseText);
                    },
                });
             }
        });
    }

</script>
@endsection

