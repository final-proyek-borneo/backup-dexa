@extends('partial.app')
@section('title', 'Mutasi Barang')
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
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/mutasi-barang/store-mutasi" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Tanggal</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="fd_date_byuser" class="form-control datepicker" name="fd_date_byuser" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Jenis Mutasi</label>
                                        @if (empty($data->fc_type_mutation))
                                        <select class="form-control select2" name="fc_type_mutation" id="fc_type_mutation" required>
                                            <option value="" selected disabled>- Pilih -</option>
                                            <option value="INTERNAL">INTERNAL</option>
                                            <option value="EKSTERNAL">EKSTERNAL</option>
                                        </select>
                                        @else
                                        <select class="form-control select2" name="fc_type_mutation" id="fc_type_mutation" required>
                                            <option value="{{ $data->fc_type_mutation }}" selected disabled>
                                                -- {{ $data->fc_type_mutation }} --
                                            </option>
                                            <option value="INTERNAL">INTERNAL</option>
                                            <option value="EKSTERNAL">EKSTERNAL</option>
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group required">
                                        <label>Lokasi Awal</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_startpoint" name="fc_startpoint" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_lokasi_awal()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="fc_membercode_tujuan" id="fc_membercode_tujuan" hidden>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group required">
                                        <label>Lokasi Tujuan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_destination" name="fc_destination" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_lokasi_tujuan()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4" id="internal">
                                    <div class="form-group required">
                                        <label>SO Memo Internal</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_sono_internal" name="fc_sono" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_so_internal()" type="button" required><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4" id="cprr" hidden>
                                    <div class="form-group required">
                                        <label>SO CPRR</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_sono_cprr" name="fc_sono_cprr" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_so_cprr()" type="button" required><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" id="buat" class="btn btn-success">Buat Mutasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Mutasi</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Awal</label>
                                    <input type="text" class="form-control" name="fc_rackname_berangkat" id="fc_rackname_berangkat" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <input type="text" class="form-control" name="fc_rackname_tujuan" id="fc_rackname_tujuan" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Awal</label>
                                    <textarea type="text" name="fc_warehouseaddress_berangkat" class="form-control" id="fc_warehouseaddress_berangkat" data-height="76" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Tujuan</label>
                                    <textarea type="text" name="fc_warehouseaddress_tujuan" class="form-control" id="fc_warehouseaddress_tujuan" data-height="76" readonly></textarea>
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
<div class="modal fade" role="dialog" id="modal_lokasi_awal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Lokasi Awal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_warehouse_awal" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Gudang</th>
                                    <th scope="col" class="text-center">Posisi Gudang</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Nama Gudang</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Kapasitas</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_lokasi_tujuan" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Lokasi Tujuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_warehouse_tujuan" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Gudang</th>
                                    <th scope="col" class="text-center">Posisi Gudang</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Nama Gudang</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Kapasitas</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_so_internal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Sales Order Internal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_so_internal" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. SO</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Expired</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Peruntukan</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_so_cprr" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Sales Order CPRR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_so_cprr" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. SO</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Expired</th>
                                    <th scope="col" class="text-center">Tipe</th>
                                    <th scope="col" class="text-center">Customer</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    var fc_membercode_tujuan = "";
    // change value fc_type_mutation

    function click_modal_lokasi_awal() {

        if ($('#fc_type_mutation').val() === '' || $('#fc_type_mutation').val() === null) {
            swal(
                'Perhatian',
                'Pilih Jenis Mutasi Terlebih Dahulu',
                'warning'
            )
        } else {
            $('#modal_lokasi_awal').modal('show');
            table_warehouse_awal();
        }

    }

    function click_modal_lokasi_tujuan() {
        if ($('#fc_type_mutation').val() === '' || $('#fc_type_mutation').val() === null) {
            swal(
                'Perhatian',
                'Pilih Jenis Mutasi Terlebih Dahulu',
                'warning'
            )
        } else {
            $('#modal_lokasi_tujuan').modal('show');
            table_warehouse_tujuan();
        }

    }

    function click_modal_so_cprr() {
        var fc_destination = $('#fc_destination').val();
        var fc_membercode = $('#fc_membercode_tujuan').val();
        if (fc_destination === '') {
            swal(
                'Perhatian',
                'Pilih Lokasi Tujuan Terlebih Dahulu',
                'warning'
            )
        } else {
            $('#modal_so_cprr').modal('show');
            table_so_cprr(fc_membercode);
        }

    }

    function click_modal_so_internal() {
        if ($('#fc_type_mutation').val() === '' || $('#fc_type_mutation').val() === null) {
            swal(
                'Perhatian',
                'Pilih Jenis Mutasi Terlebih Dahulu',
                'warning'
            )
        } else {
            $('#modal_so_internal').modal('show');
            table_so_internal();
        }
    }

    $("#fc_type_mutation").change(function() {
        // #fc_destination clear value
        $('#fc_destination').val('');
        $('#fc_startpoint').val('');
        if ($('#fc_type_mutation').val() === 'INTERNAL') {
            $('input[id="fc_sono_internal"]').val("");
            $('#internal').attr('hidden', false);
            $('#cprr').attr('hidden', true);
            $('#fc_sono_internal').attr('name', 'fc_sono');
            $('#fc_sono_cprr').attr('name', 'fc_sono_cprr');
        } else {
            $('input[id="fc_sono_cprr"]').val("");
            $('#cprr').attr('hidden', false);
            $('#internal').attr('hidden', true);
            $('#fc_sono_cprr').attr('name', 'fc_sono');
            $('#fc_sono_internal').attr('name', 'fc_sono_internal');
        }
    });

    function get_sono_internal($fc_sono) {
        $('#fc_sono_internal').val($fc_sono);
        $('#modal_so_internal').modal('hide');
    }

    function get_sono_cprr($fc_sono) {
        $('#fc_sono_cprr').val($fc_sono);
        $('#modal_so_cprr').modal('hide');
    }

    function table_so_cprr(fc_membercode) {
        // console.log(fc_membercode_tujuan)
        var tb = $('#tb_so_cprr').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: '/apps/mutasi-barang/datatables/so_cprr/' + fc_membercode,
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 6, 7]
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
                    data: 'fn_sodetail'
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var fc_sono = window.btoa(data.fc_sono);

                if ((data['fc_sostatus'] == 'CL') || (data['fc_sostatus'] == 'C') || (data['fc_sostatus'] == 'CC') || (data['fc_sostatus'] == 'L')) {
                    $(row).hide();
                } else {
                    $(row).show();
                }

                $('td:eq(7)', row).html(`
                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_sono_cprr('${data.fc_sono}')"><i class="fa fa-check"></i> Pilih</button>`);
            }
        });
    }

    function table_so_internal() {
        // console.log(fc_membercode_tujuan)
        var tb = $('#tb_so_internal').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: '/apps/mutasi-barang/datatables/so_internal',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 6, 7]
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
                    data: 'fv_description'
                },
                {
                    data: 'fn_sodetail'
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                var fc_sono = window.btoa(data.fc_sono);

                if ((data['fc_sostatus'] == 'CL') || (data['fc_sostatus'] == 'C') || (data['fc_sostatus'] == 'CC') || (data['fc_sostatus'] == 'L')) {
                    $(row).hide();
                } else {
                    $(row).show();
                }

                $('td:eq(7)', row).html(`
                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_sono_internal('${data.fc_sono}')"><i class="fa fa-check"></i> Pilih</button>`);
            }
        });
    }

    function table_warehouse_awal() {
        // value fc_type_mutation
        var fc_type_mutation = $('#fc_type_mutation').val();
        // console.log(fc_type_mutation)
        var tb = $('#tb_warehouse_awal').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/apps/mutasi-barang/datatables-lokasi-awal/' + fc_type_mutation,
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0]
                },
                {
                    className: 'text-nowrap',
                    targets: [8]
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
                    data: 'fc_warehousepos'
                },
                {
                    data: 'fl_status'
                },
                {
                    data: 'fc_rackname'
                },
                {
                    data: 'fc_warehouseaddress'
                },
                {
                    data: 'fn_capacity'
                },
                {
                    data: 'fv_description'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {

                $('td:eq(3)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                if (data['fl_status'] == 'G') {
                    $('td:eq(3)', row).html('<span class="badge badge-success">Gudang</span>');
                } else {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Display</span>');
                }

                $('td:eq(8)', row).html(`
            <button type="button" class="btn btn-warning btn-sm mr-1" onclick="detail_warehouse_awal('${data.fc_warehousecode}')"><i class="fa fa-check"></i> Pilih</button>
         `);
            }
        });
    }

    function detail_warehouse_awal($fc_warehousecode) {
        $.ajax({
            url: "/master/data-warehouse-first/" + $fc_warehousecode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;
                $("#modal_lokasi_awal").modal('hide');
                Object.keys(data).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    elem_name.val(data[key]);
                });
                $('#fc_rackname_berangkat').val(data.fc_rackname);
                $('#fc_startpoint').val(data.fc_warehousecode);
                if (data.fc_warehouseaddress != null) {
                    $('#fc_warehouseaddress_berangkat').val(data.fc_warehouseaddress);
                } else {
                    $('#fc_warehouseaddress_berangkat').val('-');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function detail_warehouse_tujuan(fc_warehousecode, fc_membercode) {
        // console.log(fc_membercode)
        $.ajax({
            url: "/master/data-warehouse-first/" + fc_warehousecode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                var data = response.data;
                $("#modal_lokasi_tujuan").modal('hide');
                Object.keys(data).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    elem_name.val(data[key]);
                });
                $('#fc_rackname_tujuan').val(data.fc_rackname);
                $('#fc_destination').val(data.fc_warehousecode);
                fc_membercode_tujuan = fc_membercode;
                $('#fc_membercode_tujuan').val(fc_membercode_tujuan);
                if (data.fc_warehouseaddress != null) {
                    $('#fc_warehouseaddress_tujuan').val(data.fc_warehouseaddress);
                } else {
                    $('#fc_warehouseaddress_tujuan').val('-');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function table_warehouse_tujuan() {
        var fc_type_mutation = $('#fc_type_mutation').val();
        var tb = $('#tb_warehouse_tujuan').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/apps/mutasi-barang/datatables-lokasi-tujuan/' + fc_type_mutation,
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0]
                },
                {
                    className: 'text-nowrap',
                    targets: [8]
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
                    data: 'fc_warehousepos'
                },
                {
                    data: 'fl_status'
                },
                {
                    data: 'fc_rackname'
                },
                {
                    data: 'fc_warehouseaddress'
                },
                {
                    data: 'fn_capacity'
                },
                {
                    data: 'fv_description'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {

                $('td:eq(3)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                if (data['fl_status'] == 'G') {
                    $('td:eq(3)', row).html('<span class="badge badge-success">Gudang</span>');
                } else {
                    $('td:eq(3)', row).html('<span class="badge badge-primary">Display</span>');
                }

                $('td:eq(8)', row).html(`
            <button type="button" class="btn btn-warning btn-sm mr-1" onclick="detail_warehouse_tujuan('${data.fc_warehousecode}','${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
         `);
            }
        });
    }
</script>
@endsection