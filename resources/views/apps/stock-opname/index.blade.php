@extends('partial.app')
@section('title', 'Stock Opname')
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
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/stock-opname/store-update" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Tipe Opname</label>
                                        <input type="text" class="form-control" name="fc_stockopname_type" id="fc_stockopname_type" value="DAILY" readonly>
                                        <!-- <select class="form-control select2 required-field" name="fc_stockopname_type" id="fc_stockopname_type">
                                            <option value="" selected disabled>- Pilih -</option>
                                            <option value="DAILY">SATUAN</option>
                                            <option value="BRANCH">CABANG</option>
                                            <option value="ALLDEXA">SEMUA</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Tanggal Mulai</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="fd_stockopname_start" class="form-control datepicker" name="fd_stockopname_start" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Gudang</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_warehousecode" name="fc_warehousecode" readonly>
                                            <div class="input-group-append">
                                                <button id="btn" class="btn btn-primary" onclick="click_modal_gudang()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Buat Stock Opname</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Opname</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Jumlah Stock</label>
                                    <input type="text" class="form-control" id="jumlah_stock" name="jumlah_stock" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-8">
                                <div class="form-group">
                                    <label>Nama Gudang</label>
                                    <input type="text" class="form-control" id="fc_rackname" name="fc_rackname" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Gudang</label>
                                    <input type="text" class="form-control" id="fc_warehouseaddress" name="fc_warehouseaddress" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Jenis Gudang</label>
                                    <input type="text" class="form-control" id="fc_warehousepos" name="fc_warehousepos" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telah Berlangsung</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="number" id="" class="form-control" name="" value="0" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Hari
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group d-flex-row">
                                    <label>Stock Teropname</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success" style="font-size:large" value=" " id="" name="">0/0 Stock</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_gudang" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Kode Gudang</th>
                                <th scope="col" class="text-center">Nama Gudang</th>
                                <th scope="col" class="text-center">Alamat</th>
                                <th scope="col" class="text-center" style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script>
    $("#fc_stockopname_type").change(function() {
        if ($('#fc_stockopname_type').val() === 'ALLDEXA') {
            $('input[id="fc_warehousecode"]').val("ALLDEXA");
            $('input[id="fc_rackname"]').val("Seluruh Dexa");
            $('input[id="fc_warehouseaddress"]').val("Seluruh Dexa");
            $('input[id="fc_warehousepos"]').val("Seluruh Dexa");
            $('#btn').attr('disabled', true);
        } else {
            $('input[id="fc_warehousecode"]').val("");
            $('input[id="fc_rackname"]').val("");
            $('input[id="fc_warehouseaddress"]').val("");
            $('input[id="fc_warehousepos"]').val("");
            $('#btn').attr('disabled', false);
        }
    });

    function click_modal_gudang() {
        $('#modal_gudang').modal('show');
        table_gudang();
    }

    function table_gudang() {
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'asc']
            ],
            pageLength: 5,
            ajax: {
                url: '/data-master/master-warehouse/datatables',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 4]
                },
                {
                    className: 'text-nowrap',
                    targets: [4]
                },
                {
                    visible: false,
                    searchable: true,
                    targets: [1]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_warehousecode'
                },
                {
                    data: 'fc_rackname'
                },
                {
                    data: 'fc_warehouseaddress'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                var fc_warehousecode = window.btoa(data.fc_warehousecode);
                $('td:eq(3)', row).html(
                    `<button class="btn btn-warning btn-sm" onclick="detail_gudang('${data.fc_warehousecode}')"><i class="fa fa-check"></i> Pilih</button></a>`
                );

            }
        });
    }

    function detail_gudang(fc_warehousecode) {
        // encode
        var fc_warehousecode = window.btoa(fc_warehousecode);
        console.log(fc_warehousecode)
        $.ajax({
            url: "/apps/stock-opname/detail-gudang/" + fc_warehousecode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $("#modal_gudang").modal('hide');
                var data = response.data;
                $('#fc_warehousecode').val(data.fc_warehousecode);
                $('#fc_rackname').val(data.fc_rackname);
                $('#fc_warehouseaddress').val(data.fc_warehouseaddress);
                $('#fc_warehousepos').val(data.fc_warehousepos);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }
</script>
@endsection