<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Helpers\NoDocument;

use Carbon\Carbon;

use App\Helpers\ApiFormatter;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\StockCustomer;
use App\Models\StockSupplier;
use App\Models\Supplier;
use App\Models\TempSoMaster;
use App\Models\TransaksiType;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables;

class DataMasterController extends Controller
{
    public function get_data_all($model)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where('fc_branch', auth()->user()->fc_branch)->get();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_by_id($model, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return ApiFormatter::getResponse($data);
    }

    public function get_data_where_field_id_first_so_khusus($model, $where_field, $id)
    {
        // decode id
        $fc_membercode = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first()
            ->fc_membercode;
        $fc_stockcode = base64_decode($id);
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $fc_stockcode)->where('fc_membercode', $fc_membercode)->first();
        return ApiFormatter::getResponse($data);
        // dd($data);
    }

    public function get_data_where_field_id_first($model, $where_field, $id)
    {
        // decode id
        $fc_stockcode = base64_decode($id);
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $fc_stockcode)->first();
        return ApiFormatter::getResponse($data);
        // dd($data);
    }

    public function get_data_where_field_id_first_customer($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::with(['stock.namepack'])->where($where_field, $id)->first();
        return ApiFormatter::getResponse($data);
        // dd($data);
    }

    public function get_data_where_field_id_get($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return ApiFormatter::getResponse($data);
    }
    #================ DATA =====================#
    public function data_brand()
    {
        $data = Brand::select('fc_brand')->groupBy('fc_brand')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_group_by_brand(request $request)
    {
        $data = Brand::select('fc_group')->where('fc_brand', $request->fc_brand)->groupBy('fc_group')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_subgroup_by_group(request $request)
    {
        $data = Brand::select('fc_subgroup')->where('fc_group', $request->fc_group)->groupBy('fc_subgroup')->get();
        return ApiFormatter::getResponse($data);
    }

    public function data_stock_by_primary($stockcode, $barcode)
    {
        $data = Stock::where(['fc_stockcode' => $stockcode, 'fc_barcode' => $barcode])->where('fc_branch', auth()->user()->fc_branch)->first();
        return ApiFormatter::getResponse($data);
    }

    public function data_customer_first($fc_membercode)
    {
        $data = Customer::with('member_tax_code', 'member_typebranch', 'member_type_business', 'member_legal_status')->where('fc_membercode', $fc_membercode)->first();
        return ApiFormatter::getResponse($data);
    }

    public function data_warehouse_first($fc_warehousecode)
    {
        $data = Warehouse::with('branch')->where('fc_warehousecode', $fc_warehousecode)->first();
        return ApiFormatter::getResponse($data);
    }

    public function generate_no_document(request $request)
    {
        $data = NoDocument::generate(Carbon::now()->format('Y'), $request->fv_document, $request->fc_branch, $request->fv_part, $request->fc_divisioncode);
        return ApiFormatter::getResponse($data);
    }


    #================ DATATABLES ===============#

    public function get_data_all_table($model)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::all();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_by_id_table($model, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_where_field_id_get_table($model, $where_field, $id)
    {
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function get_data_customer_so_datatables($fc_branch)
    {
        $data = Customer::with('member_type_business', 'member_typebranch', 'member_legal_status')->where('fc_branch', $fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_stock_so_datatables()
    {
        $data = Stock::with('namepack')->where('fc_branch', auth()->user()->fc_branch)->orderBy('fc_nameshort', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_stock_customer_so_datatables(Request $request) {
        $fc_membercode = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first()
            ->fc_membercode;

        $data = StockCustomer::with(['stock.namepack'])
            ->where('fc_membercode', $fc_membercode)
            ->get();

        $formattedData = [];
        $rowIndex = 0;

        foreach ($data as $row) {
            $formattedRow = $row->stock;
            $formattedRow['fm_price_customer'] = $row->fm_price_customer;
            $formattedRow['DT_RowIndex'] = ++$rowIndex;
            $formattedData[] = $formattedRow;
        }

        return DataTables::of($formattedData)
            ->addIndexColumn()
            ->make(true);
    }
    

    public function get_data_stock_po_datatables()
    {
        $data = Stock::with('namepack')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->orderBy('fc_nameshort', 'asc')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_stock_supplier_po_datatables($fc_suppliercode){
        // decode
        $fc_suppliercode_decode = base64_decode($fc_suppliercode);
        $data = StockSupplier::with('supplier', 'stock.namepack')->where('fc_suppliercode', $fc_suppliercode_decode)->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function data_supplier_first($fc_suppliercode){
        $data = Supplier::with('supplier_tax_code', 'supplier_typebranch', 'supplier_type_business', 'supplier_legal_status')->where('fc_suppliercode', $fc_suppliercode)->first();
        return ApiFormatter::getResponse($data);
    }

    public function getCustomer(){
        $data = Customer::with('user')->where('fc_branch', auth()->user()->fc_branch)->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();
        return ApiFormatter::getResponse($data);
    }
}
