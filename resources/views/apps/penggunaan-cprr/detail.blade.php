@extends('partial.app')
@section('title', 'Detail Penggunaan CPRR')
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
                <div class="card-header d-flex justify-content-between">
                    <h4>Data Penggunaan CPRR</h4>
                    <div id="journal-cprr">
                        <div class="btn btn-success">Buat Jurnal</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Katalog</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Tgl Penggunaan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Status Jurnal</th>
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
        <a href="/apps/penggunaan-cprr"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('modal')
@endsection

@section('js')
<script>
    let fc_warehousecode = "{{ ($gudang_mst->fc_warehousecode) }}";

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/penggunaan-cprr/datatables-detail/" + fc_warehousecode,
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'invstore.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fd_scanqrdate',
                render: formatTimestamp
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp,
            },
            {
                data: 'fc_scanqrstatus',
            }
        ],
        rowCallback: function (row, data) {
            if(data.fc_scanqrstatus == 'T') 
                $('td:eq(6)', row).html('<span class="badge badge-primary"><i class="fa-solid fa-square-check"></i> Sudah</span>')
    
            else 
                $('td:eq(6)', row).html('<span class="badge badge-danger"><i class="fa-solid fa-circle-xmark"></i> Belum</span>')
        }
    });

    $('#journal-cprr').on('click', function () {
        $('#modal_loading').modal('show');
        $.ajax({
            url: '/apps/penggunaan-cprr/detail/'+ fc_warehousecode + '/journal',
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                var fc_membercode = data[0].fc_membercode;

                $('#modal_loading').modal('hide');

                if (response.status == 200) {
                    if (data.length > 0) {
                        swal({
                            title: 'Yakin?',
                            text: 'Apakah anda yakin akan menjurnal ?',
                            icon: 'warning',
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((save) => {
                            if (save) {
                                $("#modal_loading").modal('show');
                                $.ajax({
                                    url: '/apps/penggunaan-cprr/detail/'+ fc_warehousecode + '/journal/' + fc_membercode,
                                    type: 'POST',
                                    success: function(response) {

                                        setTimeout(function() {
                                            $('#modal_loading').modal('hide');
                                        }, 500);

                                        if (response.status == 201) {
                                            
                                            swal(response.message, { icon: 'success'});
                                            $("#modal").modal('hide');
                                            tb.ajax.reload();
                                            
                                        } else {
                                            swal( response.message, { icon: 'error'} );
                                        }
                                        
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {

                                        setTimeout(function() {
                                            $('#modal_loading').modal('hide');
                                        }, 500);
                                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                                            icon: 'error',
                                        });

                                    }
                                });
                            }
                        });
                    } else {
                        swal("Maaf, tidak ada penggunaan CPRR yang bisa dijurnal", { icon: 'warning'});
                    }
                } else {

                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        })
    })
</script>
@endsection