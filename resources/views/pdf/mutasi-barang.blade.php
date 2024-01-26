<html>

<head>
<title>Tanda Terima</title>
<link href="https://www.dafontfree.net/embed/bHVjaWRhLWNvbnNvbGUtcmVndWxhciZkYXRhLzExL2wvNjAzODMvTHVjaWRhIENvbnNvbGUudHRm" rel="stylesheet" type="text/css" />
</head>
<style>
    @page {
        margin: 40px;
        padding: 40px;
        font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
    }

    * {
        font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
    }

    p,
    label {
        font-size: 12px;
    }

    table {
        font-size: 12px!important;
    }

    table th {
        padding: 6px 4px;
        font-size: 12px;
        font-weight: regular;
        font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
    }

    table td {
        padding: 6px 4px;
        font-size: 12px!important;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 12px!important;
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
        font-size: 12px!important;
    }

    .table-xl td {
        font-size: 12px!important;
    }

    .div-lg p{
        font-size: 12px!important;
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

    .pt-1 > * {
        padding-top: 15px;
    }

    .pb-1 > *{
        padding-bottom: 15px;
    }

    .content p {
        font-size: 12px;
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
            font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
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
            <div style="position: absolute; right: 0; top: 0; text-align: right;" class="no-margin">
                <p style="font-size: 12px;">PT DEXA ARFINDO PRATAMA</p>
                <p>Jl. Raya Jemursari No.329-331, Sidosermo,</p>
                <p>Kec. Wonocolo, Surabaya, Jawa Timur (60297)</p>
                <p>dexa-arfindopratama.com</p>
            </div>
        </div>
    </div>
    <div class="content" id="print">
        <br>
        <p style="text-align: center; font-size: 14px;">TANDA TERIMA MUTASI</p>
        <table style="width: 92%; border-collapse: collapse; margin: auto;" class="no-space">
            <tr>
                <td>Tanggal</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">{{ \Carbon\Carbon::parse( $mutasi_mst->fd_date_byuser )->isoFormat('D MMMM Y'); }}</td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 28%"></td>
            </tr>
            <tr>
                <td>No. Mutasi</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="1">{{ $mutasi_mst->fc_mutationno }}</td>
                <td>Jenis Mutasi</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="1">{{ $mutasi_mst->fc_type_mutation }}</td>
            </tr>
            <tr>
                <td>No. SO</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="1">{{ $mutasi_mst->fc_sono }}</td>
                <td>Jenis SO</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="1">{{ $mutasi_mst->somst->fc_sotype }}</td>
            </tr>
        </table>

        <table style="width: 92%; border-collapse: collapse; margin: auto; margin-bottom:-15px;" class="no-space">
        <p style="font-size: 12px; margin-left: 2%">Lokasi Awal :</p>
            <tr>
                <td>{{ $mutasi_mst->warehouse_start->fc_rackname }}</td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
            </tr>
            <tr>
                <td style="width: 70%">{{ $mutasi_mst->warehouse_start->fc_warehouseaddress }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
            </tr>
        </table>

        <table style="width: 92%; border-collapse: collapse; margin: auto;" class="no-space">
        <p style="font-size: 12px; margin-left: 2%">Lokasi Tujuan :</p>
            <tr>
                <td>{{ $mutasi_mst->warehouse_destination->fc_rackname }}</td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
            </tr>
            <tr>
                <td style="width: 70%">{{ $mutasi_mst->warehouse_destination->fc_warehouseaddress }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 16%"></td>
            </tr>
        </table>

        <p style="font-size: 12px; margin-left: 5%">Detail Barang</p>
        <table class="table-lg table-center" style="margin-bottom: 25px; margin-top: 15px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Batch</th>
                <th>Expired Date</th>
                <th>Qty</th>
            </tr>

            @if(isset($mutasi_dtl))
                @foreach ($mutasi_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->fc_stockcode }}</td>
                        <td>{{ $item->stock->fc_namelong }}</td>
                        <td>{{ $item->stock->fc_namepack }}</td>
                        <td>{{ $item->invstore->fc_batch }}</td>
                        <td>{{ \Carbon\Carbon::parse( $item->invstore->fd_expired )->isoFormat('D MMMM Y'); }}</td>
                        <td>{{ $item->fn_qty }}</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif

        </table>

        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always ">
            <tr >
                <td style="width: 50% !important; text-align: left;">Telah diterima di,</td>
                <td style="width: 50% !important; text-align: right;">Telah dikirim dari,</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;">{{ $mutasi_mst->warehouse_destination->fc_rackname }}</td>
                <td style="width: 50% !important; text-align: right;">{{ $mutasi_mst->warehouse_start->fc_rackname }}</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;"><br><br></td>
                <td style="width: 50% !important; text-align: right;">            
                <br><br>
                <br><br>
                </td>
            </tr>
            <tr >
                <td style="width: 50% !important; text-align: left;">(..................)</td>
                <td style="width: 50% !important; text-align: right;">( {{ $nama_pj }} )</td>
            </tr>
        </table>
    <div>
</body>

</html>