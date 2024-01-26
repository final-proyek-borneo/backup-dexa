@extends('partial.app')
@section('title', 'Persediaan Barang')
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
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
                    <h4>Data Persediaan Barang</h4>
                    <div class="card-header-action">
                    <button type="button" class="btn btn-info mr-2" onclick="click_filter_export()" id="filterButton"><i class="fas fa-file-export"></i> Export Kartu Stock</button>
                        {{-- <form id="exportForm" action="/apps/persediaan-barang/export-kartu-stock" method="POST" target="_blank">
                                @csrf
                                <div class="button text-right mr-2">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-file-export"></i> Export Kartu Stock</button>
                                </div>
                            </form> --}}
                        <a href="/apps/upcoming-stock" class="btn btn-success">Upcoming Stock</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active show" id="dexa-tab" data-toggle="tab" href="#dexa" role="tab" aria-controls="dexa" aria-selected="true">Gudang Internal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gudanglain-tab" data-toggle="tab" href="#gudanglain" role="tab" aria-controls="gudanglain" aria-selected="false">Gudang Eksternal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="false">Seluruh Persediaan</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="dexa" role="tabpanel" aria-labelledby="dexa-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_dexa" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Gudang</th>
                                            <th scope="col" class="text-center">Alamat</th>
                                            <th scope="col" class="text-center">Jumlah Item</th>
                                            <th scope="col" class="text-center">Deskripsi</th>
                                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                        </tr>
                                        <!-- <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Kode Barang</th>
                                                <th scope="col" class="text-center">Nama Barang</th>
                                                <th scope="col" class="text-center">Sebutan</th>
                                                <th scope="col" class="text-center">Brand</th>
                                                <th scope="col" class="text-center">Sub Group</th>
                                                <th scope="col" class="text-center">Tipe Barang</th>
                                                <th scope="col" class="text-center">Qty</th>
                                                <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                            </tr> -->
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gudanglain" role="tabpanel" aria-labelledby="gudanglain-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_gudanglain" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Gudang</th>
                                            <th scope="col" class="text-center">Alamat</th>
                                            <th scope="col" class="text-center">Jumlah Item</th>
                                            <th scope="col" class="text-center">Deskripsi</th>
                                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_semua" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode Barang</th>
                                            <th scope="col" class="text-center">Nama Barang</th>
                                            <th scope="col" class="text-center">Sebutan</th>
                                            <th scope="col" class="text-center">Brand</th>
                                            <th scope="col" class="text-center">Sub Group</th>
                                            <th scope="col" class="text-center">Tipe Barang</th>
                                            <th scope="col" class="text-center">Qty</th>
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
    </div>
</div>
@endsection


@section('modal')
<div class="modal fade" role="dialog" id="modal_inventory_dexa" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title" id="product_name1"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory_dexa" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Gudang</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
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

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <form id="filterForm" action="/apps/persediaan-barang/export-kartu-stock" method="POST" target="_blank">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Kartu Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="startDate">Start Date:</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" value="">
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date:</label>
                        {{-- Teks petunjuk --}}
                        <p>
                            <small class="text-muted
                            ">*End Date akan otomatis diisi dengan tanggal hari ini jika kolom ini dikosongkan</small>
                        </p>
                        <input type="date" class="form-control" id="endDate" name="end_date" value="" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="warehouse">Warehouse:</label>
                        <select class="form-control" id="warehousefilter" name="warehousefilter">
                            <!-- Opsi-opsi warehouse -->
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" role="dialog" id="modal_inventory_gudanglain" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title" id="product_name2"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory_gudanglain" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
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

<div class="modal fade" role="dialog" id="modal_mutasi" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title" id="nama_gudang"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_mutasi" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Mutasi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Lokasi Awal</th>
                                    <th scope="col" class="text-center">Lokasi Tujuan</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Actions</th>
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

<div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Penanda Tangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_pdf" action="/apps/daftar-mutasi-barang/pdf" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="fc_mutationno" id="fc_mutationno_input_ttd" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group form_group_ttd">
                                <label class="d-block">Nama</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user" id="name_user" checked="">
                                    <label class="form-check-label" for="name_user">
                                        {{ auth()->user()->fc_username }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user_lainnya" id="name_user_lainnya">
                                    <label class="form-check-label" for="name_user_lainnya">
                                        Lainnya
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
     $(document).ready(function () {
        // Mendapatkan tanggal hari ini
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();
        
        today = yyyy + '-' + mm + '-' + dd;

        // Menangani perubahan pada input tanggal
        $('#endDate').on('change', function () {
            // Jika input tanggal dikosongkan, isi dengan tanggal hari ini
            if (!$(this).val()) {
                $(this).val(today);
            }
        });

        // Setel nilai input tanggal dengan tanggal hari ini jika awalnya kosong
        if (!$('#endDate').val()) {
            $('#endDate').val(today);
        }
    });
    
    function click_filter_export() {
        var warehouseSelect = $('#warehousefilter');
        // warehouseSelect.empty().append(new Option('Loading...', '', true, true)).prop('disabled', true);
        warehouseSelect.empty()
        // loading
        $("#modal_loading").modal('show');

        $.ajax({
            url: '/apps/persediaan-barang/get-warehouse',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $("#filterModal").modal("show");
                }, 500);

                warehouseSelect.empty().prop('disabled', false);
                warehouseSelect.append(new Option('All Warehouses', ''));

                $.each(data.warehouse, function(index, warehouse) {
                    warehouseSelect.append(new Option(warehouse.fc_rackname, warehouse
                        .fc_warehousecode));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Kesalahan saat mengambil data');
                warehouseSelect.empty().prop('disabled', false);
            }
        });
        setTimeout(function() {
            $("#modal_loading").modal('hide');
        }, 500);

    }

    function click_modal_inventory_dexa(fc_stockcode, fc_namelong) {
        $('#modal_inventory_dexa').modal('show');
        table_inventory_dexa(fc_stockcode, fc_namelong);
    }

    function click_modal_riwayat(fc_warehousecode, fc_rackname) {
        $('#modal_mutasi').modal('show');
        table_mutasi(fc_warehousecode, fc_rackname);
    }
    // function click_modal_inventory_gudanglain(fc_stockcode, fc_namelong) {
    //     $('#modal_inventory_gudanglain').modal('show');
    //     table_inventory_gudanglain(fc_stockcode, fc_namelong);
    // }

    var tb_dexa = $('#tb_dexa').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/persediaan-barang/datatables-dexa",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 2, 3, 4]
        }, {
            className: 'text-nowrap',
            targets: [1, 5]
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
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_warehousecode = window.btoa(data.fc_warehousecode);
            var formHtml = `
                <a href="/apps/persediaan-barang/detail/${fc_warehousecode}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                <form id="exportForm" action="/apps/persediaan-barang/export-excel" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="fc_warehousecode" value="${fc_warehousecode}" >
                    <button type="submit" class="btn btn-warning btn-sm" style="display: inline;"><i class="fa-solid fa-file-excel"></i> Rekap</button>
                </form>
                <button class="btn btn-info btn-sm ml-1" onclick="click_modal_riwayat('${data.fc_warehousecode}', '${data.fc_rackname}')"><i class="fa fa-history"> </i> Riwayat</button>
            `;
            $('td:eq(5)', row).html(formHtml);
                // <a href="/apps/persediaan-barang/pdf/${fc_warehousecode}" target="_blank"><button class="btn btn-warning btn-sm"><i class="fa fa-file"></i> PDF</button></a>
        },
    });

    var tb_gudanglain = $('#tb_gudanglain').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/persediaan-barang/datatables-gudanglain",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 2, 3, 4]
        }, {
            className: 'text-nowrap',
            targets: [1, 5]
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
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_warehousecode = window.btoa(data.fc_warehousecode);
            $('td:eq(5)', row).html(`
                <a href="/apps/persediaan-barang/detail/${fc_warehousecode}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                <form id="exportForm" action="/apps/persediaan-barang/export-excel" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="fc_warehousecode" value="${fc_warehousecode}" >
                    <button type="submit" class="btn btn-warning btn-sm" style="display: inline;"><i class="fa-solid fa-file-excel"></i> Rekap</button>
                </form>
                <button class="btn btn-info btn-sm ml-1" onclick="click_modal_riwayat('${data.fc_warehousecode}', '${data.fc_rackname}')"><i class="fa fa-history"> </i> Riwayat</button>
                `);
        },

    });

    var tb_semua = $('#tb_semua').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/persediaan-barang/datatables-semua",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'fc_namelong'
            },
            {
                data: 'fc_nameshort'
            },
            {
                data: 'fc_brand'
            },
            {
                data: 'fc_subgroup'
            },
            {
                data: 'fc_typestock2'
            },
            {
                data: 'sum_quantity',
                // defaultContent: '',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            $('td:eq(8)', row).html(`
                <button class="btn btn-warning btn-sm" onclick="click_modal_inventory_dexa('${data.fc_stockcode}', '${data.fc_namelong}')"><i class="fa fa-eye"> </i> Detail</button>
                `);
        },
    });

    function table_mutasi(fc_warehousecode, fc_rackname) {
        var tb_mutasi = $('#tb_mutasi').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/persediaan-barang/datatables-mutasi/" + fc_warehousecode,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 5, 6]
            }, {
                className: 'text-nowrap',
                targets: [6]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_mutationno'
                },
                {
                    data: 'fd_date_byuser',
                    render: formatTimestamp
                },
                {
                    data: 'fc_startpoint_code'
                },
                {
                    data: 'fc_destination_code'
                },
                {
                    data: 'fn_detailitem'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                var fc_mutationno = window.btoa(data.fc_mutationno);

                var detailButton = $('<button>', {
                    class: 'btn btn-primary btn-sm mr-1',
                    html: '<i class="fa fa-eye"></i> Detail',
                    click: function(event) {
                        event.preventDefault();
                        event.stopPropagation();
                        window.location.href = "/apps/daftar-mutasi-barang/detail/" + fc_mutationno;
                    }
                });

                var pdfButton = $('<button>', {
                    class: 'btn btn-warning btn-sm',
                    html: '<i class="fa fa-file"></i> PDF',
                    click: function(event) {
                        event.preventDefault();
                        event.stopPropagation();
                        click_modal_nama(data.fc_mutationno);
                    }
                });

                $('td:eq(6)', row).html('').append(detailButton).append(pdfButton);
        },



        });
        $('#nama_gudang').text(fc_rackname);
    }

    $(document).ready(function() {
        var isNamePjShown = false;

        $('#name_user_lainnya').click(function() {
            // Uncheck #name_user
            $('#name_user').prop('checked', false);

            // Show #form_pj
            if (!isNamePjShown) {
                $('.form_group_ttd').append(
                    '<div class="form-group" id="form_pj"><label>Nama PJ</label><input type="text" class="form-control" name="name_pj" id="name_pj"></div>'
                );
                isNamePjShown = true;
            }
        });

        $('#name_user').click(function() {
            // Uncheck #name_user_lainnya
            $('#name_user_lainnya').prop('checked', false);

            // Hide #form_pj
            if (isNamePjShown) {
                $('#form_pj').remove();
                isNamePjShown = false;
            }
        });

        $('#name_pj').focus(function() {
            $('.form-group:last').toggle();
        });
    });

    function table_inventory_dexa(fc_stockcode, fc_namelong) {

        var tb_inventory_dexa = $('#tb_inventory_dexa').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/persediaan-barang/datatables-inventory-dexa/" + fc_stockcode,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'warehouse.fc_rackname'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],

        });

        $('#product_name1').text(fc_namelong);
    }

    function table_inventory_gudanglain(fc_stockcode, fc_namelong) {
        var tb_inventory_gudanglain = $('#tb_inventory_gudanglain').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/persediaan-barang/datatables-inventory-gudanglain/" + +fc_stockcode,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            }, ],
            columns: [{
                    data: 'fc_stockcode'
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });

        $('#product_name2').text(fc_namelong);
    }

    // untuk memunculkan nama penanggung jawab
    function click_modal_nama(fc_mutationno) {
        $('#fc_mutationno_input_ttd').val(fc_mutationno);
        $('#modal_nama').modal('show');
    };

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection