<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\MasterMenu;
use BaconQrCode\Encoder\QrCode;

class Barcode { 
    public function generateQRCodePDF($fc_barcode, $count, $fd_expired_date, $fc_batch)
    {

        $fc_barcode_decode = base64_decode($fc_barcode);
        $fc_batch_decode = base64_decode($fc_batch);
        $fd_expired_date_decode = base64_decode($fd_expired_date);
        $count_decode = base64_decode($count);
        $t_nomor = DB::table('t_nomor')
            ->where('fv_document', 'BATCH')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first();

            // dd($fc_batch);

        $vBatch = $fc_batch_decode  . str_repeat('0', $t_nomor->fn_count3 - strlen($fc_batch_decode));

        $kode_qr = $fc_barcode_decode . $vBatch . date("dmY", strtotime($fd_expired_date_decode));

        return $kode_qr;
    }
}
?>
