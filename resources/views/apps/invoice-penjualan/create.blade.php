@extends('partial.app')
@section('title', 'Invoice Penjualan')
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
                <div class="collapse" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. DO :
                                        @if($do_mst instanceof \Illuminate\Support\Collection)
                                            @foreach($do_mst as $index => $do)
                                                {{ $do->fc_dono }}
                                                @if($index < $do_mst->count() - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $do_mst->fc_dono }}
                                        @endif

                                    </label>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SO :  {{ $do_mst->first()->fc_sono}}
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Delivery :
                                        @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                            @foreach($do_mst as $index => $do)
                                                {{ \Carbon\Carbon::parse($do->fd_dodate)->isoFormat('D MMMM Y') }}
                                                @if($index < count($do_mst) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                            {{ \Carbon\Carbon::parse($do_mst[0]->fd_dodate)->isoFormat('D MMMM Y') }}
                                        @elseif(!($do_mst instanceof \Illuminate\Support\Collection))
                                            {{ \Carbon\Carbon::parse($do_mst->fd_dodate)->isoFormat('D MMMM Y') }}
                                        @endif
                                    </label>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima :
                                        @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                            @foreach($do_mst as $index => $do)
                                                {{ \Carbon\Carbon::parse($do->fd_arrivaldate)->isoFormat('D MMMM Y') }}
                                                @if($index < count($do_mst) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                            {{ \Carbon\Carbon::parse($do_mst[0]->fd_arrivaldate)->isoFormat('D MMMM Y') }}
                                        @elseif(!($do_mst instanceof \Illuminate\Support\Collection))
                                            {{ \Carbon\Carbon::parse($do_mst->fd_arrivaldate)->isoFormat('D MMMM Y') }}
                                        @endif
                                    </label>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Tipe SO</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->fc_sotype }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->sales->fc_salesname1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{ $do_mst->first()->somst->customer->fc_membercode }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->member_tax_code->fv_description }} ({{ $do_mst->first()->somst->member_tax_code->fc_action }}%)" readonly>
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
                    <h4>Detail Customer</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fc_membertypebusiness }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $do_mst->first()->somst->customer->fc_memberaddress_loading1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $do_mst->first()->somst->customer->fm_memberAP,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            
                            @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                @foreach($do_mst as $index => $do)
                                    @php
                                        $sotransports->push($do->fc_sotransport ?? '-');
                                    @endphp
                                @endforeach
                            @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                @php
                                    $sotransports->push($do_mst[0]->fc_sotransport ?? '-');
                                @endphp
                            @elseif(!($do_mst instanceof \Illuminate\Support\Collection))
                                @php
                                    $sotransports->push($do_mst->fc_sotransport ?? '-');
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

                                        @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                            @foreach($do_mst as $index => $do)
                                                @php
                                                    $transporters->push($do->fc_transporter ?? '-');
                                                @endphp
                                            @endforeach
                                            @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                                @php
                                                    $transporters->push($do_mst[0]->fc_transporter ?? '-');
                                                @endphp
                                            @elseif(!is_array($do_mst))
                                            @php
                                                $transporters->push($do_mst->fc_transporter ?? '-');
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
                                @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
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
                                @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $do_mst[0]->fm_servpay }}" readonly>
                                    </div>
                                @elseif(!is_array($do_mst))
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $do_mst->fm_servpay }}" readonly>
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
                                @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                    @foreach($do_mst as $index => $do)
                                        @php
                                            $fc_custreceiver->push($do->fc_custreceiver ?? '-');
                                        @endphp
                                    @endforeach
                                @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                    @php
                                        $fc_custreceiver->push($do_mst[0]->fc_custreceiver ?? '-');
                                    @endphp
                                @elseif(!is_array($do_mst))
                                    @php
                                        $fc_custreceiver->push($do_mst->fc_custreceiver ?? '-');
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
                                @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                    @foreach($do_mst as $index => $do)
                                        @php
                                            $fv_descriptions->push($do->fv_description ?? '-');
                                        @endphp
                                    @endforeach
                                @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                    @php
                                        $fv_descriptions->push($do_mst[0]->fv_description ?? '-');
                                    @endphp
                                @elseif(!is_array($do_mst))
                                    @php
                                        $fv_descriptions->push($do_mst->fv_description ?? '-');
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
                                @if($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) > 1)
                                    @foreach($do_mst as $index => $do)
                                        @php
                                            $fc_memberaddress_loading->push($do->fc_memberaddress_loading ?? '-');
                                        @endphp
                                    @endforeach
                                @elseif($do_mst instanceof \Illuminate\Support\Collection && count($do_mst) === 1)
                                    @php
                                        $fc_memberaddress_loading->push($do_mst[0]->fc_memberaddress_loading ?? '-');
                                    @endphp
                                @elseif(!$do_mst instanceof \Illuminate\Support\Collection)
                                    @php
                                        $fc_memberaddress_loading->push($do_mst->fc_memberaddress_loading ?? '-');
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
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Lain-lain</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
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
                    <h4>Barang Terkirim</h4>
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
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Diskon</th>
                                        <th scope="col" class="text-center">Persen</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
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
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_modal_biaya();"><i class="fa fa-plus mr-1"></i> Tambah Biaya Lain</button>
                    </div>
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
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit" action="/apps/invoice-penjualan/create/update-inform/{{ $temp->fc_invno }}" method="POST" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Bank</label>
                                    @if (empty($temp->fc_bankcode))
                                    <select class="form-control select2 required-field" name="fc_bankcode" id="fc_bankcode" required></select>
                                    @else
                                    <select class="form-control select2" name="fc_bankcode" id="fc_bankcode">
                                        <option value="{{ $temp->fc_bankcode }}" selected>
                                            {{ $temp->bank->fv_bankname }}
                                        </option>
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Alamat Customer</label>
                                    @if (empty($temp->fc_address))
                                    <select class="form-control select2" name="fc_address" id="fc_address" required>
                                        <option value="" selected disabled>- Pilih Alamat -</option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_memberaddress1 }}">{{ $do_mst->first()->somst->customer->fc_memberaddress1 }}</option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_memberaddress_loading1 }}">{{ $do_mst->first()->somst->customer->fc_memberaddress_loading1 }}</option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_member_npwpaddress1 }}">{{ $do_mst->first()->somst->customer->fc_member_npwpaddress1 }}</option>
                                    </select>
                                    @else
                                    <select class="form-control select2" name="fc_address" id="fc_address">
                                        <option value="{{ $temp->fc_address }}" selected disabled>
                                            {{ $temp->fc_address }}
                                        </option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_memberaddress1 }}">{{ $do_mst->first()->somst->customer->fc_memberaddress1 }}</option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_memberaddress_loading1 }}">{{ $do_mst->first()->somst->customer->fc_memberaddress_loading1 }}</option>
                                        <option value="{{ $do_mst->first()->somst->customer->fc_member_npwpaddress1 }}">{{ $do_mst->first()->somst->customer->fc_member_npwpaddress1 }}</option>
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        @if (empty($temp->fv_description))
                                        <input type="text" class="form-control" name="fv_description_mst" id="fv_description_mst">
                                        @else
                                        <input type="text" class="form-control" name="fv_description_mst" id="fv_description_mst" value="{{ $temp->fv_description }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="button text-right">
                                    @if (empty($temp->fc_address) && empty($temp->fc_bankcode) && empty($temp->fv_description))
                                    <button type="submit" class="btn btn-primary" id="btn_save">Simpan</button>
                                    @else
                                    <button type="submit" class="btn btn-warning" id="btn_save">Edit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/invoice-penjualan/create/submit-invoice" method="post">
            <button type="button" onclick="click_delete()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <input type="hidden" name="fc_invtype" value="{{ utf8_encode('SALES') }}">
            <input type="hidden" name="fc_status" value="{{ utf8_encode('R') }}">

            @if($temp->fc_bankcode != '' && $temp->fc_address != '')
            <button type="submit" class="btn btn-success">Terbitkan Invoice</button>
            @endif
        </form>


    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_biaya" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Biaya Lainnya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_item2" action="/apps/invoice-penjualan/create/store-detail" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <input type="text" value="ADDON" id="fc_status" name="fc_status" hidden>
                                <label>Keterangan</label>
                                <select class="form-control select2" name="fc_detailitem" id="fc_detailitem"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Satuan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_unityname" name="fc_unityname">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Qty</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="fn_itemqty" name="fn_itemqty">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Harga Satuan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="fm_unityprice" name="fm_unityprice" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fv_description" name="fv_description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_detail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Batch</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fc_batch" name="fc_batch" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Expired Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fd_expired" name="fd_expired" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_disc" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Diskon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_update" action="/apps/invoice-penjualan/update-discprice" method="PUT" autocomplete="off">
                <input type="number" id="fn_invrownum" name="fn_invrownum" hidden>
                <input type="hidden" id="fm_discprice" name="fm_discprice">
                <input type="hidden" id="fm_discprecen" name="fm_discprecen">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fm_unityprice_diskon" name="fm_unityprice" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Tipe Diskon</label>
                                <select class="form-control select2" name="tipe_diskon" id="tipe_diskon">
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="Nominal">Nominal</option>
                                    <option value="Persen">Persen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12" id="fm_discprice_nominal" hidden>
                            <div class="form-group">
                                <label>Diskon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control format-rp" id="fm_discprice1" name="fm_discprice1" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12" id="fm_discprice_persen" hidden>
                            <div class="form-group">
                                <label>Diskon</label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0" max="100" class="form-control" id="fm_discprice2" name="fm_discprice2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Harga setelah diskon</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_bank();
        get_data_biaya();
    })

    function get_data_biaya() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/OTHEREXPENSE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_detailitem").empty();
                    $("#fc_detailitem").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_detailitem").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function diskon(button) {
        var id = $(button).data('id');
        var currentPrice = $(button).data('price');
        var newPrice = $(`#fm_unityprice_${id}`).val().toString().replace('.', '');

        $("#modal_disc").modal('show');
        $('#fn_invrownum').val(id);
        $('#fm_unityprice_diskon').val(fungsiRupiahSystem(newPrice));
        $("#tipe_diskon").change(function() {
            if ($('#tipe_diskon').val() === "Persen") {
                $('#fm_discprice_persen').attr('hidden', false);
                $('#fm_discprice_nominal').attr('hidden', true);

                $('#fm_discprice_persen').on('input', function() {
                    var hargaAwal = parseFloat($('#fm_unityprice_diskon').val().toString().replace(/[^\d|\,]/g, ''));
                    var input = parseFloat($('#fm_discprice2').val());
                    var hargaDiskon = parseFloat($('#fm_discprice2').val()) / 100;

                    if (input > 100) {
                        iziToast.warning({
                            title: 'Warning!',
                            message: 'Diskon lebih dari 100%',
                            position: 'topRight'
                        });
                        $('#total').val("Error");
                        $('#update').prop('disabled', true);
                    } else {
                        var total = hargaAwal - (hargaAwal * hargaDiskon);
                        $('#total').val(fungsiRupiahSystem(total));
                        $('#update').prop('disabled', false);
                    }
                    var selisih = hargaAwal - total
                    // var discprice = parseFloat(selisih.toString().replace(/[^\d|\,]/g, ''));
                    $('#fm_discprice').val(parseFloat(selisih));
                    $('#fm_discprecen').val(parseFloat(input));
                });
            } else {
                $('#fm_discprice_persen').attr('hidden', true);
                $('#fm_discprice_nominal').attr('hidden', false);

                $('#fm_discprice_nominal').on('input', function() {
                    var hargaAwal = parseFloat($('#fm_unityprice_diskon').val().toString().replace(/[^\d|\,]/g, ''));
                    var hargaDiskon = parseFloat($('#fm_discprice1').val().toString().replace(/[^\d|\,]/g, ''));

                    if (hargaDiskon > hargaAwal) {
                        iziToast.warning({
                            title: 'Warning!',
                            message: 'Nominal diskon lebih besar daripada harganya',
                            position: 'topRight'
                        });
                        $('#total').val("Error");
                        $('#update').prop('disabled', true);
                    } else {
                        var total = hargaAwal - hargaDiskon;
                        $('#total').val(fungsiRupiahSystem(total));
                        $('#update').prop('disabled', false);
                    }

                    var discprice = parseFloat($('#fm_discprice1').val().toString().replace(/[^\d|\,]/g, ''));
                    $('#fm_discprice').val(discprice);
                    $('#fm_discprecen').val(0);
                });
            }
        });
    }

    function click_modal_biaya() {
        $("#modal_biaya").modal('show');
    }

    function detail(fn_invrownum) {
        $("#modal_detail").modal('show');
        get_detail(fn_invrownum);
    }

    function get_detail(fn_invrownum) {
        $('#modal_loading').modal('show');
        var rownum = window.btoa(fn_invrownum);

        $.ajax({
            url: "/apps/invoice-penjualan/get-detail/" + rownum,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);

                if (response.status == 200) {
                    console.log(data);
                    $('#fc_batch').val(data.fc_batch);
                    $('#fd_expired').val(formatTimestamp(data.fd_expired));
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
    }

    function get_data_bank() {
        var valueBank = "{{ $temp->fc_bankcode }}";
        var nameBank = "{{ $temp->bank ? $temp->bank->fv_bankname : '' }}";

        // console.log(valueBank)
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-all/BankAcc",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_bankcode").empty();
                    if (nameBank == "") {
                        $("#fc_bankcode").append(`<option value="" selected disabled> -- Pilih Bank -- </option>`);
                    } else {
                        $("#fc_bankcode").append(`<option value="${valueBank}" selected disabled> ${nameBank} </option>`);
                    }

                    for (var i = 0; i < data.length; i++) {
                        $("#fc_bankcode").append(
                            `<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
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
        });
    }

    var dono = "{{ $do_mst->count() > 0 ? $do_mst->first()->fc_dono : '' }}";

    var encode_dono = window.btoa(dono);
    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/invoice-penjualan/create/datatables-do-detail/" + encode_dono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: [9]
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
                data: 'fn_itemqty'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="text" id="fm_unityprice_${data.fn_invrownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_unityprice)}">`;
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
                render: function(data, type, row) {
                    return row.fm_value.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            if (data.fn_price == 0) {
                $('td:eq(9)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="detail(${data.fn_invrownum})"><i class="fa fa-eye"></i></button>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>`);
            } else if (data.fc_invstatus === 'R') {
                $('td:eq(9)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="detail(${data.fn_invrownum})"><i class="fa fa-eye"></i></button>
                    <button type="submit" class="btn btn-sm btn-secondary" disabled>Edit</button>`);
            } else {
                $('td:eq(9)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="detail(${data.fn_invrownum})"><i class="fa fa-eye"></i></button>
                <button type="submit" class="btn btn-sm btn-info mr-1" data-id="${data.fn_invrownum}" data-price="${data.fm_unityprice}" onclick="diskon(this)"><i class="fa-solid fa-percent"></i></button>
                <button type="submit" class="btn btn-sm btn-warning" data-id="${data.fn_invrownum}" data-price="${data.fm_unityprice}" onclick="editUnityPrice(this)"><i class="fa fa-edit"></i></button>
                `);
            }
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay_calculate').html(fungsiRupiahSystem(data[0].tempinvmst.fm_servpay));
                $("#fm_servpay_calculate").trigger("change");
                $('#fm_tax').html(fungsiRupiahSystem(data[0].tempinvmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html(fungsiRupiahSystem(data[0].tempinvmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html(fungsiRupiahSystem(data[0].tempinvmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html(fungsiRupiahSystem(data[0].tempinvmst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].tempinvmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        }
    });

    function editUnityPrice(button) {
        var id = $(button).data('id');
        var currentPrice = $(button).data('price');
        var newPrice = $(`#fm_unityprice_${id}`).val().toString().replace('.', '');

        if (newPrice === currentPrice) {
            swal("No changes made.", {
                icon: 'info'
            });
            return;
        }
        swal({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin update harga tersebut?",
            icon: "warning",
            buttons: ["Cancel", "Update"],
            dangerMode: true,
        }).then(function(confirm) {
            if (confirm) {
                updateFmUnityPrice(id, newPrice);
            }
        });
    }

    function updateFmUnityPrice(id, fmUnityPrice) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/invoice-penjualan/update-fm-unityprice',
            type: 'PUT',
            data: {
                fn_invrownum: id,
                fm_unityprice: fmUnityPrice,
            },
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    tb.ajax.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan membatalkan invoice ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/invoice-penjualan/cancel-invoice',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
                            } else {
                                swal(response.message, {
                                    icon: 'error',
                                });
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                .responseText + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    }

    var tb_lain = $('#tb_lain').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/invoice-penjualan/datatables-biaya-lain",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'keterangan.fv_description'
            },
            {
                data: 'fc_unityname'
            },
            {
                data: 'fm_unityprice',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: 'fn_itemqty'
            },
            {
                data: 'fm_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/invoice-penjualan/detail/delete/" + data.fc_invno + '/' + data.fn_invrownum;

            $('td:eq(7)', row).html(`
                <button class="btn btn-sm btn-danger" onclick="delete_action('${url_delete}','Biaya Lainnya')"><i class="fa fa-trash"></i></button>`);
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay_calculate').html(fungsiRupiahSystem(data[0].tempinvmst.fm_servpay));
                $("#fm_servpay_calculate").trigger("change");
                $('#fm_tax').html(fungsiRupiahSystem(data[0].tempinvmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html(fungsiRupiahSystem(data[0].tempinvmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html(fungsiRupiahSystem(data[0].tempinvmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html(fungsiRupiahSystem(data[0].tempinvmst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].tempinvmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        }
    });

    $('#form_submit_item2').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_item2').attr('action'),
            type: $('#form_submit_item2').attr('method'),
            data: $('#form_submit_item2').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal_biaya").modal('hide');
                    $("#form_submit_item2")[0].reset();
                    reset_all_select();
                    tb_lain.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
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
    });

    $('#form_update').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_update').attr('action'),
            type: $('#form_update').attr('method'),
            data: $('#form_update').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal_disc").modal('hide');
                    $("#form_update")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
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
    });
</script>
@endsection