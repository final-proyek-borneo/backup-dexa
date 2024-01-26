@extends('partial.app')
@section('title', 'Konfirmasi Penerimaan')
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat Jalan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Surat Jalan</th>
                                    <th scope="col" class="text-center">No. SO</th>
                                    <th scope="col" class="text-center">Tgl SJ</th>
                                    <th scope="col" class="text-center">Customer</th>
                                    <th scope="col" class="text-center">Item</th>
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
<!-- <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pencarian Surat Jalan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Masukkan Nomor Surat Jalan</label>
                            <input type="text" id="fc_dono" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer bg-smokewhite">
                        <button class="btn btn-primary float-right" id="button_cari" onclick="click_cari_delivery_order()"><i class="fa fa-searach"></i> Cari Delivery Order</button>
                    </div>
                </div>
            </div> -->
</div>
</div>
@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/master-delivery-order/datatables/ALL',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 6]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_dono'
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_dodate',
                render: formatTimestamp
            },
            {
                data: 'somst.customer.fc_membername1'
            },
            {
                data: 'fn_dodetail'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_dono = window.btoa(data.fc_dono);
            if (data['fc_dostatus'] == 'D') {
                $(row).show();
            } else {
                $(row).hide();
            }
            $('td:eq(6)', row).html(
                `
                <a href="/apps/received-order/detail/${fc_dono}"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Pilih</button></a>`
            );

        }
    });
    // function click_cari_delivery_order(){
    //     $('#button_cari').html('<i class="fa fa-refresh fa-spin"></i> Mencari..');
    //     $('#button_cari').prop('disabled',true);
    //     var fc_dono = window.btoa($('#fc_dono').val());
    //     $.ajax({
    //     url: '/apps/received-order/cari-do/' + fc_dono,
    //     type: "GET",
    //     dataType: 'JSON',
    //     success: function( response, textStatus, jQxhr ){
    //         $('#button_cari').html('<i class="fa fa-searach"></i> Cari Delivery Order');
    //         $('#button_cari').prop('disabled',false);

    //         if(response.status == 201){
    //             swal(response.message, { icon: 'success', });
    //             $("#modal").modal('hide');
    //             location.href = response.link;
    //         }
    //         else if(response.status == 300){
    //             swal(response.message, { icon: 'error', });
    //         }
    //     },
    //     error: function( jqXhr, textStatus, errorThrown ){
    //         console.log( errorThrown );
    //         console.warn(jqXhr.responseText);
    //     },
    //     });
    // }
</script>
@endsection