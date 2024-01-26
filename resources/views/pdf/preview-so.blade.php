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
</style>

<body>
<div class="container" id="so-pdf">
    <div class="header" style="height: 100px">
        <div style="position: absolute; left: 0; top: 0">
            <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
        </div>
        <div style="position: absolute; right: 0; top: 10px; text-align: right;" class="no-margin">
            <p><b>PT DEXA ARFINDO PRATAMA</b></p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo, Kec. Wonocolo</p>
            <p>Surabaya, Jawa Timur (60297)</p>
            <p><b>dexa-arfindopratama.com</b></p>
        </div>
    </div>

    <div class="content">
        <p style="text-align: center; font-weight:bold; font-size:15px;">SALES ORDER</p>

        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
            <tr class="tp-1 tb-1">
                <td>Tanggal SO</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="3">{{ \Carbon\Carbon::parse( $so_master->created_at )->isoFormat('D MMMM Y'); }}</td>
                <td>Sales</td>
                <td style="width: 5px">:</td>
                <td>{{ $so_master->sales->fc_salesname1 }}</td>
            </tr>
        </table>

        <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Customer</p>
        <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;" class="no-space">
            <tr>
                <td>NPWP</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">{{ $so_master->customer->fc_membernpwp_no ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%" colspan="2">{{ $so_master->customer->fc_membername1 }}</td>
            </tr>
            <tr>
                <td>Tipe Bisnis</td>
                <td style="width: 5px">:</td>
                <td>{{ $so_master->customer->fc_membertypebusiness }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td style="width: 5px">:</td>
                <td style="width: 48%">{{ $so_master->customer->fc_memberaddress1 }}</td>
            </tr>
            <tr class="pb-1">
                <td>Alamat Tujuan</td>
                <td style="width: 5px">:</td>
                <td style="width: 48%">{{ $so_master->customer->fc_memberaddress_loading1 }}</td>
                <td></td><td></td><td></td>
            </tr>
        </table>

        <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Pemesanan Barang</p>
        <table class="table-lg table-center" style="margin-bottom: 35px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Bonus</th>
            </tr>

            @if(isset($so_detail))
                @foreach ($so_detail as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->stock->fc_stockcode}}</td>
                        <td>{{ $item->stock->fc_namelong}}</td>
                        <td>{{ $item->stock->fc_namepack}}</td>
                        <td>{{ $item->fn_so_qty}}</td>
                        <td>{{ $item->fn_so_bonusqty}}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="9" class="text-center">Data Not Found</td>
            </tr>
            @endif

        </table>

        <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Metode Pembayaran</p>
        <table class="table-lg table-center" style="margin-bottom: 35px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>Metode</th>
                <th>Nominal (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>

            @if (isset($so_payment))
                @foreach ($so_payment as $item)
                    <tr>
                        <td>{{ $item->transaksitype->fv_description }}</td>
                        <td>{{ number_format($item->fm_valuepayment,0,',','.')}}</td>
                        <td>{{ \Carbon\Carbon::parse( $item->fd_paymentdate )->isoFormat('D MMMM Y'); }}</td>
                        <td>{{ $item->fc_description }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">Data Not Found</td>
                </tr>
            @endif
        </table>
    <div>
</div>
</body>

</html>
