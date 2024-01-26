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
                                    <label>No. SO : {{ $data->fc_sono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Order : {{ date('d-m-Y', strtotime($data->fd_sodateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Exp. : {{ date('d-m-Y', strtotime($data->fd_soexpired)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <input type="text" class="form-control" value="{{ $data->sales->fc_salesname1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Tipe Order</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_sotype }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Transportasi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_sotransport" name="fc_sotransport" value="{{ $data->fc_sotransport }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Jumlah Item</label>
                                    <input type="text" class="form-control" value="{{ $data->fn_sodetail }}" readonly>
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
                    <h4>Customer</h4>
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
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membernpwp_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_memberaddress_loading1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $data->customer->fm_memberAP,0,',','.') }}" readonly>
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
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">DO</th>
                                        <th scope="col" class="text-center">Sisa</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <!-- <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Disc.(Rp)</th>
                                            <th scope="col" class="text-center">Total</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <a href="/apps/delivery-order"><button type="button" class="btn btn-info mr-2">Back</button></a>
        <button type="button" onclick="pilih_gudang()" class="btn btn-warning mr-2">Pilih Gudang</button>
        <!-- <button type="button" onclick="insert_do()" class="btn btn-primary mr-2">Buat Surat Jalan</button> -->
    </div>
</div>
@endsection

@section('modal')
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
    function pilih_gudang() {
        $('#modal_gudang').modal('show');
        table_gudang();
    }

    let encode_fc_sono = "{{ base64_encode($data->fc_sono) }}";

    function insert_do(fc_warehousecode) {
        // console.log(fc_warehousecode);
        // show modal loading
        $('#modal_loading').modal('show');
        // Dapatkan data input dari elemen form
        // var fc_warehousecode = "{{ $data->fc_warehousecode }}";
        var fc_sono = "{{ $data->fc_sono }}";
        var fc_divisioncode = "{{ $data->fc_divisioncode }}";
        var fc_branch = "{{ $data->fc_branch }}";
        var fc_sostatus = "{{ $data->fc_sostatus }}";
        // var fc_userid = "{{ $data->fc_userid }}";
        var fc_dono = "{{ auth()->user()->fc_userid }}";

        var dataToSend = {
            'fc_divisioncode': fc_divisioncode,
            'fc_branch': fc_branch,
            'fc_sono': fc_sono,
            'fc_sostatus' : fc_sostatus,
            'fc_warehousecode': fc_warehousecode,
            // 'fc_userid': fc_userid,
            'fc_dono': fc_dono
        }

        // Kirim data menggunakan Ajax
        $.ajax({
            url: "/apps/delivery-order/insert_do",
            type: 'POST',
            data: dataToSend,
            success: function(response) {
                // hide modal loading
                $('#modal_loading').modal('hide');
                // Alihkan halaman hanya jika data berhasil disimpan
                window.location.href = "{{ route('create_do') }}";
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // hide modal loading
                $('#modal_loading').modal('hide');
                swal("Gagal Buat DO (" + jqXHR
                    .responseText + ")", {
                        icon: 'error',
                    });
            }
        });
    }

    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/delivery-order/datatables-so-detail/" + encode_fc_sono,
            type: 'GET',
        },
        columnDefs: [{
            targets: [7],
            defaultContent: "-",
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                data: 'stock.fc_nameshort'
            },
            {
                data: 'namepack.fv_description'
            },
            {
                data: 'fn_so_qty'
            },
            {
                data: 'fn_so_bonusqty'
            },
            {
                data: 'fn_do_qty'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return row.fn_so_qty - row.fn_do_qty;
                }
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            // {
            //     data: 'fm_so_oriprice',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
            // {
            //     data: 'fm_so_disc'
            // },
            // {
            //     data: 'total_harga',
            //     render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            // },
        ],
    });

    function table_gudang() {
        var tb = $('#table_gudang').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/delivery-order/datatables-warehouse",
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
                $('td:eq(5)', row).html(`
                <button class="btn btn-warning btn-sm mr-1" onclick="insert_do('${data.fc_warehousecode}')"><i class="fa fa-check"></i> Pilih</button>
            `);
            }
        });
    }
</script>
@endsection