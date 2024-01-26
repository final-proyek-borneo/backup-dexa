<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\MasterMenu;

class NoDocument {

    Public static function generate($tahun, $no_doc, $branch, $part = null, $divisioncode){
        $where_text = "fv_document = '$no_doc'";
        if(!empty($branch)){
            $where_text .= "and fc_branch = '$branch'"; 
        }

        if(!empty($part)){
            $where_text .= "and fv_part = '$part'";
        }

        $data = DB::select(DB::raw("
            SELECT CONCAT(
            fv_prefix, '$tahun', '$branch', '$divisioncode',                                                             
            REPEAT('0', fn_count3-( 4 + LENGTH(fv_prefix) + LENGTH(fn_docno + 1)) ),
                  fn_docno + 1) AS NomorIs 
            FROM t_nomor 
            WHERE $where_text
        "));
        return $data[0]->NomorIs;
    }

    public static function update($no_doc, $branch = null, $part = null){
        $where_text = "fv_document = '$no_doc'";
        if(!empty($branch)){
            $where_text .= "and fc_branch = '$branch'"; 
        }

        if(!empty($part)){
            $where_text .= "and fv_part = '$part'";
        }

        DB::select(DB::raw("
            update t_nomor set fn_docno = fn_docno + 1 
            where $where_text;
        
        "));
    }

}
?>
