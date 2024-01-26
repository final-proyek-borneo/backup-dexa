@extends('partial.app')
@section('title', 'Detail ' . $inv_mst->fc_invno)
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
            @if ($inv_mst->fc_invtype == 'SALES')
                <div class="col-12 col-md-4 col-lg-5">
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
                                            <label>No. DO : {{ $inv_mst->fc_child_suppdocno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>No. SO : {{ $inv_mst->fc_suppdocno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Delivery :
                                                {{ date('d-m-Y', strtotime($inv_mst->domst->fd_dodate ?? '-')) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Diterima :
                                                {{ date('d-m-Y', strtotime($inv_mst->domst->fd_arrivaldate ?? '-')) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Tipe SO</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->somst->fc_sotype ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Sales</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->somst->sales->fc_salesname1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Customer Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="fc_membercode"
                                                    name="fc_membercode"
                                                    value="{{ $inv_mst->customer->fc_membercode ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Status PKP</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->somst->member_tax_code->fv_description ?? '-' }} ({{ $inv_mst->somst->member_tax_code->fc_action ?? '-' }}%)"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Customer</h4>
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
                                                value="{{ $inv_mst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Cabang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->member_typebranch->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Bisnis</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_membertypebusiness ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_membername1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_memberaddress1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Masa Piutang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fn_memberAgingAP ?? '-' }} Hari" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Legal Status</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->member_legal_status->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Alamat Muat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_memberaddress_loading1 ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Piutang</label>
                                            <input type="text" class="form-control"
                                                value="Rp. {{ optional($inv_mst)->customer ? number_format($inv_mst->customer->fm_memberAP, 0, ',', '.') : '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($inv_mst->fc_invtype == 'PURCHASE')
                <div class="col-12 col-md-4 col-lg-6">
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
                                            <label>No. BPB : {{ $inv_mst->fc_child_suppdocno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>No. PO : {{ $inv_mst->fc_suppdocno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>No. SJ : {{ $inv_mst->romst->fc_sjno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>No. GR : {{ $inv_mst->romst->fc_grno ?? '-' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl PO :
                                                {{ date('d-m-Y', strtotime($inv_mst->pomst->fd_podateinputuser ?? '-')) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Diterima :
                                                {{ date('d-m-Y', strtotime($inv_mst->romst->fd_roarivaldate ?? '-')) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Basis Gudang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->romst->warehouse->fc_rackname ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Status PKP</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->supplier_tax_code->fv_description ?? '-' }} ({{ $inv_mst->supplier->supplier_tax_code->fc_action ?? '-' }}%)"
                                                readonly>
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
                            <h4>Detail Supplier</h4>
                            <div class="card-header-action">
                                <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                            </div>
                        </div>
                        <div class="collapse show" id="mycard-collapse2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>NPWP</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->fc_supplierNPWP ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Cabang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->supplier_typebranch->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Bisnis</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->supplier_type_business->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->fc_suppliername1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->fc_supplier_npwpaddress1 ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Masa Hutang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->fn_supplierAgingAR ?? '-' }} Hari" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <label>Legal Status</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->supplier->supplier_legal_status->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <label>Hutang</label>
                                            <input type="text" class="form-control"
                                                value="Rp. {{ $inv_mst->supplier->fm_supplierAR ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-md-4 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Invoice CPRR</h4>
                            <div class="card-header-action">
                                <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                            </div>
                        </div>
                        <div class="collapse show" id="mycard-collapse">
                            <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Operator</label>
                                            <input type="text" class="form-control" id="fc_userid" name="fc_userid"
                                                value="{{ $inv_mst->fc_userid ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Terbit</label>
                                            <div class="input-group date">
                                                <input type="text" id="fd_inv_releasedate" name="fd_inv_releasedate"
                                                    class="form-control" fdprocessedid="8ovz8a"
                                                    value="{{ $inv_mst->fd_inv_releasedate ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>No. Dokumen RS</label>
                                            <input type="text" class="form-control" id="fc_sono" name="fc_sono"
                                                value="{{ $inv_mst->fc_suppdocno ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Jatuh Tempo</label>
                                            <div class="input-group date">
                                                <input type="text" id="fd_inv_agingdate" name="fd_inv_agingdate"
                                                    class="form-control" fdprocessedid="8ovz8a"
                                                    value="{{ $inv_mst->fd_inv_agingdate ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group required">
                                            <label>Customer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="fc_membercode"
                                                    name="fc_membercode" value="{{ $inv_mst->fc_entitycode ?? '-' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Customer</h4>
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
                                                value="{{ $inv_mst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Cabang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->member_typebranch->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tipe Bisnis</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_membertypebusiness ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_membername1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_memberaddress1 ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Masa Piutang</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fn_memberAgingAP ?? '-' }} Hari" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Legal Status</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->member_legal_status->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Alamat Muat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $inv_mst->customer->fc_memberaddress_loading1 ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Piutang</label>
                                            <input type="text" class="form-control"
                                                value="Rp. {{ isset($inv_mst->customer) ? number_format($inv_mst->customer->fm_memberAP, 0, ',', '.') : '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($inv_mst->fc_invtype == 'SALES')
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Transportasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Transport</label>
                                    @php
                                        $sotransports = collect();
                                    @endphp
                                
                                    @if(count($do_mst) > 1)
                                        @foreach($do_mst as $index => $do)
                                            @php
                                                $sotransports->push($do->fc_sotransport ?? '-');
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $sotransports->push($do_mst->first()->fc_sotransport ?? '-');
                                        @endphp
                                    @endif
                                
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_sotransport" id="fc_sotransport" value="{{ $sotransports->unique()->implode(', ') }}" readonly>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Transporter</label>
                                            @php
                                                $transporters = collect();
                                            @endphp
    
                                            @if(count($do_mst) > 1)
                                                @foreach($do_mst as $index => $do)
                                                    @php
                                                        $transporters->push($do->fc_transporter ?? '-');
                                                    @endphp
                                                @endforeach
                                            @else
                                                @php
                                                    $transporters->push($do_mst->first()->fc_transporter ?? '-');
                                                @endphp
                                            @endif
    
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $transporters->unique()->implode(', ') }}" readonly>
                                            </div>
    
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Biaya Transport</label>
                                    @php
                                        $fm_servpay_values = collect();
                                    @endphp
                                    @if(count($do_mst) > 1)
                                        @foreach($do_mst as $index => $do)
                                            @php
                                                $fm_servpay_values->push($do->fm_servpay);
                                            @endphp
                                        @endforeach
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $fm_servpay_values->sum() }}" readonly>
                                        </div>
                                    @else
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $fm_servpay_values->sum() }}" readonly>
                                        </div>
                                    @endif
                                </div>
                                
                                
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Penerima</label>
                                    @php
                                        $fc_custreceiver = collect();
                                    @endphp
                                    @if(count($do_mst) > 1)
                                        @foreach($do_mst as $index => $do)
                                            @php
                                                $fc_custreceiver->push($do->fc_custreceiver ?? '-');
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $fc_custreceiver->push($do_mst->first()->fc_custreceiver ?? '-');
                                        @endphp
                                    @endif
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_custreceiver" id="fc_custreceiver" value="{{ $fc_custreceiver->unique()->implode(', ') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    @php
                                        $fv_descriptions = collect();
                                    @endphp
                                    @if(count($do_mst) > 1)
                                        @foreach($do_mst as $index => $do)
                                            @php
                                                $fv_descriptions->push($do->fv_description ?? '-');
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $fv_descriptions->push($do_mst->first()->fv_description ?? '-');
                                        @endphp
                                    @endif
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fv_description" id="fv_description" value="{{ $fv_descriptions->unique()->implode(', ') }}" readonly>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Pengiriman</label>
                                    @php
                                         $fc_memberaddress_loading = collect();
                                     @endphp
                                    @if(count($do_mst) > 1)
                                        @foreach($do_mst as $index => $do)
                                            @php
                                                $fc_memberaddress_loading->push($do->fc_memberaddress_loading ?? '-');
                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $fc_memberaddress_loading->push($do_mst->first()->fc_memberaddress_loading ?? '-');
                                        @endphp
                                    @endif
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_memberaddress_loading" id="fc_memberaddress_loading" value="{{ $fc_memberaddress_loading->unique()->implode(', ') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @elseif($inv_mst->fc_invtype == 'PURCHASE')
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Transportasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Transport</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fc_potransport"
                                                id="fc_potransport" value="{{ $inv_mst->pomst->fc_potransport ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fc_receiver"
                                                id="fc_receiver" value="{{ $inv_mst->romst->fc_receiver ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Biaya Transport</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="fm_servpay" id="fm_servpay"
                                                value="{{ $inv_mst->fm_servpay ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fv_description"
                                                id="fv_description" value="{{ $inv_mst->romst->fv_description ?? '-' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Alamat Penerimaan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fc_address_loading"
                                                id="fc_address_loading"
                                                value="{{ $inv_mst->romst->fc_address_loading ?? '-' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif

            @if ($inv_mst->fc_invtype == 'SALES')
                {{-- TOTAL HARGA --}}
                <div class="col-12 col-md-12 col-lg-6 place_detail">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kalkulasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-row-item" style="margin-right: 30px">
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="count_item">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_disctotal">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_netto">0,00</p>
                                    </div>
                                </div>
                                <div class="flex-row-item">
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_servpay_calculate">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_tax">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item"
                                            style="font-weight: bold; font-size: medium">GRAND</p>
                                        <p class="text-success flex-row-item text-right"
                                            style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($inv_mst->fc_invtype == 'PURCHASE')
                {{-- TOTAL HARGA --}}
                <div class="col-12 col-md-12 col-lg-6 place_detail">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kalkulasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-row-item" style="margin-right: 30px">
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="count_item">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_disctotal">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_netto">0,00</p>
                                    </div>
                                </div>
                                <div class="flex-row-item">
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_servpay_calculate">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium"
                                            id="fm_tax">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item"
                                            style="font-weight: bold; font-size: medium">GRAND</p>
                                        <p class="text-success flex-row-item text-right"
                                            style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
            {{-- TABLE --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    @if ($inv_mst->fc_invtype == 'SALES')
                        <div class="card-header">
                            <h4>Barang Terkirim</h4>
                        </div>
                    @elseif($inv_mst->fc_invtype == 'PURCHASE')
                        <div class="card-header">
                            <h4>Barang Diterima</h4>
                        </div>
                    @else
                        <div class="card-header">
                            <h4>Data CPRR</h4>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                @if ($inv_mst->fc_invtype == 'SALES')
                                    <table class="table table-striped" id="tb_do" width="100%">
                                    @elseif($inv_mst->fc_invtype == 'PURCHASE')
                                        <table class="table table-striped" id="tb_ro" width="100%">
                                        @else
                                            <table class="table table-striped" id="tb_cprr" width="100%">
                                @endif
                                <thead style="white-space: nowrap">
                                    @if ($inv_mst->fc_invtype == 'CPRR')
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode CPRR</th>
                                            <th scope="col" class="text-center">Nama</th>
                                            <th scope="col" class="text-center">Satuan</th>
                                            <th scope="col" class="text-center">Jumlah</th>
                                            <th scope="col" class="text-center">Harga Satuan</th>
                                            <th scope="col" class="text-center">Diskon</th>
                                            <th scope="col" class="text-center">Persen</th>
                                            <th scope="col" class="text-center">Catatan</th>
                                            <th scope="col" class="text-center">Total</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode Barang</th>
                                            <th scope="col" class="text-center">Nama Barang</th>
                                            <th scope="col" class="text-center">Satuan</th>
                                            <th scope="col" class="text-center">Batch</th>
                                            <th scope="col" class="text-center">Exp. Date</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Harga Satuan</th>
                                            <th scope="col" class="text-center">Diskon</th>
                                            <th scope="col" class="text-center">Persen</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    @endif
                                </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Biaya Lainnya</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_lain" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Keterangan</th>
                                            <th scope="col" class="text-center">Satuan</th>
                                            <th scope="col" class="text-center">Harga Satuan</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center">Catatan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($inv_mst->fc_invtype == 'SALES')
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body" style="padding-top: 30px!important;">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Bank</label>
                                        <input type="text" class="form-control" name="fc_bankcode" id="fc_bankcode"
                                            value="{{ $inv_mst->bank->fv_bankname ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="fc_address" id="fc_address"
                                            value="{{ $inv_mst->fc_address ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <form id="form_submit" action="/apps/daftar-invoce/update-description"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fv_description"
                                                    id="fv_description" value="{{ $inv_mst->fv_description ?? '-' }}">
                                                <input type="hidden" class="form-control" name="fc_invtype" 
                                                    id="fc_invtype" value="{{ $inv_mst->fc_invtype }}" />
                                                <input type="hidden" class="form-control" name="fc_invno" 
                                                    id="fc_invno" value="{{ $inv_mst->fc_invno }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-12">
                                            <div class="button text-right">
                                                <button type="submit" class="btn btn-warning" id="btn_save">
                                                    <i class="fas fa-edit"></i> Ubah Catatan
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($inv_mst->fc_invtype == 'PURCHASE')
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body" style="padding-top: 30px!important;">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Bank</label>
                                        <input type="text" class="form-control" name="fc_bankcode" id="fc_bankcode"
                                            value="{{ $inv_mst->supplier->fc_supplierbank1 ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Alamat Supplier</label>
                                        <input type="text" class="form-control" name="fc_address" id="fc_address"
                                            value="{{ $inv_mst->fc_address ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <form id="form_submit" action="/apps/daftar-invoice/update-description"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fv_description"
                                                    id="fv_description" value="{{ $inv_mst->fv_description ?? '-' }}">
                                                <input type="hidden" class="form-control" name="fc_invtype" 
                                                    id="fc_invtype" value="{{ $inv_mst->fc_invtype }}" />
                                                <input type="hidden" class="form-control" name="fc_invno" 
                                                    id="fc_invno" value="{{ $inv_mst->fc_invno }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-12">
                                            <div class="button text-right">
                                                <button type="submit" class="btn btn-warning" id="btn_save">
                                                    <i class="fas fa-edit"></i> Ubah Catatan
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body" style="padding-top: 30px!important;">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Bank</label>
                                        <input type="text" class="form-control" name="fc_bankcode" id="fc_bankcode"
                                            value="{{ $inv_mst->bank->fv_bankname ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group required">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="fc_address" id="fc_address"
                                            value="{{ $inv_mst->fc_address ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <form id="form_submit" action="/apps/daftar-invoice/update-description"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fv_description"
                                                    id="fv_description" value="{{ $inv_mst->fv_description ?? '-' }}">
                                                <input type="hidden" class="form-control" name="fc_invtype" 
                                                id="fc_invtype" value="{{ $inv_mst->fc_invtype }}" />
                                                <input type="hidden" class="form-control" name="fc_invno" 
                                                id="fc_invno" value="{{ $inv_mst->fc_invno }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-12">
                                            <div class="button text-right">
                                                <button type="submit" class="btn btn-warning" id="btn_save">
                                                    <i class="fas fa-edit"></i> Ubah Catatan
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="button text-right mb-4">
            <a href="/apps/daftar-invoice"><button type="button" class="btn btn-info">Back</button></a>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        var invno = "{{ $inv_mst->fc_invno }}";
        var encode_invno = window.btoa(invno);

        var tb_do = $('#tb_do').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/daftar-invoice/datatables-do-detail/" + encode_invno,
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
                    data: 'invstore.fc_batch'
                },
                {
                    data: 'invstore.fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fn_itemqty'
                },
                {
                    data: null,
                    render: function(data, type, full, meta) {
                        return `<input type="text" id="fm_unityprice_${data.fn_invrownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiah(data.fm_unityprice)}" readonly>`;
                    }
                },
                {
                    data: 'fm_discprice',
                    render: function(data, type, row) {
                        return row.fm_discprice.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fm_discprecen',
                    defaultContent: '-'
                },
                {
                    data: 'fm_value',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(11)', row).html(`
                <button type="submit" class="btn btn-secondary" disabled>Edit</button>`);
            },
            footerCallback: function(row, data, start, end, display) {
                if (data.length != 0) {
                    console.log(data);
                    $('#fm_servpay_calculate').html(fungsiRupiahSystem(data[0].invmst.fm_servpay));
                    $("#fm_servpay_calculate").trigger("change");
                    $('#fm_tax').html(fungsiRupiahSystem(data[0].invmst.fm_tax));
                    $("#fm_tax").trigger("change");
                    $('#fm_brutto').html(fungsiRupiahSystem(data[0].invmst.fm_brutto));
                    $("#fm_brutto").trigger("change");
                    $('#fm_netto').html(fungsiRupiahSystem(data[0].invmst.fm_netto));
                    $("#fm_netto").trigger("change");
                    $('#fm_disctotal').html(fungsiRupiahSystem(data[0].invmst.fm_disctotal));
                    $("#fm_disctotal").trigger("change");
                    $('#count_item').html(data[0].fn_invdetail);
                    $("#count_item").trigger("change");
                }
            }
        });

        var tb_lain = $('#tb_lain').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/daftar-invoice/datatables-inv-detail/" + encode_invno,
                type: 'GET',
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
                    data: 'fc_detailitem'
                },
                {
                    data: 'fc_unityname'
                },
                {
                    data: 'fm_unityprice',
                    render: function(data, type, row) {
                        return row.fm_unityprice.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fn_itemqty'
                },
                {
                    data: 'fm_value',
                    render: function(data, type, row) {
                        return row.fm_value.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fv_description',
                    defaultContent: '-'
                },
            ],
            rowCallback: function(row, data) {

            },
            footerCallback: function(row, data, start, end, display) {

            }
        });

        var tb_ro = $('#tb_ro').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/daftar-invoice/datatables-ro-detail/" + encode_invno,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3]
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
                    data: 'invstore.fc_batch'
                },
                {
                    data: 'invstore.fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fn_itemqty'
                },
                {
                    data: null,
                    render: function(data, type, full, meta) {
                        return `<input type="text" id="fm_unityprice_${data.fn_invrownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_unityprice)}" readonly>`;
                    }
                },
                {
                    data: 'fm_value',
                    render: function(data, type, row) {
                        return row.fm_value.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fm_discprice',
                    render: function(data, type, row) {
                        return row.fm_discprice.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fm_discprecen',
                    defaultContent: '-'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(11)', row).html(`
                <button type="submit" class="btn btn-secondary" disabled>Edit</button>`);
            },
            footerCallback: function(row, data, start, end, display) {
                if (data.length != 0) {
                    console.log(data);
                    $('#fm_servpay_calculate').html(fungsiRupiahSystem(data[0].invmst.fm_servpay));
                    $("#fm_servpay_calculate").trigger("change");
                    $('#fm_tax').html(fungsiRupiahSystem(data[0].invmst.fm_tax));
                    $("#fm_tax").trigger("change");
                    $('#fm_brutto').html(fungsiRupiahSystem(data[0].invmst.fm_brutto));
                    $("#fm_brutto").trigger("change");
                    $('#fm_netto').html(fungsiRupiahSystem(data[0].invmst.fm_netto));
                    $("#fm_netto").trigger("change");
                    $('#fm_disctotal').html(fungsiRupiahSystem(data[0].invmst.fm_disctotal));
                    $("#fm_disctotal").trigger("change");
                    $('#count_item').html(data[0].invmst.fn_invdetail);
                    $("#count_item").trigger("change");
                }
            }
        });

        var tb_cprr = $("#tb_cprr").DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/apps/daftar-invoice/datatables-cprr/' + encode_invno,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'fc_detailitem',
                },
                {
                    data: 'cospertes.fc_cprrname',
                },

                {
                    data: 'nameunity.fv_description',
                },
                {
                    data: 'fn_itemqty',
                },
                {
                    data: 'fm_unityprice',
                    render: function(data, type, row) {
                        return row.fm_unityprice.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fm_discprice',
                    render: function(data, type, row) {
                        return row.fm_discprice.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fm_discprecen',
                    defaultContent: '-'
                },
                {
                    data: 'fv_description',
                    defaultContent: '-'
                },
                {
                    data: 'fm_value',
                    render: function(data, type, row) {
                        return row.fm_value.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
            ],
            rowCallback: function(row, data) {},
        });
    </script>
@endsection
