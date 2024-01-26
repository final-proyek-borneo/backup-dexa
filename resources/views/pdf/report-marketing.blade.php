<html>

<head>
    <title>LAPORAN PROGRESS SALES ORDER</title>
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
    /* p,
    label {
        font-size: 13px;
    } */

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
        border: 1px solid black;
    }
</style>

<body>
    <div class="container" id="print">
        <div class="header" style="height: 100px">
            <div style="text-align: center;" class="no-margin">
                <p style="font-size: 18px;">LAPORAN PROGRESS SALES ORDER</p>
                @if ($fc_status == 'BT')
                <p style="font-size: 13px;">{{ 'Belum Terkirim' }}</p>
                @elseif ($fc_status == 'P')
                <p style="font-size: 13px;">{{ 'Partial' }}</p>
                @elseif ($fc_status == 'F')
                <p style="font-size: 13px;">{{ 'Full' }}</p>
                @else
                <p style="font-size: 13px;">{{ 'Semua Progress Barang' }}</p>
                @endif
                <p style="font-size: 13px;">Periode : {{\Carbon\Carbon::parse( $fd_sodatesysinput_start )->isoFormat('D MMMM Y');}} s/d {{\Carbon\Carbon::parse( $fd_sodatesysinput_end )->isoFormat('D MMMM Y');}}</p>
                <p style="font-size: 13px;">SALES : {{ $sales_profile ?? '-' }}</p>
                <p style="font-size: 13px;">CUSTOMER : {{ $membername ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="content" id="print">
        <table class="table-lg table-center" style="margin-bottom: 15px; border-collapse: collapse; width: 100%;" border="1">
            <tr>
                {{-- <th>NAMA SALES</th> --}}
                <th>TIPE SO</th>
                <th>TANGGAL SO</th>
                <th>NO. SO</th>
                <th>NAMA BARANG</th>
                <th>SO</th>
                <th>DO</th>
                <th>BAL</th>
                <th>KET. BAL</th>
            </tr>

            @if(isset($data))
            @foreach ($data as $item)
            <tr>
                {{-- <td>{{ $item->sales_profile }}</td> --}}
                <td>{{ $item->fc_sotype }}</td>
                <td>{{ \Carbon\Carbon::parse( $item->fd_sodatesysinput )->isoFormat('D MMMM Y'); }}</td>
                <td>{{ $item->fc_sono }}</td>
                <td>{{ $item->fc_namelong }}</td>
                <td>{{ $item->fn_so_qty }}</td>
                <td>{{ $item->fn_do_qty }}</td>
                <td>{{ $item->qty_kurang_kirim }}</td>
                <td>{{ $item->status_qty }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif
        </table>
    <div>
</body>

</html>