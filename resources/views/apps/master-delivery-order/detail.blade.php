@extends('partial.app')
@section('title', 'Detail Surat Jalan')
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
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        {{-- @dd($do_dtl, $do_mst) --}}
                                        <label>Approv : {{ $do_mst->fc_dono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>No. SO : {{ $do_mst->somst->fc_sono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tgl Expired :
                                            {{ \Carbon\Carbon::parse($do_mst->somst->fd_soexpired)->isoFormat('D MMMM Y') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tgl Delivery :
                                            {{ \Carbon\Carbon::parse($do_mst->fd_dodate)->isoFormat('D MMMM Y') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Tipe SO</label>
                                        <input type="text" class="form-control" value="{{ $do_mst->somst->fc_sotype }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Sales</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->sales->fc_salesname1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Customer Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode"
                                                name="fc_membercode" value="{{ $do_mst->somst->customer->fc_membercode }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Status PKP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->member_tax_code->fv_description }} ({{ $do_mst->somst->member_tax_code->fc_action }}%)"
                                            readonly>
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
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body" style="height: 303px">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->member_typebranch->fv_description }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fc_membertypebusiness }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fc_membername1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fc_memberaddress1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Masa Piutang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fn_memberAgingAP }} Hari" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->member_legal_status->fv_description }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat Muat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $do_mst->somst->customer->fc_memberaddress_loading1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Piutang</label>
                                        <input type="text" class="form-control"
                                            value="Rp. {{ number_format($do_mst->somst->customer->fm_memberAP, 0, ',', '.') }}"
                                            readonly>
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
                        <h4>Barang Dikirim</h4>
                    </div>
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
                                            <th scope="col" class="text-center">Exp. Date</th>
                                            <th scope="col" class="text-center">Batch</th>
                                            <th scope="col" class="text-center">Approval</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($do_mst->fc_dostatus == 'RJ')
                <div class="col-12 col-md-12 col-lg-12 place_detail">
                    <div class="card">
                        <div class="card-header">
                            <h4>Catatan Tidak Disetujui</h4>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" rows="3" readonly>{{ $do_mst->fv_description }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (auth()->user()->fc_groupuser == 'IN_MNGWRH' && auth()->user()->fl_level == 3)
            @if ($do_mst->fc_dostatus == 'NA')
                <div class="button text-right mb-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger mr-1" onclick="click_modal_catatan()">Reject</button>
                    <form id="form_submit_edit" action="/apps/master-delivery-order/accept_approval" method="POST">
                        @csrf
                        @method('put')
                        <input type="text" name="fc_dostatus" value="AC" hidden>
                        <input type="text" name="fc_dono" value="{{ $do_mst->fc_dono }}" hidden>
                        <button type="submit" class="btn btn-success ml-1">Accept</button>
                    </form>
                </div>
            @else
                <div class="button text-right mb-4">
                    <a href="/apps/master-delivery-order"><button type="button" class="btn btn-info">Back</button></a>
                </div>
            @endif
        @else
            @if ($do_mst->fc_dostatus == 'RJ')
                <div class="button text-right mb-4">
                    <form id="form_submit_edit" action="/apps/master-delivery-order/edit" method="POST">
                        @csrf
                        @method('put')
                        <input type="text" name="fc_dostatus" value="I" hidden>
                        <input type="text" name="fc_dono" value="{{ $do_mst->fc_dono }}" hidden>
                        <button type="submit" class="btn btn-success">Edit DO</button>
                    </form>
                </div>
            @else
                <div class="button text-right mb-4">
                    <a href="/apps/master-delivery-order"><button type="button" class="btn btn-info">Back</button></a>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_catatan" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Catatan Tidak Menyetujui</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_submit" action="/apps/master-delivery-order/reject_approval" method="POST">
                        @csrf
                        @method('put')
                        <input type="text" name="fc_dostatus" value="RJ" hidden>
                        <input type="text" name="fc_dono" value="{{ $do_mst->fc_dono }}" hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" id="fv_description" name="fv_description">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success" onclick="">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="modal_invstore" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Ketersediaan Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_ttd" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_invstore" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Brand</th>
                                        <th scope="col" class="text-center">Sub Group</th>
                                        <th scope="col" class="text-center">Tipe Stock</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var dono = "{{ $do_mst->fc_dono }}";
        var encode_dono = window.btoa(dono);

        // Untuk menampilkan invstore yang perlu approval
        function click_modal_invstore(fc_stockcode, fc_warehousecode, fc_barcode) {
            $('#modal_invstore').modal('show');
            table_invstore(fc_stockcode, fc_warehousecode, fc_barcode);
        }

        function click_modal_catatan() {
            $('#modal_catatan').modal('show');
        }

        function table_invstore(fc_stockcode, fc_warehousecode, fc_barcode) {
            var tb_invstore = $('#tb_invstore').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                orderable: false,
                order: [
                    [7, 'asc']
                ],
                ajax: {
                    url: "/apps/master-delivery-order/datatables-do-invstore/" + fc_stockcode + "/" +
                        fc_warehousecode + "/" + fc_barcode,
                    type: 'GET',
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 2, 4, 5, 6, 7, 8, 9, 10]
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
                        data: 'stock.fc_brand'
                    },
                    {
                        data: 'stock.fc_subgroup'
                    },
                    {
                        data: 'stock.fc_typestock2'
                    },
                    {
                        data: 'stock.fc_namepack'
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
                    {
                        data: null
                    }
                ],
                rowCallback: function(row, data) {
                    if (data.DT_RowIndex == 1) {
                        $('td:eq(10)', row).html(`
                        <span class="badge badge-success">FEFO</span>
                    `);
                    } else if (data.fc_barcode === fc_barcode) {
                        $('td:eq(10)', row).html(`
                    <span class="badge badge-warning">Dipilih</span>
                    `);
                    } else {
                        $('td:eq(10)', row).html(`-`);
                    }
                }
            })
        }

        var tb = $('#tb').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-delivery-order/datatables-do-detail/" + encode_dono,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'invstore.stock.fc_stockcode'
                },
                {
                    data: 'invstore.stock.fc_namelong'
                },
                {
                    data: 'invstore.stock.fc_namepack'
                },
                {
                    data: 'fn_qty_do'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fc_approval',
                    render: function(data, type, row) {
                        return data === 'T' ? 'Ya' : 'Tidak';
                    }
                },
                {
                    data: null
                },
            ],

            rowCallback: function(row, data) {
                $('td:eq(7)', row).html(`<i class="${data.fc_approval}"></i>`);
                if (data['fc_approval'] == 'F') {
                    $('td:eq(7)', row).html('<span class="badge badge-success">NO</span>');
                    $('td:eq(8)', row).html(
                        `<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`);
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-warning">YES</span>');
                    $('td:eq(8)', row).html(`
                    <button class="btn btn-primary btn-sm" onclick="click_modal_invstore('${data.invstore.fc_stockcode}','${data.invstore.fc_warehousecode}','${data.fc_barcode}')"><i class="fa fa-eye"></i> Detail Approval</button>
                `);
                }

            }
        });
    </script>
@endsection
