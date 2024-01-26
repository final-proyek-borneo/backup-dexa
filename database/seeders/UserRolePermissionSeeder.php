<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        DB::beginTransaction();
        try {

         

            //select role BASIC
            // $role = ModelsRole::findByName('SUPERADMIN');
            
            // // give permission
            // $role->givePermissionTo('Meta Data');
            // $role->givePermissionTo('Master Menu');
            // $role->givePermissionTo('Master User');
            // $role->givePermissionTo('Master Customer');
            // $role->givePermissionTo('Master Sales');
            // $role->givePermissionTo('Master Bank Acc');
            // $role->givePermissionTo('Master Brand');
            // $role->givePermissionTo('Master Stock');
            // $role->givePermissionTo('Sales Customer');
            // $role->givePermissionTo('Stock Customer');
            // $role->givePermissionTo('Stock Supplier');
            // $role->givePermissionTo('Daftar Gudang');
            // $role->givePermissionTo('Sales Order');
            // $role->givePermissionTo('Data Master');
            // $role->givePermissionTo('Daftar Sales Order');
            // $role->givePermissionTo('Surat Jalan');
            // $role->givePermissionTo('Daftar Surat Jalan');
            // $role->givePermissionTo('Konfirmasi Penerimaan');
            // $role->givePermissionTo('Daftar Invoice');
            // $role->givePermissionTo('Purchase Order');
            // $role->givePermissionTo('Penjualan');
            // $role->givePermissionTo('Pembelian');
            // $role->givePermissionTo('Daftar Purchase Order');
            // $role->givePermissionTo('BPB');
            // $role->givePermissionTo('Daftar BPB');
            // $role->givePermissionTo('Transit Barang');
            // $role->givePermissionTo('Daftar Transit Barang');
            // $role->givePermissionTo('Gudang');
            // $role->givePermissionTo('Persediaan Barang');
            // $role->givePermissionTo('Daftar Mutasi Barang');
            // $role->givePermissionTo('Mutasi Barang');
            // $role->givePermissionTo('Master CPRR');
            // $role->givePermissionTo('Master Role');
            // $role->givePermissionTo('CPRR Customer');

            // user dengan id 3 assignrole ke SUPERADMIN
            $user = User::find(3);
            $user->assignRole('SUPERADMIN');
            

            
            //make permission
            

            
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
