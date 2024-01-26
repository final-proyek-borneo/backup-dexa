<html>

<head>
</head>
<style>
    @page {
        margin: 40px 40px;
        font-family: "Times New Roman", Times, serif;
    }

    * {
        font-family: Arial, Helvetica, sans-serif;
    }


    p,
    label {
        font-size: 12px;
    }

    table {
        font-size: 11px;
    }

    table th {
        padding: 6px 4px;
        font-size: .8rem;
    }

    table td {
        padding: 6px 4px;
        font-size: .8rem;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 11px;
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

    .background-header{
        height: 350px;
        background-size: 100% auto;
        bottom: 0;
        position: absolute;
        width: 100%;
        background-repeat: no-repeat;
        background-image: url({{ public_path('assets-pdf/bg.jpg') }})
    }

    .container {
        width: 100%;
        margin: auto;
    }

    .daftar_isi li {
        padding: 8px 0 0 5px !important;
    }

    .table-lg td{
        font-size: .8rem!important;
    }

    .table-xl td {
        font-size: .9rem !important;
    }

    .div-lg p{
        font-size: .9rem!important;
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
    }

    .table-start thead tr th, .table-start tbody tr td{
        vertical-align: start;
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

    .content p {
        font-size: 12px;
    }
</style>

<body>
<div class="container" id="so-pdf">
    <div class="header" style="height: 100px">
        <div style="position: absolute; left: 0; top: 0">
            <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
        </div>
        <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
            <p><b>Kepada Yth</b></p>
            <p>{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</p>
            <p>{{ $do_mst->somst->customer->fc_memberaddress_loading1 }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 10px; text-align: right;" class="no-margin">
            <p><b>PT DEXA ARFINDO PRATAMA</b></p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo, Kec. Wonocolo</p>
            <p>Surabaya, Jawa Timur (60297)</p>
            <p><b>dexa-arfindopratama.com</b></p>
        </div>
    </div>
</div>

<div class="content">
        <br><br><br>
        <p style="text-align: center; font-weight:bold; font-size: 15px;">INVOICE</p>
        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
            <tr>
                <td>Sales</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $do_mst->somst->sales->fc_salesname1 ?? '-' }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>    
                <td>NPWP</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $do_mst->somst->customer->fc_membernpwp_no ?? '-' }}</td>
                <td>Tanggal</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_releasedate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr class="">
                <td>Nomor</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->fc_invno }}</td>
                <td>Jatuh Tempo</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_agingdate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
        </table>

        <table class="table-lg table-center" style="margin-top: 15px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga (Rp)</th>
                <th>Diskon (Rp)</th>
                <th>Total (Rp)</th>
            </tr>

            @if(isset($do_dtl))
                @foreach ($do_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->invstore->stock->fc_namepack }}</td>
                        <td>{{ $item->fn_qty_do }}</td>
                        <td>{{ $item->fn_price }}</td>
                        <td>{{ $item->fn_disc }}</td>
                        <td>{{ $item->fn_value }}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif

        </table>

        <table style="width: 90%; border-collapse: collapse; margin: auto;">
            <tr class="pt-1">
                <td>Total</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">Rp. {{ number_format($inv_mst->fm_netto,0,',','.')}}</td>
                <td>Biaya Kirim</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format( $inv_mst->fm_servpay,0,',','.')}}</td>
            </tr>

            <tr>
                <td>Pajak</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($inv_mst->fm_tax,0,',','.')}}</td>
                <td>Biaya Materai</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. 0</td>
            </tr>
            <tr class="pb-1">
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 28%"></td>
                <td><b>Tagihan</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($inv_mst->fm_brutto,0,',','.')}}</td>
            </tr>
        </table>

        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
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
        </table>

        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always ">
            <br><br>
            <tr >
                <td style="width: 50% !important; text-align: left;">Dikirim Oleh,</td>
                <td style="width: 50% !important; text-align: right;">Diterima Oleh,</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;">PT DEXA ARFINDO PRATAMA</td>
                <td style="width: 50% !important; text-align: right;">{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="width: 50% !important; text-align: left;">(..................................................)</td>
                <td style="width: 50% !important; text-align: right;">(..................................................)</td>
            </tr>
        </table>
        
        <div class="container" id="so-pdf">
            <div class="footer" style="height: 100px">
                <div style="position: absolute; bottom: 0px; text-align: left; page-break-before:always page-break-after:always" class="no-margin">
                    <p><b>Syarat Pembayaran :</b></p>
                    <p>- Pembayaran harap di selesaikan dalam waktu 30 hari dari tanggal Faktur</p>
                    <p>- Pembayaran harap dilakukan dengan Giro Bilyet / Cross Cheque atau transfer ke bank kami.</p>
                    <p>&nbsp;&nbsp;Atas Nama : PT DEXA ARFINDO PRATAMA</p>
                    <p>&nbsp;&nbsp;Bank BCA kcp Rungkut Mapan</p>
                    <p>&nbsp;&nbsp;A/C 6750320030</p>
                    <p>- Pembayaran di anggap lunas apabila sudah CAIR</p>
                </div>
            </div>
        </div>
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