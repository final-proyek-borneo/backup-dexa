<html>

<head>
    <title>Purchase Order</title>
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

    #watermark {
        position: fixed;
        top: 25%;
        width: 100%;
        text-align: center;
        opacity: .5;
        transform-origin: 50% 50%;
        z-index: -1000;
    }
</style>

<body>
    <?php if($po_mst->fc_postatus == 'CL'): ?>
        <div id="watermark"><img src="{{ public_path('/assets/img/closed.png') }}" width="45%"></div>
    <?php elseif($po_mst->fc_postatus == 'CC'): ?>
        <div id="watermark"><img src="{{ public_path('/assets/img/cancelled.png') }}" width="45%"></div>
    <?php endif; ?>
    <main>
    <div class="container" id="po-pdf">
        <div class="header" style="height: 100px">
            <div style="position: absolute; left: 0; top: 0">
                <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
            </div>
            <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
                <p><b>Kepada :</b></p>
                <p>{{ $po_mst->supplier->fc_supplierlegalstatus }} {{ $po_mst->supplier-> fc_suppliername1 }}</p>
                <p>{{ $po_mst->supplier->fc_supplier_npwpaddress1 }}</p>
                <p>{{ $po_mst->supplier->fc_supplieremail1 }} / {{ $po_mst->supplier->fc_supplierphone1 }}
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
            <br><br><br><br>
            <p style="text-align: center; font-weight:bold; font-size:15px;">PURCHASE ORDER</p>
            <br>
            <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;" class="no-space">
                <tr>
                    <td>Nomor PO</td>
                    <td style="width: 5px">:</td>
                    <td style="width: 26%">{{ $po_mst->fc_pono }}</td>
                    <td></td>
                    <td style="width: 5px"></td>
                    <td style="width: 26%"></td>
                </tr>
                <tr class="pb-1">
                    <td>Tanggal PO</td>
                    <td style="width: 5px">:</td>
                    <td style="width: 30%">{{ \Carbon\Carbon::parse( $po_mst->fd_podateinputuser )->isoFormat('D MMMM Y'); }}</td>
                    <td>Tanggal Expired</td>
                    <td style="width: 5px">:</td>
                    <td style="width: 26%">{{ \Carbon\Carbon::parse( $po_mst->fd_poexpired )->isoFormat('D MMMM Y'); }}</td>
                </tr>
            </table>

            @if ($tampil_harga == 'T')
            <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Item</p>
            <table class="table-lg table-center" style="margin-bottom: 25px; margin-top: 15px; border-collapse: collapse; width: 100%" border="1">
                <tr>
                    <th>No.</th>
                    <th>Nomor Katalog</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>

                @if(isset($po_dtl))
                    @foreach ($po_dtl as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->fc_stockcode }}</td>
                            <td>{{ $item->stock->fc_namelong }}</td>
                            <td>{{ $item->fn_po_qty }}</td>
                            <td>{{ $item->fc_namepack }}</td>
                            <td>Rp. {{ number_format($item->fm_po_price,0,',','.')}}</td>
                            <td>Rp. {{ number_format($item->fn_po_value,0,',','.')}}</td>
                        </tr>
                    @endforeach

                @else
                <tr>
                    <td colspan="12" class="text-center">Data Not Found</td>
                </tr>
                @endif

            </table>
            @else
            <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">Item</p>
            <table class="table-lg table-center" style="margin-bottom: 25px; margin-top: 15px; border-collapse: collapse; width: 100%" border="1">
                <tr>
                    <th>No.</th>
                    <th>Nomor Katalog</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                </tr>

                @if(isset($po_dtl))
                    @foreach ($po_dtl as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->fc_stockcode }}</td>
                            <td>{{ $item->stock->fc_namelong }}</td>
                            <td>{{ $item->fn_po_qty }}</td>
                            <td>{{ $item->fc_namepack }}</td>
                        </tr>
                    @endforeach

                @else
                <tr>
                    <td colspan="12" class="text-center">Data Not Found</td>
                </tr>
                @endif

            </table>
            @endif

            <p style="font-size: .8rem; margin-left: 5%"><b>Catatan :</b> {{  $po_mst->fv_description ?? '-' }}</p>
            <p style="font-size: .8rem; margin-left: 5%"><b>Alamat Pengiriman :</b></p>
            <p style="font-size: .8rem; margin-left: 5%">{{  $po_mst->fc_address_loading1 }}</p>
            <p style="font-size: .8rem; margin-left: 5%">{{  $po_mst->fc_destination }}</p>

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
                <br>
            </table>
        <div>
    </main>
</body>

</html>
