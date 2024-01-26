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
            <th width="30" style="font-weight: bold;">No. Surat Jalan</th>
            <th width="30" style="font-weight: bold;">Tanggal Surat Jalan</th>
            <th width="30" style="font-weight: bold;">Customer</th>
            <th width="30" style="font-weight: bold;">Item</th>
            <th width="30" style="font-weight: bold;">Status</th>
        </tr>
    @php $i = 1; @endphp
    {{-- @dd($masterRetur) --}}
    @foreach($masterSuratJalan as $data)
  
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $data->fc_dono }}</td>
        <td>{{ $data->fd_dodate }}</td>
        <td>{{ $data->somst->customer->fc_membername1 }}</td>
        <td>{{ $data->fn_dodetail }}</td>
        <td>{{ $data->fn_dodetail }}</td>
        @if ($data->fc_dostatus == 'D')
            <td>Pengiriman</td>
        @elseif ($data->fc_dostatus == 'R')
            <td>Terbayar</td>
        @elseif($data->fc_dostatus == 'CC')
            <td>Cancel</td>
        @elseif($data->fc_dostatus == 'L')
             <td>Lock</td>
        @else
          <td>Diterima</td>
        @endif
    </tr>
   <br>
    <tr>
        <td>&nbsp;</td>
        <td style="font-weight: bold;">Katalog</td>
        <td style="font-weight: bold;">Nama Barang</td>
        <td style="font-weight: bold;">Batch</td>
        <td style="font-weight: bold;">Expired Date</td>
        <td style="font-weight: bold;">Jumlah</td>
        <td style="font-weight: bold;">Harga Satuan</td>
    </tr>
    @foreach($data->dodtl as $item)
    <tr>
        <td>&nbsp;</td>
        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
        <td>{{ $item->invstore->stock->fc_namelong }}</td>
        <td>{{ $item->fc_batch }}</td>
        <td>{{ \Carbon\Carbon::parse( $item->fd_expired )->isoFormat('D MMMM Y'); }}</td>
        <td>{{ $item->fn_qty_do }} {{ $item->invstore->stock->fc_namepack }}</td>
    </tr>
    @endforeach
    
 
    @endforeach
    </tbody>
</table>

</body>

</html>
