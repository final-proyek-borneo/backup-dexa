<html>

<head>
<title>Invoice</title>
<link href="https://www.dafontfree.net/embed/bHVjaWRhLWNvbnNvbGUtcmVndWxhciZkYXRhLzExL2wvNjAzODMvTHVjaWRhIENvbnNvbGUudHRm" rel="stylesheet" type="text/css" />
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');

    @page {
        margin: 40px 40px;
        font-family: 'Roboto Mono', monospace;
    }

    * {
        font-family: 'Roboto Mono', monospace;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .next-page {
        page-break-before: always;
    }

    .no-margin>* {
        margin: 0 !important;
    }

    .header-text p {
        margin-bottom: 0px;
    }

    .table-success th {
        background: rgb(204, 255, 204) !important;
    }

    .image-container {
        margin: auto;
        width: 100%;
        position: relative;
        justify-content: center;
        flex-direction: column;
    }

    .container {
        width: 100%;
        margin: auto;
    }

    .daftar_isi li {
        padding: 8px 0 0 5px !important;
    }

    .fw-bold{
        font-weight: bold;
        white-space: nowrap;
    }

    th,
    td {
        vertical-align: middle;
    }

    .table-center thead tr th, .table-center tbody tr td{
        text-align: center;
        padding: 1px;
    }

    .table-start thead tr th, .table-start tbody tr td{
        vertical-align: start;
        padding: 1px;
    }

    .table-center-start thead tr th{
        vertical-align: center;
        text-align: center;
    }

    .table-center-start tbody tr td{
        vertical-align: start;
    }

    .text-start{
        text-align: unset!important;
    }

    .pl-2{
        padding-left: 75px;
    }

    .pl-1{
        padding-left: 50px;
    }

    .pl-0{
        padding-left: 25px;
    }

    .header{
        width: 100%;
    }

    .content{
        margin-top: 25px
    }

    .pt-1 > * {
        padding-top: 15px;
    }

    .pb-1 > *{
        padding-bottom: 15px;
    }

    /* font size*/
    p,
    label {
        font-size: 13px;
    }

    table {
        font-size: 13px!important;
    }

    table th {
        padding: 1.5px;
        font-size: 13px;
        font-weight: regular;
        font-family: 'Roboto Mono', monospace;
    }

    table td {
        padding: 1px;
        font-size: 13px;
    }

    .table-header {
        font-size: 13px;
    }

    .table-lg td{
        font-size: 13px;
    }

    .table-xl td {
        font-size: 13px;
    }

    .div-lg p{
        font-size: 13px;
    }

    .footer p {
        font-size: 10px;
    }

    .table-lg,
    .table-lg th,
    .table-lg td {
        border: 1px solid black;
    }

    @media print {
        html,
        body {
            width: 8.5in;
            height: 11in;
            display: block;
            font-family: 'Roboto Mono', monospace;
        }

        @page {
            size: 8.5in 11in;
        }
    }
</style>

<body>
<div class="container" id="print">
    <div class="header" style="height: 100px">
        <div style="position: absolute; left: 0; top: 0">
            <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
        </div>
        @if($inv_mst->fc_invtype == 'SALES')
        <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
            <p style="font-size: 14px;">Kepada Yth</p>
            <p>{{ $inv_mst->customer->fc_memberlegalstatus ?? '-' }} {{ $inv_mst->customer->fc_membername1 ?? '-' }}</p>
            <p>{{ $inv_mst->fc_address ?? '-' }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 0; text-align: right;" class="no-margin">
            <p style="font-size: 14px;">PT DEXA ARFINDO PRATAMA</p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo,</p>
            <p>Kec. Wonocolo, Surabaya, Jawa Timur (60297)</p>
            <p>dexa-arfindopratama.com</p>
        </div>
        @elseif($inv_mst->fc_invtype == 'PURCHASE')
        <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
            <p style="font-size: 14px;">Kepada Yth</p>
            <p>{{ $inv_mst->supplier->fc_supplierlegalstatus ?? '-' }} {{ $inv_mst->supplier->fc_suppliername1 ?? '-' }}</p>
            <p>{{ $inv_mst->supplier->fc_supplier_npwpaddress1 ?? '-' }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 0; text-align: right;" class="no-margin">
            <p style="font-size: 14px;">PT DEXA ARFINDO PRATAMA</p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo,</p>
            <p>Kec. Wonocolo, Surabaya, Jawa Timur (60297)</p>
            <p>dexa-arfindopratama.com</p>
        </div>
        @else
        <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
            <p style="font-size: 14px;">Kepada Yth</p>
            <p>{{ $inv_mst->customer->fc_memberlegalstatus ?? '-' }} {{ $inv_mst->customer->fc_membername1 ?? '-' }}</p>
            <p>{{ $inv_mst->fc_address ?? '-' }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 0; text-align: right;" class="no-margin">
            <p style="font-size: 14px;">PT DEXA ARFINDO PRATAMA</p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo,</p>
            <p>Kec. Wonocolo, Surabaya, Jawa Timur (60297)</p>
            <p>dexa-arfindopratama.com</p>
        </div>
        @endif
    </div>
</div>

<div class="content" id="print">
        @if($inv_mst->fc_invtype == 'SALES' || $inv_mst->fc_invtype == 'CPRR')
        <br><br><br>
        <p style="text-align: center; font-size: 15px; margin: 0;">INVOICE</p>
        @else
        <br><br><br>
        <p style="text-align: center; font-size: 15px; margin: 0;">BUKTI PENERIMAAN BARANG</p>
        @endif
        <br>
        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
            @if($inv_mst->fc_invtype == 'SALES')
            <tr>
                <td>Sales</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->somst->sales->fc_salesname1 ?? '-' }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @elseif($inv_mst->fc_invtype == 'PURCHASE')

            @else
            <tr>
                <td>Sales</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->somst->sales->fc_salesname1 ?? '-' }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif

            @if($inv_mst->fc_invtype == 'SALES' || $inv_mst->fc_invtype == 'CPRR')
            <tr>
                <td>NPWP</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">03.125.501.1-609.000</td>
                <td>Tanggal</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_releasedate ?? '-' )->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr class="">
                <td>Nomor</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->fc_invno ?? '-' }}</td>
                <td>Jatuh Tempo</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_agingdate ?? '-' )->isoFormat('D MMMM Y') }}</td>
            </tr>
            @else
            <tr>
                <td>No. BPB</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->fc_invno ?? '-' }}</td>
                <td>Tgl Diterima</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->romst->fd_roarivaldate ?? '-' )->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr class="pb-1">
                <td>No. Surat Jalan</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->romst->fc_sjno ?? '-' }}</td>
                <td>No. PO</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->fc_suppdocno ?? '-' }}</td>
            </tr>
            @endif
        </table>
        @if($inv_mst->fc_invtype == 'PURCHASE')
        <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;" class="no-space">
            <tr>
                <td>Penerima</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ $inv_mst->romst->fc_receiver ?? '-' }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Alamat Pengiriman</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->romst->fc_address_loading ?? '-' }}</td>
            </tr>
            <tr class="pb-1">
                <td>By</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->romst->fc_potransport ?? '-' }}</td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 26%"></td>
            </tr>
        </table>
        @else
        @endif

        @if($inv_mst->fc_invtype == 'SALES')
        <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Barang Dikirim</p>
        <table class="table-lg table-center" style="margin-bottom: 5px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Batch</th>
                <th>Exp. Date</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Total</th>
            </tr>

            @if(isset($inv_dtl))
                @foreach ($inv_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->invstore->stock->fc_namepack }}</td>
                        <td>{{ $item->invstore->fc_batch }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->invstore->fd_expired)) }}</td>
                        <td>{{ $item->fn_itemqty }}</td>
                        <td>Rp. {{ number_format($item->fm_unityprice,2, ",", ".")}}</td>
                        @if ($tampil_diskon == 'N')
                        <td>Rp. {{ number_format($item->fm_discprice,2, ",", ".")}}</td>
                        @else
                        <td>{{ number_format($item->fm_discprecen,2, ",", ".")}} %</td>
                        @endif
                        <td>Rp. {{ number_format($item->fm_value,2, ",", ".")}}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif

        </table>
        @elseif($inv_mst->fc_invtype == 'PURCHASE')
        <p style="font-size: .8rem; margin-left: 5%">Barang Diterima</p>
        <table class="table-lg table-center" style="margin-bottom: 5px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Batch</th>
                <th>Exp. Date</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Total</th>
            </tr>

            @if(isset($inv_dtl))
                @foreach ($inv_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->invstore->stock->fc_namepack }}</td>
                        <td>{{ $item->invstore->fc_batch }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->invstore->fd_expired)) }}</td>
                        <td>{{ $item->fn_itemqty }}</td>
                        <td>Rp. {{ number_format($item->fm_unityprice,2, ",", ".")}}</td>
                        @if ($tampil_diskon == 'N')
                        <td>Rp. {{ number_format($item->fm_discprice,2, ",", ".")}}</td>
                        @else
                        <td>{{ number_format($item->fm_discprecen,2, ",", ".")}} %</td>
                        @endif
                        <td>Rp. {{ number_format($item->fm_value,2, ",", ".")}}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif
        </table>
        @else
        <p style="font-size: 14px; margin-left: 5%">Data CPRR</p>
        <table class="table-lg table-center" style="margin-bottom: 5px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Catatan</th>
                <th>Total</th>
            </tr>

            @if(isset($inv_dtl))
                @foreach ($inv_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->fc_detailitem }}</td>
                        <td>{{ $item->nameunity->fv_description }}</td>
                        <td>{{ $item->fn_itemqty }}</td>
                        <td>Rp. {{ number_format($item->fm_unityprice, 4, ",", ".")}}</td>
                        @if ($tampil_diskon == 'N')
                        <td>Rp. {{ number_format($item->fm_discprice,2, ",", ".")}}</td>
                        @else
                        <td>{{ number_format($item->fm_discprecen,2, ",", ".")}} %</td>
                        @endif
                        <td>{{ $item->fv_description ?? '-'}}</td>
                        <td>Rp. {{ number_format($item->fm_value, 2, ",", ".")}}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif
        </table>
        @endif

        <table style="width: 90%; border-collapse: collapse; margin: auto;">
            <tr>
                <td>Total</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">Rp. {{ number_format($inv_mst->fm_netto, 2, ",", ".")}}</td>
                <td>Biaya Kirim</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format( $inv_mst->fm_servpay, 2, ",", ".")}}</td>
            </tr>

            <tr>
                <td>Pajak</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($inv_mst->fm_tax, 2, ",", ".")}}</td>
                <td>Biaya Materai</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. 0</td>
            </tr>
            <tr class="pb-1">
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 28%"></td>
                <td>Tagihan</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($inv_mst->fm_brutto, 2, ",", ".")}}</td>
            </tr>
        </table>

        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
        @if ($inv_mst->fc_invtype == 'PURCHASE')
            <tr>

            </tr>
            <tr>
                
            </tr>
        @else
            <tr>
                <td>Terbilang :</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="width: 50%;">"{{ terbilang($inv_mst->fm_brutto) }} Rupiah"</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        </table>

        @if($inv_mst->fc_invtype == 'SALES' || $inv_mst->fc_invtype == 'CPRR')
        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always ">
            <br>
            <tr >
                <td style="width: 50% !important; text-align: left;">Hormat Kami,</td>
                <td style="width: 50% !important; text-align: right;">Penerima,</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;">PT DEXA ARFINDO PRATAMA</td>
                @if($inv_mst->fc_invtype == 'SALES')
                <td style="width: 50% !important; text-align: right;">{{ $inv_mst->customer->fc_memberlegalstatus ?? '-' }} {{ $inv_mst->customer->fc_membername1 ?? '-' }}</td>
                @elseif($inv_mst->fc_invtype == 'PURCHASE')
                <td></td>
                @else
                <td style="width: 50% !important; text-align: right;">{{ $inv_mst->customer->fc_memberlegalstatus ?? '-' }} {{ $inv_mst->customer->fc_membername1 ?? '-' }}</td>
                @endif
            </tr>
            <br><br>
            <br><br>
            <tr >
                <td style="width: 50% !important; text-align: left;">( {{ $nama_pj }} )</td>
                <td style="width: 50% !important; text-align: right;">(..........................)</td>
            </tr>
        </table>
        @else
        <table style="width: 100%;   margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always">
            <br><br/>
            <tr>
                <td style="text-align: right;">Surabaya, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr >
                <td style="width: 50% !important; text-align: right;">PT DEXA ARFINDO PRATAMA</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="width: 50% !important; text-align: right;">( {{ $nama_pj }} )</td>
            </tr>
        </table>
        @endif

        <br>
        @if($inv_mst->fc_invtype == 'SALES' || $inv_mst->fc_invtype == 'CPRR')
        <div class="container">
            <div class="footer" style="height: 100px">
                <div style="text-align: left; page-break-before:always page-break-after:always" class="no-margin">
                    <p style="font-size: 11px;">Catatan : {{ $inv_mst->fv_description ?? '-' }}</p>
                    <p style="font-size: 11px;">Syarat Pembayaran :</p>
                    <p>- Pembayaran harap di selesaikan dalam waktu 30 hari dari tanggal Faktur</p>
                    <p>- Pembayaran harap dilakukan dengan Giro Bilyet / Cross Cheque atau transfer ke bank kami.</p>
                    @if($inv_mst->fc_invtype == 'SALES')
                    <p>&nbsp;&nbsp;Atas Nama : PT DEXA ARFINDO PRATAMA</p>
                    <p>&nbsp;&nbsp;{{ $inv_mst->bank->fv_bankname ?? '-' }}</p>
                    <p>&nbsp;&nbsp;A/C {{ $inv_mst->bank->fc_bankcode ?? '-' }}</p>
                    @elseif($inv_mst->fc_invtype == 'PURCHASE')
                    <p>&nbsp;&nbsp;Atas Nama : {{ $inv_mst->supplier->fc_suppliername1 ?? '-' }}</p>
                    <p>&nbsp;&nbsp;{{ $inv_mst->supplier->fc_supplierbank1 ?? '-' }}</p>
                    <p>&nbsp;&nbsp;A/C {{ $inv_mst->fc_bankcode ?? '-' }}</p>
                    @else
                    <p>&nbsp;&nbsp;Atas Nama : PT DEXA ARFINDO PRATAMA</p>
                    <p>&nbsp;&nbsp;{{ $inv_mst->bank->fv_bankname ?? '-' }}</p>
                    <p>&nbsp;&nbsp;A/C {{ $inv_mst->bank->fc_bankcode ?? '-' }}</p>
                    @endif
                    <p>- Pembayaran di anggap lunas apabila sudah CAIR</p>
                </div>
            </div>
        </div>
        @else
        @endif
    <div>
</body>

</html>

<?php
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "Minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }     		
        return $hasil;
    }
?>