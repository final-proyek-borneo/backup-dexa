<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tabel Rekap Stock</title>
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
        <td colspan="10" style="text-align: center; font-size: 18px; font-weight: bold; border: 2px solid black;">{{ $gudang['gudang_mst']->fc_rackname }}</td>
      </tr>
      <tr>
          <th width="10" style="border: 1px solid black;font-weight: bold;">Kode Barang</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Nama Barang</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Sebutan</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Brand</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Sub Group</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Tipe Stock</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Batch</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Expired Date</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Qty</th>
          <th width="30" style="border: 1px solid black;font-weight: bold;">Satuan</th>
      </tr>
      @if(isset($gudang['gudang_dtl']))
          @foreach ($gudang['gudang_dtl'] as $item)
              <tr>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_stockcode }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_namelong }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_nameshort }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_brand }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_subgroup }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_typestock2 }}</td>
                  <td style="border: 1px solid black;">{{ $item->fc_batch }}</td>
                  <td style="border: 1px solid black;">{{ \Carbon\Carbon::parse($item->fd_expired)->isoFormat('D MMMM Y') }}</td>
                  <td style="border: 1px solid black;">{{ $item->fn_quantity }}</td>
                  <td style="border: 1px solid black;">{{ optional($item->stock)->fc_namepack }}</td>
              </tr>
          @endforeach
      @else
          <tr>
              <td colspan="10" style="text-align: center; border: 1px solid black;">Data Not Found</td>
          </tr>
      @endif
    </tbody>
  </table>
  
</body>
</html>



