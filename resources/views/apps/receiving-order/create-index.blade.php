@extends('partial.app')
@section('title', 'BPB Performa')
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
            display:inline;
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
                    <form id="form_submit" action="/apps/receiving-order/create/store-update" method="POST" autocomplete="off">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime ($data->fd_podateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>No. PO : {{ $data->fc_pono }}
                                        </label>
                                        <input type="text" name="fc_pono" value="{{ $data->fc_pono }}" hidden>
                                        <input type="text" name="fc_warehousecode" value="{{ $fc_warehousecode }}" hidden>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                    <div class="form-group">
                                        <label>Tipe : {{ $data->fc_potype }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input name="fc_userid" id="fc_userid" type="text" class="form-control" value="{{ auth()->user()->fc_username }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>No. Surat Jalan</label>
                                        <input name="fc_sjno" type="text" id="fc_sjno" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Penerima</label>
                                        <input type="text" name="fc_receiver" id="fc_receiver" class="form-control" value="{{ $goods_reception->fc_recipient }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Tanggal BPB</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="fd_roarivaldate" class="form-control datepicker"
                                                name="fd_roarivaldate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Buat BPB</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Supplier</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body"  style="height: 303px">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->fc_supplierNPWP }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->supplier_typebranch->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->supplier_type_business->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="{{  $data    ->supplier->fc_suppliername1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->fc_supplierphone1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->supplier_legal_status->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data ->supplier->fc_supplier_npwpaddress1 }}" readonly>
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

@section('js')
    <script>
        var tb = $('#po_detail').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables-po-detail",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7]
            }, ],
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'fc_stockcode' },
                { data: 'fc_nameshort' },
                { data: 'namepack.fv_description' },
                { data: 'fn_po_qty' },
                { data: 'fn_ro_qty' },
                { data: 'fn_po_bonusqty' },
                { data: 'fc_postatus' },
            ],
        });

        var tb_sopay = $('#tb_ro').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables-ro",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5,]
            }, ],
            columns: [
                    {   data: 'DT_RowIndex', 
                        searchable: false, 
                        orderable: false },
                    {
                        data: null,
                    },
                    {
                        data: null,
                    },
                    {
                        data: null,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                    },
                    {
                        data: null,
                        render: formatTimestamp
                    },
                    {
                        data: null,
                    },
                ],
        });
    </script>
@endsection
