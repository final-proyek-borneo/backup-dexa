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
      <td colspan="13" style="text-align: center; font-size: 18px; font-weight: bold; border: 2px solid black;">{{ $range_date }}</td>
    </tr>

    <tr>
      <td rowspan="2" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">No</td>
      <td colspan="7" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Informasi Stock</td>
      <td colspan="3" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Riwayat Inquiri</td>
      <td rowspan="2" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Keterangan</td>
      <td rowspan="2" style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Nama Gudang</td>
      
    </tr>
    <tr>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Katalog</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Nama Stok</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Brand</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Group</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Subgroup</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Tipe Stock 1</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Tipe Stock 2</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Date</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Balance</td>
      <td style="text-align: center; font-weight: bold; background-color: #CCCC99; border: 2px solid black;">Reference</td>
      

    </tr>

    @foreach($kartu_stock as $key => $stock)
    <tr>
      <td style="border: 2px solid black;">{{ $key + 1 }}</td>
      <td style="text-align: left; border: 2px solid black;">{{ strval($stock->fc_stockcode_substring) }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_namelong }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_brand }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_group }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_subgroup }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_typestock1 }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_typestock2 }}</td>
      <td style="border: 2px solid black;">{{ $stock->created_at }}</td>
      <td style="border: 2px solid black;">{{ $stock->fn_quantity }}</td>
      <td style="border: 2px solid black;">{{ $stock->fc_docreference }}</td>
      <td style="border: 2px solid black;">{{ $stock->fv_description }}</td>
      <td style="border: 2px solid black;">{{ $stock->warehouse_name }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
