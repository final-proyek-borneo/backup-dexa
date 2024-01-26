<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\MasterMenu;

class App {

    public static function get_master_menu(){
        if(auth()->check() && !empty(session()->get('json_menu'))){
           $master_menu = MasterMenu::where('parent_id', '0')->whereIn('id', json_decode(Auth::user()->json_menu))->orderBy('index','asc')->get();
        }else{
            $master_menu = MasterMenu::where('parent_id', '0')->orderBy('index','asc')->get();
        }

        $prepared_master_menu = MasterMenu::orderBy('index','asc')->get();

        $array = [];
        foreach($master_menu as $key => $value){
            $array[$value->kategori][$key]['nama'] = $value->nama_menu;
            $array[$value->kategori][$key]['icon'] = $value->icon;
            $array[$value->kategori][$key]['link'] = $value->link;
            $array[$value->kategori][$key]['menu'] = $value->menu;
            $array[$value->kategori][$key]['submenu_parent'] = $value->submenu;

            $sub_menu = $prepared_master_menu->where('parent_id', $value->id);
            foreach($sub_menu as $value2){
                $array[$value2->kategori][$key]['submenu'][] = [
                    'nama' => $value2->nama_menu,
                    'icon' => $value2->icon,
                    'link' => $value2->link,
                    'menu' => $value2->menu,
                    'submenu' => $value2->submenu,
                ];
            }
        }

        return $array;
    }


    // public static function get_master_package(){
    //     return MasterPackage::all();
    // }
}
?>
