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
            <th width="30" style="font-weight: bold;">No. PO</th>
            <th width="30" style="font-weight: bold;">Tanggal</th>
            <th width="30" style="font-weight: bold;">Expired</th>
            <th width="30" style="font-weight: bold;">Operator</th>
            <th width="30" style="font-weight: bold;">Legal Status</th>
            <th width="30" style="font-weight: bold;">Nama Supplier</th>
            <th width="30" style="font-weight: bold;">Item</th>
            <th width="30" style="font-weight: bold;">Status</th>
            <th width="30" style="font-weight: bold;">Total</th>
        </tr>
    @php $i = 1; @endphp
    {{-- @dd($masterPo) --}}
    @foreach($masterPo as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_pono }}</td>
        <td>{{ $data->fd_podateinputuser }}</td>
        <td>{{ $data->fd_poexpired }}</td>
        <td>{{ $data->fc_userid }}</td>
        <td>{{ $data->supplier->fc_supplierlegalstatus }}</td>
        <td>{{ $data->supplier->fc_suppliername1 }}</td>
        <td>{{ $data->fn_podetail }}</td>
        @if ($data->fc_postatus == 'F')
                <td>Pemesanan</td>
            @elseif ($data->fc_postatus == 'P')
                <td>Pending</td>
            @elseif ($data->fc_postatus == 'L')
                <td>Lock</td>
            @elseif ($data->fc_postatus == 'S')
                <td>Terkirim</td>
            @elseif ($data->fc_postatus == 'CC')
                <td>Cancel</td>
            @elseif ($data->fc_postatus == 'CL')
                <td>Close</td>
            @else 
                <td>-</td>
        @endif
        
        <td>Rp. {{ number_format($data->fm_brutto,0,',','.')}}</td>
    </tr>
   
    @php $itemCount = count($data->podtl); @endphp
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
        @foreach ($data->podtl as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->fc_stockcode }}</td>
                <td>{{ $item->stock->fc_namelong ?? 'N/A' }}</td>
                <td>{{ $item->fn_po_qty }}</td>
                <td>{{ $item->fc_namepack }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

</body>

</html>
