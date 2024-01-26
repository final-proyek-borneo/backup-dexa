


<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        
    </style>
</head>

<body>

<table width="900">
    <tbody>
       
        <tr>
            <th width="10" style="font-weight: bold;">No</th>
            <th width="30" style="font-weight: bold;">No. SO</th>
            <th width="30" style="font-weight: bold;">Tanggal</th>
            <th width="30" style="font-weight: bold;">Expired</th>
            <th width="30" style="font-weight: bold;">Tipe</th>
            <th width="30" style="font-weight: bold;">Operator</th>
            <th width="30" style="font-weight: bold;">Customer</th>
            <th width="30" style="font-weight: bold;">Total</th>
        </tr>
    @php $i = 1; @endphp
    @foreach($masterCprr as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_sono }}</td>
        <td>{{ $data->fd_sodatesysinput }}</td>
        <td>{{ $data->fd_soexpired }}</td>
        <td>{{ $data->fc_sotype }}</td>
        <td>{{ $data->fc_userid }}</td>
        <td>{{ $data->customer->fc_membername1 }}</td>
        <td>Rp. {{ number_format($data->fm_brutto,0,',','.')}}</td>
    </tr>
   
    @php $itemCount = count($data->sodtl); @endphp
    <tr>
        <td>&nbsp;</td>
        <td style="font-weight: bold;">Item:{{ $itemCount }} </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        {{-- <td>&nbsp;</td> --}}
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="font-weight: bold;">Katalog</td>
        <td style="font-weight: bold;">Nama Barang</td>
        <td style="font-weight: bold;">Satuan</td>
        <td style="font-weight: bold;">Qty</td>
        <td style="font-weight: bold;">Terkirim</td>
        <td style="font-weight: bold;">Catatan</td>
        <td style="font-weight: bold;">Status</td>
    </tr>
    @foreach($data->sodtl as $item)
    <tr>
        <td>&nbsp;</td>
        <td>{{ $item->stock->fc_stockcode }}</td>
        <td>{{ $item->stock->fc_namelong }}</td>
        <td>{{ $item->stock->fc_namepack }}</td>
        <td>{{ $item->fn_so_qty }}</td>
        <td>{{ $item->fn_do_qty }}</td>
        <td>{{ $item->fv_description }}</td>
        <td>
            @if ($item->fn_so_qty !== $item->fn_do_qty)
                Pending
            @else
                Tuntas
            @endif
        </td>
    </tr>
    @endforeach
    @endforeach
    </tbody>
</table>

</body>

</html>
