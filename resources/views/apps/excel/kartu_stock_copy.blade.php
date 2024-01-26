{{-- <!DOCTYPE html>
<html>
<head>
<style>
    body {
        padding: 20px;
    }
    table {
        border-collapse: collapse;
        width: 790px;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th rowspan="2" style="border: 2px solid black;">Range Waktu</th>
            <th rowspan="2" style="border: 2px solid black;">Nama Gudang</th>
            <th rowspan="2" style="border: 2px solid black;">Nama Stock + Katalog</th>
            <th colspan="3" style="border: 2px solid black;">Riwayat Inquiri</th> 
        </tr>
        <tr>
            <th style="border: 2px solid black;">Date</th>
            <th style="border: 2px solid black;">In/Out</th>
            <th style="border: 2px solid black;">Reference</th>
            <th style="border: 2px solid black;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kartu_stock as $stock)
        <tr>
            <td style="border: 2px solid black;">{{ $range_date }}</td>
            <td style="border: 2px solid black;">{{ $stock->warehouse->fc_rackname }}</td>
            <td style="border: 2px solid black;">{{ $stock->invstore->stock->fc_namelong}}</td>
            <td style="border: 2px solid black;">{{ $stock->fd_inqdate }}</td>
            <td style="border: 2px solid black;">{{ $stock->fn_in }} / {{ $stock->fn_out }}</td>
            <td style="border: 2px solid black;">{{ $stock->fc_docreference }}</td>
            <td style="border: 2px solid black;">{{ $stock->fv_description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tabel Kartu Stock</title>
<style>
  table {
    height: 108px;
    width: 1699px;
    border-collapse: collapse;
    border: 1px solid black;
  }
  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }
  th[style], td[style] {
    border: 2px solid black !important;
  }
</style>
</head>
<body>
<table>
  <tbody>
    <tr>
      <td colspan="8" style="text-align: center; font-size: 18px; font-weight: bold; border: 2px solid black;">{{ $range_date }}</td>
    </tr>
    @php
        $no = 1;
        $currentWarehouse = null;
    @endphp
    @foreach($kartu_stock as $stock)
    @if($stock->warehouse->fc_rackname !== $currentWarehouse)
    @php
        $currentWarehouse = $stock->warehouse->fc_rackname;
    @endphp
    <tr>
      <td rowspan="2" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">No</td>
      <td colspan="2" style="text-align: center; font-size: 18px; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">{{ $currentWarehouse }}</td>
      <td colspan="4" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Riwayat Inquiri</td>
      <td rowspan="2" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Keterangan</td>
    </tr>
    <tr>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Katalog</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Nama Stok</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Date</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">IN</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">OUT</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Reference</td>
    </tr>
    @endif
    <tr>
      <td style="border: 2px solid black;">{{ $no++ }}</td>
      <td style="border: 2px solid black;">{{ $stock->invstore->fc_stockcode }}</td>
      <td style="border: 2px solid black;">{{ $stock->invstore->stock->fc_namelong }}</td>
      <td style="border: 2px solid black;">{{ $stock->fd_inqdate }}</td>
      <td style="border: 2px solid black;">{{ $stock->fn_in }}</td>
      <td style="border: 2px solid black;">{{ $stock->fn_out }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_docreference }}</td>
      <td style="border: 2px solid black;">{{ $stock->fv_description }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>



