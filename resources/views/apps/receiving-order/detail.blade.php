@extends('partial.app')
@section('title', 'Detail Purchase Order')
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
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>No. PO : {{ $data->fc_pono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Order : {{ date('d-m-Y', strtotime ($data->fd_podateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                <div class="form-group">
                                    <label>Expired : {{ date('d-m-Y', strtotime($data->fd_poexpired)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->fc_username }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>PO Type</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_potype }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierphone1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplier_npwpaddress1 }}" readonly>
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
                <div class="card-header">
                    <h4>Item Purchase Order</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="po_detail" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">BPB</th>
                                        <th scope="col" class="text-center">Sisa</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE RO --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>BPB</h4>
                    <div class="card-header-action">
                        <!-- <a href="/apps/receiving-order/create/{{ base64_encode($data->fc_pono) }}"></a> -->
                        <button type="button" onclick="pilih_gudang('{{ base64_encode($data->fc_pono) }}')" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambahkan BPB</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_ro" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No.</th>
                                        <th scope="col" class="text-center">No. BPB</th>
                                        <th scope="col" class="text-center">Tgl BPB</th>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Action</th>
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
        <a href="/apps/receiving-order"><button type="button" class="btn btn-info mr-2">Back</button></a>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Penanda Tangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_edit" action="/apps/master-receiving-order/pdf" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="fc_rono" id="fc_rono_input_ttd" hidden>
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
                    <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_gudang" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Daftar Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" width="100%" id="table_gudang">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Kode Gudang</th>
                                <th scope="col" class="text-center">Nama Gudang</th>
                                <th scope="col" class="text-center">Posisi Gudang</th>
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
    function pilih_gudang(fc_pono) {
        $('#modal_gudang').modal('show');
        table_gudang(fc_pono);
    }
    
    function table_gudang(fc_pono) {
        var tb = $('#table_gudang').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/receiving-order/datatables-warehouse",
                type: 'GET',
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
                    data: 'fc_warehousecode'
                },
                {
                    data: 'fc_rackname'
                },
                {
                    data: 'fc_warehousepos'
                },
                {
                    data: 'fc_warehouseaddress'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                let encode_fc_warehousecode = window.btoa(data.fc_warehousecode)
                $('td:eq(5)', row).html(`
                <a class="btn btn-warning btn-sm mr-1" href="/apps/receiving-order/create/${fc_pono}/${encode_fc_warehousecode}"><i class="fa fa-check"></i> Pilih</button>
            `);
            }
        });
    }
    // untuk form input nama penanggung jawab
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

    function click_modal_nama(fc_rono) {
        $('#fc_rono_input_ttd').val(fc_rono);
        $('#modal_nama').modal('show');
    };

    let encode_fc_pono = "{{ base64_encode($data->fc_pono) }}";
    var tb = $('#po_detail').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/receiving-order/datatables/po_detail/" + encode_fc_pono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7, 8, 9]
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
                data: 'stock.fc_namelong'
            },
            {
                data: 'namepack.fv_description'
            },
            {
                data: 'fn_po_qty'
            },
            {
                data: 'fn_ro_qty'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return row.fn_po_qty - row.fn_ro_qty;
                }
            },
            {
                data: 'fn_po_bonusqty'
            },
            {
                data: 'fv_description',
                defaultContent: '-',
            },
            {
                data: 'fc_status'
            },
        ],
        rowCallback: function(row, data) {

            $('td:eq(9)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'W') {
                $('td:eq(9)', row).html('<span class="badge badge-primary"><i class="fa fa-hourglass"></i> Menunggu</span>');
            } else if (data['fc_status'] == 'P') {
                $('td:eq(9)', row).html('<span class="badge badge-warning"><i class="fa fa-spinner"></i> Pending</span>');
            } else {
                $('td:eq(9)', row).html('<span class="badge badge-success"><i class="fa fa-check"></i> Selesai</span>');
            }
        }
    });

    var tb_ro = $('#tb_ro').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/receiving-order/datatables/ro/" + encode_fc_pono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, ]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_rono',
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: 'fn_rodetail',
            },
            {
                data: 'fc_rostatus',
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            let fc_rono = window.btoa(data.fc_rono)
            $('td:eq(4)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_rostatus'] == 'P') {
                $('td:eq(4)', row).html('<span class="badge badge-primary">Paid Of</span>');
            } else {
                $('td:eq(4)', row).html('<span class="badge badge-success">Received</span>');
            }

            $('td:eq(5)', row).html(`
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_rono}')"><i class="fa fa-eye"></i> Detail</button>
            `);
            // <a href="/apps/receiving-order/pdf_ro/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
        }
    });
</script>
@endsection