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
            <th width="30" style="font-weight: bold;">No. Retur</th>
            <th width="30" style="font-weight: bold;">No. Surat Jalan</th>
            <th width="30" style="font-weight: bold;">Tanggal Retur</th>
            <th width="30" style="font-weight: bold;">Item</th>
            <th width="30" style="font-weight: bold;">Nominal</th>
        </tr>
    @php $i = 1; @endphp
    {{-- @dd($masterRetur) --}}
    @foreach($masterRetur as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_returno }}</td>
        <td>{{ $data->fc_dono }}</td>
        <td>{{ $data->fd_returdate }}</td>
        <td>{{ $data->fn_returdetail }}</td>
        <td>{{ $data->fm_brutto }}</td>
    </tr>
   
    <tr>
        <td>&nbsp;</td>
        <td style="font-weight: bold;">Katalog</td>
        <td style="font-weight: bold;">Nama Barang</td>
        <td style="font-weight: bold;">Batch</td>
        <td style="font-weight: bold;">Expired Date</td>
        <td style="font-weight: bold;">Jumlah</td>
        <td style="font-weight: bold;">Harga Satuan</td>
    </tr>
    @foreach($data->returdtl as $item)
    <tr>
        <td>&nbsp;</td>
        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
        <td>{{ $item->invstore->stock->fc_namelong }}</td>
        <td>{{ $item->fc_batch }}</td>
        <td>{{ \Carbon\Carbon::parse( $item->fd_expired )->isoFormat('D MMMM Y'); }}</td>
        <td>{{ $item->fn_returqty }} {{ $item->invstore->stock->fc_namepack }}</td>
        <td>Rp. {{ number_format($item->fn_price,0,',','.')}}</td>
    </tr>
    @endforeach
    
 
    @endforeach
    </tbody>
</table>

</body>

</html>
