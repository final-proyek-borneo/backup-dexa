<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master BPB</title>
</head>
<body>
    {{-- table --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. BPB</th>
                <th>Tanggal</th>
                <th>Operator</th>
                <th>Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="10" style="font-weight: bold;">No</th>
                <th width="30" style="font-weight: bold;">No. BPB</th>
                <th width="30" style="font-weight: bold;">No. Surat Jalan</th>
                <th width="30" style="font-weight: bold;">No. PO</th>
                <th width="30" style="font-weight: bold;">Legal Status</th>
                <th width="30" style="font-weight: bold;">Nama Supplier</th>
                <th width="30" style="font-weight: bold;">Tanggal Diterima</th>
                <th width="30" style="font-weight: bold;">Status</th>
                <th width="30" style="font-weight: bold;">Item</th>
            </tr>
        @php $i = 1; @endphp
        {{-- @dd($masterBpb) --}}
        @foreach($masterBpb as $data)
      
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $data->fc_rono }}</td>
            <td>{{ $data->fc_sjno }}</td>
            <td>{{ $data->fc_pono }}</td>
            <td>{{ $data->pomst->supplier->fc_supplierlegalstatus }}</td>
            <td>{{ $data->pomst->supplier->fc_suppliername1 }}</td>
            <td>{{ $data->pomst->supplier->fc_suppliername1 }}</td>
            <td>{{ $data->fd_roarivaldate }}</td>
            @if ($data->fc_rostatus == 'P')
                <td>Terbayar</td>
                @else
                <td>Diterima</td>
            @endif
            <td>{{ $data->fn_rodetail }}</td>
        </tr>
       <br>
        <tr>
            <th>No.</th>
            <th>Nomor Katalog</th>
            <th>Nama Produk</th>
            <th>Batch</th>
            <th>Exp. Date</th>
            <th>Qty</th>
            <th>Unity</th>
        </tr>

            @foreach ($data->rodtl as $item)
                <tr>
                    <td>&nbsp;</td>
                    <td>{{ $item->fc_stockcode }}</td>
                    <td>{{ $item->invstore->stock->fc_namelong }}</td>
                    <td>{{ $item->fc_batch }}</td>
                    <td>{{ $item->fd_expired_date }}</td>
                    <td>{{ $item->fn_qty_ro }}</td>
                    <td>{{ $item->fc_namepack }}</td>
                </tr>
            @endforeach
     
        @endforeach
        </tbody>
</body>
</html>