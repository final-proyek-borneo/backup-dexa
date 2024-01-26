<html>

<head>
    <title>Kwitansi</title>
    <link href="https://www.dafontfree.net/embed/bHVjaWRhLWNvbnNvbGUtcmVndWxhciZkYXRhLzExL2wvNjAzODMvTHVjaWRhIENvbnNvbGUudHRm" rel="stylesheet" type="text/css" />
</head>
<style>
    @page {
        size: 8.5in 11in;
        margin: 40px 40px;
        font-family: 'lucida-console-regular', sans-serif;
    }

    * {
        font-family: 'lucida-console-regular', sans-serif;
    }

    .tp-1 td {
        padding: 9px 4px !important;
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

    .fw-bold {
        font-weight: bold;
        white-space: nowrap;
    }

    th,
    td {
        vertical-align: middle;
    }

    .table-center thead tr th,
    .table-center tbody tr td {
        text-align: center;
        padding: 3px;
    }

    .table-start thead tr th,
    .table-start tbody tr td {
        vertical-align: start;
        padding: 3px;
    }

    .table-center-start thead tr th {
        vertical-align: center;
        text-align: center;
    }

    .table-center-start tbody tr td {
        vertical-align: start;
    }

    .text-start {
        text-align: unset !important;
    }

    .pl-2 {
        padding-left: 75px;
    }

    .pl-1 {
        padding-left: 50px;
    }

    .pl-0 {
        padding-left: 25px;
    }

    .header {
        width: 100%;
    }

    .content {
        margin-top: 25px
    }

    .pt-1>* {
        padding-top: 15px;
    }

    .pb-1>* {
        padding-bottom: 15px;
    }

    /* font size*/
    p,
    label {
        font-size: 13px;
    }

    table {
        font-size: 13px !important;
    }

    table th {
        padding: 6px 4px;
        font-size: 13px;
        font-weight: regular;
        font-family: 'lucida-console-regular', sans-serif;
    }

    table td {
        padding: 6px 4px;
        font-size: 13px;
    }

    .table-header {
        font-size: 13px;
    }

    .table-lg td {
        font-size: 13px;
    }

    .table-xl td {
        font-size: 13px;
    }

    .div-lg p {
        font-size: 13px;
    }

    .footer p {
        font-size: 10px;
    }

    .table-lg,
    .table-lg th,
    .table-lg td {
        border: 2px solid black;
    }

    @media print {

        html,
        body {
            width: 8.5in;
            height: 11in;
            display: block;
            font-family: 'lucida-console-regular', sans-serif;
        }

        @page {
            size: 8.5in 11in;
        }
    }

    .kotak{
        border: 1px solid black;
        padding: 3px 8px 3px 8px;
    }
</style>

<body>
    <div class="container" id="print">
        <div class="header" style="height: 100px">
            <div style="position: absolute; left: 0; top: 0">
                <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
            </div>
            <div style="position: absolute; right: 0; top: 0; text-align: right;" class="no-margin">
                <p style="font-size: 14px;">PT DEXA ARFINDO PRATAMA</p>
                <p>Jl. Raya Jemursari No.329-331, Sidosermo,</p>
                <p>Kec. Wonocolo, Surabaya, Jawa Timur (60297)</p>
                <p>dexa-arfindopratama.com</p>
            </div>
        </div>
    </div>

    <div class="content" id="print">
        <p style="text-align: center; font-size: 18px; margin: 0; text-decoration: underline;">KUITANSI</p>
        <p style="text-align: center; margin: 0;">No. : {{ $inv_mst->fc_invno }}</p>

        <br>
        <table>
            <tbody>
                <tr>
                    <td>Sudah diterima dari</td>
                    <td>:</td>
                    @if($inv_mst->fc_invtype == 'SALES' || $inv_mst->fc_invtype == 'CPRR')
                    <td>{{ $inv_mst->customer->fc_membername1 }}</td>
                    @else
                    <td>{{ $inv_mst->supplier->fc_suppliername1 }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Banyaknya uang</td>
                    <td>:</td>
                    <td>{{ terbilang($inv_mst->fm_brutto) }} Rupiah</td>
                </tr>
                <tr>
                    <td>Untuk pembayaran</td>
                    <td>:</td>
                    <td>{{ $inv_mst->fv_description ?? '' }} No. Invoice: {{ $inv_mst->fc_invno }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always ">
            <br>
            <tr>
                <td style="width: 50% !important; text-align: left;">NO. CEK / GIRO :</td>
                <td style="width: 50% !important; text-align: right;">Surabaya,</td>
            </tr>
            <tr>
            <td style="width: 50% !important; text-align: left;">JUMLAH : <span class="kotak">Rp. {{ number_format($inv_mst->fm_brutto,0,',','.')}}</span></td>
                <td style="width: 100% !important; text-align: right;"></td>
            </tr>
            <br><br />
            <tr>
                <td style="width: 50% !important; text-align: left;"></td>
                <td style="width: 100% !important; text-align: right;">( {{ $nama_pj }} )</td>
            </tr>
        </table>
        <div>
</body>

</html>

<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "Minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
?>