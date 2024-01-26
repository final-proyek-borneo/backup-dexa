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
            <th width="30" style="font-weight: bold;">No. Mutasi</th>
            <th width="30" style="font-weight: bold;">No. SO</th>
            <th width="30" style="font-weight: bold;">Tanggal</th>
            <th width="30" style="font-weight: bold;">Lokasi Awal</th>
            <th width="30" style="font-weight: bold;">Lokasi Tujuan</th>
            <th width="30" style="font-weight: bold;">Status</th>
            <th width="30" style="font-weight: bold;">Item</th>
        </tr>
    @php $i = 1; @endphp
    @foreach($masterMutasi as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_mutationno }}</td>
        <td>{{ $data->fc_sono }}</td>
        <td>{{ $data->fd_date_byuser }}</td>
        <td>{{ $data->warehouse_start->fc_rackname }}</td>
        <td>{{ $data->warehouse_destination->fc_rackname }}</td>
        @if ($data->fc_statusmutasi == 'P')
          <td>Proses</td>
            @else
          <td>Terlaksana</td>
        @endif
        <td>{{ $data->fn_detailitem }}</td>
    </tr>
   
    <tr>
        <td>&nbsp;</td>
        <td style="font-weight: bold;">Katalog</td>
        <td style="font-weight: bold;">Nama Barang</td>
        <td style="font-weight: bold;">Batch</td>
        <td style="font-weight: bold;">Satuan</td>
        <td style="font-weight: bold;">Qty</td>
    </tr>
    @foreach($data->mutasidtl as $item)
    <tr>
        <td>&nbsp;</td>
        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
        <td>{{ $item->invstore->stock->fc_namelong }}</td>
        <td>{{ $item->invstore->fc_batch }}</td>
        <td>{{ $item->invstore->stock->fc_namepack }}</td>
        <td>{{ $item->fn_qty }}</td>
    </tr>
    @endforeach
    
 
    @endforeach
    </tbody>
</table>

</body>

</html>
