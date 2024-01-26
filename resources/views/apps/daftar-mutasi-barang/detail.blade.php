@extends('partial.app')
@section('title', 'Detail Mutasi Barang')
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
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. Mutasi : {{ $mutasi_mst->fc_mutationno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SO : {{ $mutasi_mst->fc_sono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="{{ \Carbon\Carbon::parse( $mutasi_mst->fd_date_byuser )->isoFormat('D MMMM Y'); }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Jenis Mutasi</label>
                                    <input type="text" class="form-control" value="{{ $mutasi_mst->fc_type_mutation }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Awal</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_startpoint" value="{{ $mutasi_mst->fc_startpoint_code }}" name="fc_startpoint" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_destination" value="{{ $mutasi_mst->fc_destination_code }}" name="fc_destination" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <input type="text" class="form-control" value="{{ $mutasi_mst->warehouse_start->fc_rackname }}" readonly>

                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <input type="text" class="form-control" value="{{ $mutasi_mst->warehouse_destination->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Awal</label>
                                    <textarea type="text" class="form-control" data-height="76" readonly>{{ $mutasi_mst->warehouse_start->fc_warehouseaddress }}</textarea>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Tujuan</label>
                                    <textarea type="text" class="form-control" data-height="76" readonly>{{ $mutasi_mst->warehouse_destination->fc_warehouseaddress }}</textarea>
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
                    <h4>Detail Barang Mutasi</h4>
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
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="fc_penerima">Penerima</label>
                                <div class="input-group">
                                    @if ($mutasi_mst->fc_penerima != null)
                                    <input type="text" class="form-control" id="fc_penerima" name="fc_penerima" value="{{ $mutasi_mst->fc_penerima }}" readonly>
                                    @else
                                    <input type="text" class="form-control" id="fc_penerima" name="fc_penerima" value="Masih Proses" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label for="fc_description">Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_description" name="fc_description" value="{{ $mutasi_mst->fc_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mb-4">
        <a href="/apps/daftar-mutasi-barang"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/daftar-mutasi-barang/datatables",
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
                data: 'stock.fc_namelong'
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_qty'
            },
        ],
    });
</script>
@endsection