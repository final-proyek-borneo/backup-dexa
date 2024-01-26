<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Apps\KasBonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LandingPageController@index');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');


Route::prefix('login')->group(function () {
    Route::get('/', 'LoginController@index')->name('login');
});

Route::prefix('master')->group(function () {
    Route::get('/get-data-all/{model}', 'DataMasterController@get_data_all');
    Route::get('/get-data-by-id/{model}/{id}', 'DataMasterController@get_data_by_id');
    Route::get('/get-data-where-field-id-first/{model}/{where_field}/{id}', 'DataMasterController@get_data_where_field_id_first');
    Route::get('/get-data-where-field-id-first-so-khusus/{model}/{where_field}/{id}', 'DataMasterController@get_data_where_field_id_first_so_khusus');
    Route::get('/get-data-where-field-id-first_customer/{model}/{where_field}/{id}', 'DataMasterController@get_data_where_field_id_first_customer');
    Route::get('/get-data-where-field-id-get/{model}/{where_field}/{id}', 'DataMasterController@get_data_where_field_id_get');

    Route::get('/get-data-all-table/{model}', 'DataMasterController@get_data_all_table');
    Route::get('/get-data-by-id-table/{model}/{id}', 'DataMasterController@get_data_by_id_table');
    Route::get('/get-data-where-field-id-get-table/{model}/{where_field}/{id}', 'DataMasterController@get_data_where_field_id_get_table');
    Route::get('/get-data/user-from-customer', 'DataMasterController@getCustomer');

    Route::get('/data-brand', 'DataMasterController@data_brand');
    Route::get('/data-group-by-brand', 'DataMasterController@data_group_by_brand');
    Route::get('/data-subgroup-by-group', 'DataMasterController@data_subgroup_by_group');
    Route::get('/data-stock-by-primary/{stockcode}/{barcode}', 'DataMasterController@data_stock_by_primary');
    Route::get('/data-customer-first/{fc_membercode}', 'DataMasterController@data_customer_first');
    Route::get('/data-warehouse-first/{fc_warehousecode}', 'DataMasterController@data_warehouse_first');
    Route::get('/data-supplier-first/{fc_suppliercode}', 'DataMasterController@data_supplier_first');
    Route::get('/generate-no-document', 'DataMasterController@generate_no_document');

    Route::get('/get-data-customer-so-datatables/{fc_branch}', 'DataMasterController@get_data_customer_so_datatables');
    Route::get('/get-data-stock-so-datatables', 'DataMasterController@get_data_stock_so_datatables');
    Route::get('/get-data-stock_customer-so-datatables', 'DataMasterController@get_data_stock_customer_so_datatables');
    Route::get('/get-data-stock-po-datatables', 'DataMasterController@get_data_stock_po_datatables');
    Route::get('/get-data-stock_supplier-po-datatables/{fc_suppliercode}', 'DataMasterController@get_data_stock_supplier_po_datatables');
});

Route::group(['middleware' => ['cek_login']], function () {
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/datatable/{fitur}', 'DashboardController@datatable');
    Route::get('/view-all-notif', 'DashboardController@view_all_notif');
    Route::post('/reading-notification-click', 'Apps\NotifikasiController@handleNotificationClick');
    Route::get('/fitur/search-menu', 'DashboardController@search_menu')->name('search-menu');

    //CHANGE PASSWORDs
    Route::prefix('change-password')->group(function () {
        Route::get('/', 'LoginController@change_password');
        Route::post('/action-change-password', 'LoginController@action_change_password');
    });

    Route::prefix('data-master')->group(function () {
        Route::prefix('meta-data')->group(function () {
            Route::get('/', 'DataMaster\MetaDataController@index');
            Route::get('/detail/{fc_trx}/{fc_kode}', 'DataMaster\MetaDataController@detail');
            Route::get('/datatables', 'DataMaster\MetaDataController@datatables');
            Route::post('/store-transaksi', 'DataMaster\MetaDataController@add_transaksi_type');
            Route::put('/store-update', 'DataMaster\MetaDataController@store_update');
            Route::delete('/delete/{id}', 'DataMaster\MetaDataController@delete');
        });

        Route::prefix('master-menu')->group(function () {
            Route::get('/', 'Settings\SettingMenuController@index');
            Route::get('/detail/{id}', 'Settings\SettingMenuController@detail');
            Route::get('/datatables', 'Settings\SettingMenuController@datatables');
            Route::post('/store-update', 'Settings\SettingMenuController@store_update');
            Route::delete('/delete/{id}', 'Settings\SettingMenuController@delete');
        });

        Route::prefix('master-role')->group(function () {
            Route::get('/', 'DataMaster\MasterRoleController@index');
            Route::get('/datatable', 'DataMaster\MasterRoleController@datatable');
            Route::post('/create', 'DataMaster\MasterRoleController@create');
            Route::get('/edit/{id}', 'DataMaster\MasterRoleController@edit');
            Route::put('/update/{id}', 'DataMaster\MasterRoleController@update');
            Route::delete('/destroy/{id}', 'DataMaster\MasterRoleController@destroy');
        });

        Route::prefix('master-user')->group(function () {
            Route::get('/', 'DataMaster\MasterUserController@index');
            Route::get('/detail/{fc_userid}/{fc_username}/{id}', 'DataMaster\MasterUserController@detail');
            Route::get('/datatables', 'DataMaster\MasterUserController@datatables');
            Route::post('/store-update', 'DataMaster\MasterUserController@store_update');
            Route::delete('/delete/{fc_userid}/{fc_username}/{id}', 'DataMaster\MasterUserController@delete');
            Route::get('/get-role', 'DataMaster\MasterUserController@getAllRole');
            Route::get('/reset-password/{fc_username}', 'DataMaster\MasterUserController@reset_password');
            // Route::get('/add-menu/{id}','Settings\MasterUserController@add_menu');
        });

        Route::prefix('master-customer')->group(function () {
            Route::get('/', 'DataMaster\CustomerController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_membercode}', 'DataMaster\CustomerController@detail');
            Route::get('/datatables', 'DataMaster\CustomerController@datatables');
            Route::post('/store-update', 'DataMaster\CustomerController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_membercode}', 'DataMaster\CustomerController@delete');
        });

        Route::prefix('master-supplier')->group(function () {
            Route::get('/', 'DataMaster\SupplierController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_suppliercode}', 'DataMaster\SupplierController@detail');
            Route::get('/datatables', 'DataMaster\SupplierController@datatables');
            Route::post('/store-update', 'DataMaster\SupplierController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_suppliercode}', 'DataMaster\SupplierController@delete');
        });

        Route::prefix('master-sales')->group(function () {
            Route::get('/', 'DataMaster\SalesController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_salescode}', 'DataMaster\SalesController@detail');
            Route::get('/datatables', 'DataMaster\SalesController@datatables');
            Route::post('/store-update', 'DataMaster\SalesController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_salescode}', 'DataMaster\SalesController@delete');
        });

        Route::prefix('master-bank-acc')->group(function () {
            Route::get('/', 'DataMaster\MasterBankAccController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_bankcode}/{id}', 'DataMaster\MasterBankAccController@detail');
            Route::get('/datatables', 'DataMaster\MasterBankAccController@datatables');
            Route::post('/store-update', 'DataMaster\MasterBankAccController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_bankcode}', 'DataMaster\MasterBankAccController@delete');
        });

        Route::prefix('master-brand')->group(function () {
            Route::get('/', 'DataMaster\MasterBrandController@index');
            Route::get('/detail/{id}', 'DataMaster\MasterBrandController@detail');
            Route::get('/datatables', 'DataMaster\MasterBrandController@datatables');
            Route::post('/store-update', 'DataMaster\MasterBrandController@store_update');
            Route::delete('/delete/{id}', 'DataMaster\MasterBrandController@delete');
        });

        Route::prefix('master-stock')->group(function () {
            Route::get('/', 'DataMaster\MasterStockController@index');
            Route::get('/detail/{fc_stockcode}/{fc_barcode}', 'DataMaster\MasterStockController@detail');
            Route::get('/datatables', 'DataMaster\MasterStockController@datatables');
            Route::post('/store-update', 'DataMaster\MasterStockController@store_update');
            Route::delete('/delete/{fc_stockcode}/{fc_barcode}', 'DataMaster\MasterStockController@delete');
            Route::put('/hold/{fc_barcode}', 'DataMaster\MasterStockController@hold');
            Route::put('/unhold/{fc_barcode}', 'DataMaster\MasterStockController@unhold');
        });

        Route::prefix('master-cprr')->group(function () {
            Route::get('/', 'DataMaster\MasterCprrController@index');
            Route::get('/detail/{id}', 'DataMaster\MasterCprrController@detail');
            Route::get('/datatables', 'DataMaster\MasterCprrController@datatables');
            Route::get('/get-data/edit', 'DataMaster\MasterCprrController@edit');
            Route::post('/store-update', 'DataMaster\MasterCprrController@store_update');
            Route::put('/update', 'DataMaster\MasterCprrController@update');
            Route::delete('/delete/{fc_cprrcode}', 'DataMaster\MasterCprrController@delete');
        });

        Route::prefix('master-warehouse')->group(function () {
            Route::get('/', 'DataMaster\MasterWarehouseController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{fc_warehousecode}', 'DataMaster\MasterWarehouseController@detail');
            Route::get('/datatables', 'DataMaster\MasterWarehouseController@datatables');
            Route::post('/add-warehouse', 'DataMaster\MasterWarehouseController@add_warehouse');
            Route::post('/store-update', 'DataMaster\MasterWarehouseController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{fc_warehousecode}', 'DataMaster\MasterWarehouseController@delete');
        });

        Route::prefix('sales-customer')->group(function () {
            Route::get('/', 'DataMaster\SalesCustomerController@index');
            Route::get('/detail/customer/{fc_salescode}', 'DataMaster\SalesCustomerController@detailSalesCustomer');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{salescode}/{membercode}', 'DataMaster\SalesCustomerController@detail');
            Route::get('/datatables', 'DataMaster\SalesCustomerController@datatables');
            Route::get('/datatables/customer/{fc_salescode}', 'DataMaster\SalesCustomerController@detaillDatatables');
            Route::post('/store-update', 'DataMaster\SalesCustomerController@store_update');
            Route::post('/create-customer/{fc_salescode}', 'DataMaster\SalesCustomerController@createCustomer');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{salescode}/{membercode}', 'DataMaster\SalesCustomerController@delete');
            Route::delete('/delete/customer/{fc_membercode}/{fc_salescode}', 'DataMaster\SalesCustomerController@deleteCustomer');
        });

        Route::prefix('stock-customer')->group(function () {
            Route::get('/', 'DataMaster\StockCustomerController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}', 'DataMaster\StockCustomerController@detail');
            Route::get('/datatables', 'DataMaster\StockCustomerController@datatables');
            Route::post('/store-update', 'DataMaster\StockCustomerController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}', 'DataMaster\StockCustomerController@delete');
        });

        Route::prefix('cprr-customer')->group(function () {
            Route::get('/', 'DataMaster\CprrCustomerController@index');
            Route::get('/getall', 'DataMaster\CprrCustomerController@getAll');
            Route::get('/datatables', 'DataMaster\CprrCustomerController@datatables');
            Route::get('/get/{fc_cprrcode}', 'DataMaster\CprrCustomerController@get');
            Route::get('/detail/{fc_membercode}', 'DataMaster\CprrCustomerController@detailView');
            Route::get('/{id}', 'DataMaster\CprrCustomerController@detail');
            Route::get('/datatables/{fc_membercode}', 'DataMaster\CprrCustomerController@datatables_detail');
            Route::post('/store-update', 'DataMaster\CprrCustomerController@store_update');
            Route::delete('/delete/{id}', 'DataMaster\CprrCustomerController@delete');
        });

        Route::prefix('stock-supplier')->group(function () {
            Route::get('/', 'DataMaster\StockSupplierController@index');
            Route::get('/detail/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}', 'DataMaster\StockSupplierController@detail');
            Route::get('/datatables', 'DataMaster\StockSupplierController@datatables');
            Route::post('/store-update', 'DataMaster\StockSupplierController@store_update');
            Route::delete('/delete/{fc_divisioncode}/{fc_branch}/{stockcode}/{fc_barcode}/{membercode}', 'DataMaster\StockSupplierController@delete');
        });
    });

    Route::prefix('apps')->group(function () {

        Route::prefix('master-sales-order')->group(function () {
            Route::get('/', 'Apps\MasterSalesOrderController@index');
            Route::get('/detail/{fc_sono}', 'Apps\MasterSalesOrderController@detail');
            Route::get('/datatables/{fc_sostatus}', 'Apps\MasterSalesOrderController@datatables');
            Route::get('/datatables-so-detail', 'Apps\MasterSalesOrderController@datatables_so_detail');
            Route::get('/datatables-so-payment', 'Apps\MasterSalesOrderController@datatables_so_payment');
            Route::put('/close', 'Apps\MasterSalesOrderController@close_so');
            Route::put('/cancel_so', 'Apps\MasterSalesOrderController@cancel_so');

            Route::post('/pdf', 'Apps\MasterSalesOrderController@pdf');
            Route::get('/get_pdf/{fc_dono}/{fc_sono}/{nama_pj}', 'Apps\MasterSalesOrderController@get_pdf');
            Route::post('/export-excel/{status}', 'Apps\MasterSalesOrderController@export_excel');
        });

        Route::prefix('daftar-cprr')->group(function () {
            Route::get('/', 'Apps\DaftarCprrController@index');
            Route::get('/datatables/{fc_sostatus}', 'Apps\DaftarCprrController@datatables');
            Route::get('/detail/{fc_sono}', 'Apps\DaftarCprrController@detail');
            Route::post('/export-excel/{status}', 'Apps\DaftarCprrController@export_excel');
            Route::put('/cancel_so', 'Apps\DaftarCprrController@cancel_so');
        });

        Route::prefix('daftar-memo-internal')->group(function () {
            Route::get('/', 'Apps\DaftarMemoInternalController@index');
            Route::get('/datatables/{fc_sostatus}', 'Apps\DaftarMemoInternalController@datatables');
            Route::get('/detail/{fc_sono}', 'Apps\DaftarMemoInternalController@detail');
            Route::put('/cancel_so', 'Apps\DaftarMemoInternalController@cancel_so');
            Route::post('/export-excel/{status}', 'Apps\DaftarMemoInternalController@export_excel');
        });

        Route::prefix('sales-order')->group(function () {
            Route::get('/', 'Apps\SalesOrderController@index');
            Route::get('/datatables', 'Apps\SalesOrderController@datatables');
            Route::post('/store-update', 'Apps\SalesOrderController@store_update');
            Route::delete('/delete', 'Apps\SalesOrderController@delete');

            Route::prefix('detail')->group(function () {
                Route::get('/', 'Apps\SalesOrderDetailController@index')->name('so.detail');
                Route::get('/datatables', 'Apps\SalesOrderDetailController@datatables');
                Route::get('/datatables-inventory', 'Apps\SalesOrderDetailController@datatables_inventory');
                Route::post('/store-update', 'Apps\SalesOrderDetailController@store_update');
                Route::put('/catatan-save', 'Apps\SalesOrderDetailController@save_catatan');
                Route::delete('/delete/{fc_sono}/{fn_sorownum}', 'Apps\SalesOrderDetailController@delete');

                Route::prefix('payment')->group(function () {
                    Route::get('/', 'Apps\PaymentController@index')->name('payment.index');
                    Route::get('/getdata/{fc_kode}', 'Apps\PaymentController@getData');
                    Route::get('/datatables', 'Apps\PaymentController@datatable')->name('get_datatables');
                    Route::put('/store-update/{fc_sono}', 'Apps\PaymentController@store_update');
                    Route::post('/create', 'Apps\PaymentController@create');
                    Route::post('/submit', 'Apps\PaymentController@submit_pembayaran');
                    Route::delete('/delete/{fc_sono}/{fn_sopayrownum}', 'Apps\PaymentController@delete');

                    Route::get('/pdf', 'Apps\PaymentController@pdf');
                });

                Route::get('/lock', 'Apps\SalesOrderDetailController@lock');
            });
        });

        Route::prefix('delivery-order')->group(function () {
            Route::get('/', 'Apps\DeliveryOrderController@index')->name('do_index');
            Route::get('/detail/{fc_sono}', 'Apps\DeliveryOrderController@detail');
            Route::post('/insert_do', 'Apps\DeliveryOrderController@insert_do');
            Route::get('/create_do', 'Apps\DeliveryOrderController@create')->name('create_do');
            Route::get('/datatables', 'Apps\DeliveryOrderController@datatables');
            Route::get('/datatables-warehouse', 'Apps\DeliveryOrderController@datatables_warehouse');
            Route::get('/datatables-so-detail/{fc_sono}', 'Apps\DeliveryOrderController@datatables_so_detail');
            Route::get('/datatables-so-payment', 'Apps\DeliveryOrderController@datatables_so_payment');
            Route::get('/datatables-do-detail', 'Apps\DeliveryOrderController@datatables_do_detail');
            Route::get('/datatables-stock-inventory/{fc_stockcode}', 'Apps\DeliveryOrderController@datatables_stock_inventory');
            Route::delete('/delete-item/{fc_barcode}/{fn_rownum}', 'Apps\DeliveryOrderController@delete_item');
            Route::post('/cart_stock', 'Apps\DeliveryOrderController@cart_stock');
            Route::put('/update_transport/{fc_sono}', 'Apps\DeliveryOrderController@update_transport');
            Route::delete('/cancel_do', 'Apps\DeliveryOrderController@cancel_do');
            Route::post('/submit_do', 'Apps\DeliveryOrderController@submit_do');
            Route::get('/need-approve', 'Apps\DeliveryOrderController@approve');
        });

        Route::prefix('master-delivery-order')->group(function () {
            Route::get('/', 'Apps\MasterDeliveryOrderController@index');
            Route::get('/detail/{fc_dono}', 'Apps\MasterDeliveryOrderController@detail');
            Route::get('/datatables/{fc_dostatus}', 'Apps\MasterDeliveryOrderController@datatables');
            Route::get('/datatables/detail', 'Apps\MasterDeliveryOrderController@datatables_detail');
            Route::get('/datatables-do-detail/{fc_dono}', 'Apps\MasterDeliveryOrderController@datatables_do_detail');
            Route::get('/datatables-do-invstore/{fc_stockcode}/{fc_warehousecode}/{fc_barcode}', 'Apps\MasterDeliveryOrderController@datatables_invstore');

            Route::post('/pdf', 'Apps\MasterDeliveryOrderController@pdf');
            Route::get('/get_pdf/{fc_dono}/{nama_pj}', 'Apps\MasterDeliveryOrderController@get_pdf');
            Route::post('/pdf-sj', 'Apps\MasterDeliveryOrderController@pdf_sj');
            Route::get('/get-sj/{fc_dono}/{nama_pj}', 'Apps\MasterDeliveryOrderController@get_pdf_sj');
            Route::get('/inv/{fc_dono}', 'Apps\MasterDeliveryOrderController@inv');
            Route::post('/inv/publish', 'Apps\MasterDeliveryOrderController@publish');
            Route::put('/cancel', 'Apps\MasterDeliveryOrderController@cancel');
            Route::put('/reject_approval', 'Apps\MasterDeliveryOrderController@reject_approval');
            Route::put('/accept_approval', 'Apps\MasterDeliveryOrderController@accept_approval');
            Route::put('/submit', 'Apps\MasterDeliveryOrderController@submit');
            Route::put('/edit', 'Apps\MasterDeliveryOrderController@editDO');
            Route::post('/export-excel/{status}', 'Apps\MasterDeliveryOrderController@export_excel');
        });

        Route::prefix('received-order')->group(function () {
            Route::get('/', 'Apps\ReceivedOrderController@index');
            Route::get('/cari-do/{fc_dono}', 'Apps\ReceivedOrderController@cari_do');
            Route::get('/detail/{fc_dono}', 'Apps\ReceivedOrderController@detail');
            Route::get('/datatables', 'Apps\ReceivedOrderController@datatables');
            Route::post('/action', 'Apps\ReceivedOrderController@action_confirm');
        });

        // Route::prefix('master-invoice')->group(function(){
        //     Route::get('/','Apps\MasterInvoiceController@index');
        //     Route::get('/datatables/incoming','Apps\MasterInvoiceController@datatables_incoming');
        //     Route::get('/datatables/outgoing','Apps\MasterInvoiceController@datatables_outgoing');
        //     Route::get('/datatables/add-invoice','Apps\MasterInvoiceController@add_invoice');
        //     Route::delete('/delete/{fc_invno}', 'Apps\MasterInvoiceDetailController@delete_inv');
        //     Route::get('/inv_do/{fc_dono}', 'Apps\MasterInvoiceController@inv_do');
        //     Route::get('/inv_ro/{fc_rono}', 'Apps\MasterInvoiceController@inv_ro');
        //     Route::get('/get-update/incoming', 'Apps\MasterInvoiceController@get_update_incoming');
        //     Route::get('/get-update/outgoing', 'Apps\MasterInvoiceController@get_update_outgoing');
        //     Route::post('/update-invoice-incoming', 'Apps\MasterInvoiceController@update_invoice_incoming');
        //     Route::post('/update-invoice-outgoing', 'Apps\MasterInvoiceController@update_invoice_outgoing');
        //     Route::get('/detail_ro/{fc_rono}','Apps\MasterInvoiceController@detail_ro');
        //     Route::get('/detail_do/{fc_dono}','Apps\MasterInvoiceController@detail_do');

        //     Route::prefix('create')->group(function () {
        //         Route::get('/{fc_rono}','Apps\MasterInvoiceDetailController@create');
        //         Route::get('/datatables/ro-detail/{fc_rono}','Apps\MasterInvoiceDetailController@datatables_ro');
        //         Route::post('/incoming-insert','Apps\MasterInvoiceDetailController@incoming_insert');
        //         Route::put('/edit/incoming-edit-ro-detail','Apps\MasterInvoiceDetailController@incoming_edit_ro');
        //         Route::put('/deliver-update', 'Apps\MasterInvoiceDetailController@delivery_update');
        //         Route::put('/submit-invoice','Apps\MasterInvoiceDetailController@submit_invoice');
        //     });
        // });

        Route::prefix('purchase-order')->group(function () {
            Route::get('/', 'Apps\PurchaseOrderController@index')->name('po_index');
            Route::get('/get-data-supplier-po-datatables/{fc_branch}', 'Apps\PurchaseOrderController@get_data_supplier_po_datatables');
            Route::get('/get-data-where-field-id-get/{model}/{where_field}/{id}', 'Apps\PurchaseOrderController@get_data_where_field_id_get');
            Route::post('/store-update', 'Apps\PurchaseOrderController@store_update');
            Route::delete('/delete', 'Apps\PurchaseOrderController@delete');

            Route::prefix('detail')->group(function () {
                Route::post('/store-update', 'Apps\PurchaseOrderDetailController@store_update');
                Route::put('/received-update/{fc_pono}', 'Apps\PurchaseOrderDetailController@received_update');
                Route::get('/datatables', 'Apps\PurchaseOrderDetailController@datatables');
                Route::delete('/delete/{fc_pono}/{fc_porownum}', 'Apps\PurchaseOrderDetailController@delete');
                Route::post('/submit', 'Apps\PurchaseOrderDetailController@submit');
            });
        });

        Route::prefix('master-purchase-order')->group(function () {
            Route::get('/', 'Apps\MasterPurchaseOrderController@index');
            Route::get('/datatables/{fc_postatus}', 'Apps\MasterPurchaseOrderController@datatables');
            Route::get('/datatables/good_reception/{fc_suppliercode}', 'Apps\MasterPurchaseOrderController@datatables_good_reception');
            Route::get('/datatables/po_detail/{fc_pono}', 'Apps\MasterPurchaseOrderController@datatables_po_detail');
            Route::get('/datatables/ro', 'Apps\MasterPurchaseOrderController@datatables_receiving_order');
            Route::post('/pdf', 'Apps\MasterPurchaseOrderController@pdf');
            Route::get('/get_pdf/{fc_pono}/{nama_pj}/{tampil_harga}', 'Apps\MasterPurchaseOrderController@get_pdf');
            // Route::post('/pdf', 'Apps\MasterReceivingOrderController@pdf_ro');
            Route::get('/get_pdf_ro/{fc_rono}/{nama_pj}', 'Apps\MasterReceivingOrderController@get_pdf_ro');
            Route::get('/detail/{fc_pono}', 'Apps\MasterPurchaseOrderController@detail')->name('master-purchase-order-detail');
            Route::put('/close', 'Apps\MasterPurchaseOrderController@close_po');
            Route::put('/cancel_po', 'Apps\MasterPurchaseOrderController@cancel_po');
            Route::post('/export-excel/{status}', 'Apps\MasterPurchaseOrderController@export_excel');
            Route::put('/edit/kedatangan/{fc_pono}', 'Apps\MasterPurchaseOrderController@edit_kedatangan');
        });

        Route::prefix('receiving-order')->group(function () {
            Route::get('/', 'Apps\ReceivingOrderController@index');
            Route::get('/penerimaan-barang/{fc_grno}/{fc_suppliercode}', 'Apps\ReceivingOrderController@good_reception');
            Route::get('/detail/{fc_pono}', 'Apps\ReceivingOrderController@detail');
            Route::post('/pdf', 'Apps\ReceivingOrderController@pdf');
            Route::get('/get_pdf/{fc_rono}/{nama_pj}', 'Apps\ReceivingOrderController@get_pdf');
            Route::get('/datatables-warehouse', 'Apps\ReceivingOrderController@datatables_warehouse');
            Route::get('/datatables/po_detail/{fc_pono}', 'Apps\ReceivingOrderController@datatables_po_detail');
            Route::get('/datatables/ro/{fc_pono}', 'Apps\ReceivingOrderController@datatables_receiving_order');
            Route::delete('/cancel_ro/{fc_pono}', 'Apps\ReceivingOrderController@cancel_ro');

            Route::prefix('create')->group(function () {
                // Route::get('/','Apps\ReceivingDetailOrderController@index');
                Route::get('/{fc_pono}/{fc_warehousecode}', 'Apps\ReceivingDetailOrderController@create');
                Route::post('/store-update', 'Apps\ReceivingDetailOrderController@store');
                Route::get('/detail-item/{fc_stockcode}/{fc_pono}', 'Apps\ReceivingDetailOrderController@detail_item');
                Route::get('/datatables/temprodetail/{fc_pono}', 'Apps\ReceivingDetailOrderController@datatables_temp_ro_detail');
                Route::post('/insert-item', 'Apps\ReceivingDetailOrderController@insert_item');
                Route::put('/submit-ro', 'Apps\ReceivingDetailOrderController@submit_ro');
                Route::delete('/delete/temprodetail/{fn_rownum}', 'Apps\ReceivingDetailOrderController@delete_item');
            });
        });

        Route::prefix('master-receiving-order')->group(function () {
            Route::get('/', 'Apps\MasterReceivingOrderController@index');
            Route::get('/datatables', 'Apps\MasterReceivingOrderController@datatables');
            Route::get('/detail/{fc_rono}', 'Apps\MasterReceivingOrderController@detail');
            Route::get('/datatables/ro_detail', 'Apps\MasterReceivingOrderController@datatables_ro_detail');
            Route::get('/detail/generate-qr/{fc_barcode}/{count}/{fd_expired_date}/{fc_batch}', 'Apps\MasterReceivingOrderController@generateQRCodePDF');
            Route::post('/pdf', 'Apps\MasterReceivingOrderController@pdf');
            Route::get('/get_pdf/{fc_rono}/{nama_pj}', 'Apps\MasterReceivingOrderController@get_pdf');
            Route::post('/export-excel/{status}', 'Apps\MasterReceivingOrderController@export_excel');
        });

        Route::prefix('penerimaan-barang')->group(function () {
            Route::get('/', 'Apps\PenerimaanBarangController@index');
            Route::get('/get-data-supplier-pb-datatables/{fc_branch}', 'Apps\PenerimaanBarangController@get_data_supplier_pb_datatables');
            Route::post('/insert_good_reception', 'Apps\PenerimaanBarangController@insert_good_reception');
        });

        Route::prefix('master-penerimaan-barang')->group(function () {
            Route::get('/', 'Apps\MasterPenerimaanBarangController@index');
            Route::put('/clear', 'Apps\MasterPenerimaanBarangController@clear');
            Route::get('/datatables', 'Apps\MasterPenerimaanBarangController@datatables');
            Route::get('/datatables/master-transit', 'Apps\MasterPenerimaanBarangController@datatables_master_transit');
            Route::post('/pdf', 'Apps\MasterPenerimaanBarangController@pdf');
            Route::get('/doc/{fc_grno}/{count}', 'Apps\MasterPenerimaanBarangController@doc');
            Route::get('/get_pdf/{fc_grno}/{nama_pj}', 'Apps\MasterPenerimaanBarangController@get_pdf');
        });

        Route::prefix('persediaan-barang')->group(function () {
            Route::get('/', 'Apps\PersediaanBarangController@index');
            Route::get('/detail/{fc_warehousecode}', 'Apps\PersediaanBarangController@detail');
            Route::get('/datatables-detail/{fc_warehousecode}', 'Apps\PersediaanBarangController@datatables_detail');
            Route::get('/datatables-detail-inventory/{fc_stockcode}/{fc_warehousecode}', 'Apps\PersediaanBarangController@datatables_detail_inventory');
            Route::get('/datatables-mutasi/{fc_warehousecode}', 'Apps\PersediaanBarangController@datatables_mutasi');
            Route::get('/datatables-dexa', 'Apps\PersediaanBarangController@datatables_dexa');
            Route::get('/datatables-gudanglain', 'Apps\PersediaanBarangController@datatables_gudanglain');
            Route::get('/datatables-semua', 'Apps\PersediaanBarangController@datatables_semua');
            Route::get('/datatables-inventory-dexa/{fc_stockcode}', 'Apps\PersediaanBarangController@datatables_inventory_dexa');
            Route::get('/datatables-inventory-gudanglain/{fc_stockcode}', 'Apps\PersediaanBarangController@datatables_inventory_gudanglain');
            Route::post('/export-kartu-stock', 'Apps\PersediaanBarangController@export_kartu_stock');
            Route::get('/get-warehouse', 'Apps\PersediaanBarangController@get_warehouse');
            Route::get('/get-stock', 'Apps\PersediaanBarangController@get_stock');
            Route::get('/pdf/{fc_warehousecode}', 'Apps\PersediaanBarangController@pdf');
            Route::post('/export-excel', 'Apps\PersediaanBarangController@export_excel');
            Route::get('/detail/generate-qr/{fc_barcode}/{count}/{fd_expired_date}/{fc_batch}', 'Apps\PersediaanBarangController@generateQRCodePDF');
        });

        Route::prefix('mutasi-barang')->group(function () {
            Route::get('/', 'Apps\MutasiBarangController@index');
            Route::get('/datatables-stock-inventory/{fc_stockcode}/{fc_warehousecode}', 'Apps\MutasiBarangController@datatables_stock_inventory');
            Route::get('/datatables/so_cprr/{fc_membercode}', 'Apps\MutasiBarangController@datatables_so_cprr');
            Route::get('/datatables/so_internal', 'Apps\MutasiBarangController@datatables_so_internal');
            Route::get('/datatables-lokasi-awal/{fc_type_mutation}', 'Apps\MutasiBarangController@datatables_lokasi_awal');
            Route::get('/datatables-lokasi-tujuan/{fc_type_mutation}', 'Apps\MutasiBarangController@datatables_lokasi_tujuan');
            Route::get('/datatables-so-detail/{fc_sono}', 'Apps\MutasiBarangController@datatables_so_detail');
            Route::post('/store-mutasi', 'Apps\MutasiBarangController@store_mutasi');
            Route::delete('/cancel_mutasi', 'Apps\MutasiBarangController@cancel_mutasi');

            Route::prefix('detail')->group(function () {
                Route::put('/submit-mutasi-barang', 'Apps\MutasiBarangDetailController@submit');
                Route::get('/datatables-inventory/{fc_startpoint_code}', 'Apps\MutasiBarangDetailController@datatables_inventory');
                Route::get('/datatables', 'Apps\MutasiBarangDetailController@datatables');
                Route::post('/store_mutasi_detail', 'Apps\MutasiBarangDetailController@store_mutasi_detail');
                Route::delete('/delete/{fc_mutationno}/{fn_mutationrownum}', 'Apps\MutasiBarangDetailController@delete');
            });
        });

        Route::prefix('daftar-mutasi-barang')->group(function () {
            Route::get('/', 'Apps\DaftarMutasiBarangController@index');
            Route::get('/datatables-internal', 'Apps\DaftarMutasiBarangController@datatables_internal');
            Route::get('/datatables-eksternal', 'Apps\DaftarMutasiBarangController@datatables_eksternal');
            Route::get('/datatables-belum-terlaksana', 'Apps\DaftarMutasiBarangController@datatables_belum_terlaksana');
            Route::get('/detail/{fc_mutationno}', 'Apps\DaftarMutasiBarangController@detail');
            Route::get('/datatables', 'Apps\DaftarMutasiBarangController@datatables');

            Route::post('/pdf', 'Apps\DaftarMutasiBarangController@pdf');
            Route::get('/get_pdf/{fc_mutationno}/{nama_pj}', 'Apps\DaftarMutasiBarangController@get_pdf');
            Route::put('/submit', 'Apps\DaftarMutasiBarangController@submit');
            Route::post('/export-excel/{status}', 'Apps\DaftarMutasiBarangController@export_excel');
        });

        Route::prefix('penggunaan-cprr')->group(function () {
            Route::get('/', 'Apps\PenggunaanCprrController@index');
            Route::get('/datatables', 'Apps\PenggunaanCprrController@datatables');
            Route::get('/detail/{fc_warehousecode}', 'Apps\PenggunaanCprrController@detail');
            Route::get('/datatables-detail/{fc_warehousecode}', 'Apps\PenggunaanCprrController@datatables_detail');
            Route::get('/detail/{fc_warehousecode}/journal', 'Apps\PenggunaanCprrController@detail_unjournal');

            Route::post('/detail/{fc_warehousecode}/journal/{fc_membercode}', 'Apps\PenggunaanCprrController@journal_cprr');
        });

        Route::prefix('scan-qr')->group(function () {
            Route::get('/', 'Apps\ScanQrController@index');
            Route::get('/detail-barang/{fc_barcode}', 'Apps\ScanQrController@detail_barang');
            Route::post('/scan-barang', 'Apps\ScanQrController@scan_barang');
        });

        Route::prefix('invoice-penjualan')->group(function () {
            Route::get('/', 'Apps\InvoicePenjualanController@index');
            Route::get('/datatables', 'Apps\InvoicePenjualanController@datatables');
            Route::get('/detail/{fc_dono}', 'Apps\InvoicePenjualanController@detail');
            Route::get('/data-customer', 'Apps\InvoicePenjualanController@customer');
            Route::get('/datatables-so/{fc_membercode}', 'Apps\InvoicePenjualanController@datatables_so');
            Route::get('/datatables-sj/{fc_sono}', 'Apps\InvoicePenjualanController@datatables_sj');
            Route::get('/datatables-biaya-lain', 'Apps\InvoicePenjualanDetailController@datatables_biaya_lain');
            Route::delete('/detail/delete/{fc_invno}/{fn_invrownum}', 'Apps\InvoicePenjualanDetailController@delete');
            Route::delete('/cancel-invoice', 'Apps\InvoicePenjualanDetailController@cancel_invoice');
            Route::put('/update-fm-unityprice', 'Apps\InvoicePenjualanDetailController@update_unityprice');
            Route::put('/update-discprice', 'Apps\InvoicePenjualanDetailController@update_discprice');
            Route::get('/get-detail/{fn_invrownum}', 'Apps\InvoicePenjualanDetailController@get_detail');

            Route::prefix('create')->group(function () {
                Route::post('/store-invoice', 'Apps\InvoicePenjualanController@create_invoice');
                Route::post('/store-invoice-multi-sj', 'Apps\InvoicePenjualanController@create_invoice_multisj');
                Route::post('/store-detail', 'Apps\InvoicePenjualanDetailController@insert_item');
                Route::put('/update-inform/{fc_invno}', 'Apps\InvoicePenjualanDetailController@update_inform');
                Route::get('/{fc_dono}', 'Apps\InvoicePenjualanDetailController@create');
                Route::get('/multisj/{fc_dono}', 'Apps\InvoicePenjualanDetailController@create_multisj');
                Route::get('/datatables-do-detail/{fc_dono}', 'Apps\InvoicePenjualanDetailController@datatables_do_detail');
                Route::put('/submit-invoice', 'Apps\InvoicePenjualanDetailController@submit_invoice');
            });
        });

        Route::prefix('invoice-pembelian')->group(function () {
            Route::get('/datatables-biaya-lain', 'Apps\InvoicePembelianDetailController@datatables_biaya_lain');
            Route::post('/store-invoice', 'Apps\InvoicePembelianController@create_invoice');
            Route::get('/', 'Apps\InvoicePembelianController@index');
            Route::get('/detail/{fc_rono}', 'Apps\InvoicePembelianController@detail');
            Route::get('/data-supplier', 'Apps\InvoicePembelianController@supplier');
            Route::get('/datatables-po/{fc_suppliercode}', 'Apps\InvoicePembelianController@datatables_po');
            Route::get('/datatables-bpb/{fc_pono}', 'Apps\InvoicePembelianController@datatables_bpb');
            Route::get('/get-detail/{fn_invrownum}', 'Apps\InvoicePembelianDetailController@get_detail');
            Route::delete('/detail/delete/{fc_invno}/{fn_invrownum}', 'Apps\InvoicePembelianDetailController@delete');
            Route::get('/datatables', 'Apps\InvoicePembelianController@datatables');
            Route::delete('/cancel-invoice', 'Apps\InvoicePembelianDetailController@cancel_invoice');
            Route::put('/update-fm-unityprice', 'Apps\InvoicePembelianDetailController@update_unityprice');
            Route::put('/update-discprice', 'Apps\InvoicePembelianDetailController@update_discprice');
            // update-description ada di daftar invoice detail view
            // Route::put('/update-description', 'Apps\InvoicePembelianDetailController@edit_description');

            Route::prefix('create')->group(function () {
                Route::post('/store-invoice', 'Apps\InvoicePembelianController@create_invoice');
                Route::post('/store-invoice-multi-bpb', 'Apps\InvoicePembelianController@create_invoice_multibpb');
                Route::post('/store-detail', 'Apps\InvoicePembelianDetailController@insert_item');
                Route::put('/update-info/{fc_invno}', 'Apps\InvoicePembelianDetailController@update_inform');
                Route::get('/{fc_rono}', 'Apps\InvoicePembelianDetailController@create');
                Route::get('/multibpb/{fc_rono}', 'Apps\InvoicePembelianDetailController@create_multibpb');
                Route::get('/datatables-ro-detail/{fc_rono}/{fc_warehousecode}', 'Apps\InvoicePembelianDetailController@datatables_ro_detail');
                Route::put('/submit-invoice', 'Apps\InvoicePembelianDetailController@submit_invoice');
            });
        });

        Route::prefix('invoice-cprr')->group(function () {
            Route::get('/', 'Apps\InvoiceCprrController@index');
            // Route::get('/detail', 'Apps\InvoiceCprrController@create');
            Route::post('/create', 'Apps\InvoiceCprrController@create');
            Route::post('/submit', 'Apps\InvoiceCprrController@submit');
            Route::put('/update-inform/{fc_invno}', 'Apps\InvoiceCprrController@update_inform');
            Route::delete('/cancel', 'Apps\InvoiceCprrController@delete');

            Route::put('/update-discprice', 'Apps\InvoiceCprrDetailController@update_discprice');
            Route::get('/datatables/{fc_status}', 'Apps\InvoiceCprrDetailController@index');
            Route::post('/detail/store-update', 'Apps\InvoiceCprrDetailController@create');
            Route::delete('/detail/delete/{fc_invno}/{fn_invrownum}', 'Apps\InvoiceCprrDetailController@delete');
        });

        Route::prefix('konversi-stock')->group(function () {
            Route::get('/', 'Apps\StockKonversiController@index');
            Route::get('/stock-stockcode/{fc_stockcode}', 'Apps\StockKonversiController@stock_stockcode');
            Route::get('/invstore-stockcode/{fc_stockcode}/{fc_warehousecode}/{fd_expired}/{fc_batch}', 'Apps\StockKonversiController@invstore_stockcode');
            Route::get('/invstore-warehouse/{fc_warehousecode}', 'Apps\StockKonversiController@invstore_warehouse');
            Route::get('/history-konversi', 'Apps\StockKonversiController@datatable_inquiry');

            Route::POST('/', 'Apps\StockKonversiController@konversi');
        });

        Route::prefix('daftar-invoice')->group(function () {
            Route::get('/', 'Apps\DaftarInvoiceController@index');
            Route::get('/datatables/{fc_invtype}', 'Apps\DaftarInvoiceController@datatables');
            Route::get('/detail/{fc_invno}/{fc_invtype}', 'Apps\DaftarInvoiceController@detail');
            Route::post('/pdf', 'Apps\DaftarInvoiceController@pdf');
            Route::get('/get_pdf/{fc_invno}/{nama_pj}/{tampil_diskon}', 'Apps\DaftarInvoiceController@get_pdf');
            Route::post('/kwitansi', 'Apps\DaftarInvoiceController@kwitansi');
            Route::get('/get_kwitansi/{fc_invno}/{nama_pj}', 'Apps\DaftarInvoiceController@get_kwitansi');
            Route::get('/datatables-inv-detail/{fc_invno}', 'Apps\DaftarInvoiceController@datatables_inv_detail');
            Route::get('/datatables-do-detail/{fc_invno}', 'Apps\DaftarInvoiceController@datatables_do_detail');
            Route::get('/datatables-ro-detail/{fc_invno}', 'Apps\DaftarInvoiceController@datatables_ro_detail');
            Route::get('/datatables-cprr/{fc_invno}', 'Apps\DaftarInvoiceController@datatables_cprr');
            Route::get('/get/{fc_invno}', 'Apps\DaftarInvoiceController@get');
            Route::get('/get-user', 'Apps\DaftarInvoiceController@get_user');
            Route::get('/need-approve', 'Apps\DaftarInvoiceController@approve');
            Route::post('/request-approval', 'Apps\DaftarInvoiceController@request_approval');
            Route::post('/cek-approval', 'Apps\DaftarInvoiceController@cek_approval');
            Route::get('/cek-exist-approval/{fc_invno}', 'Apps\DaftarInvoiceController@cek_exist_approval');
            // update-description ada di daftar invoice detail view
            Route::put('/update-description', 'Apps\DaftarInvoiceController@edit_description');
        });

        Route::prefix('retur-barang')->group(function () {
            Route::get('/', 'Apps\ReturBarangController@index');
            Route::get('/detail-delivery-order/{fc_dono}', 'Apps\ReturBarangController@detail_deliver_order');
            Route::post('/store-update', 'Apps\ReturBarangController@store_update');
            Route::delete('/cancel', 'Apps\ReturBarangController@cancel');

            Route::prefix('detail')->group(function () {
                Route::delete('/delete-item/{fc_barcode}/{row}', 'Apps\ReturBarangDetailController@delete_item');
                Route::put('/submit', 'Apps\ReturBarangDetailController@submit_return_barang');
                Route::post('/store-update', 'Apps\ReturBarangDetailController@store_update');
                Route::get('/datatables', 'Apps\ReturBarangDetailController@datatables');
                Route::get('/datatables-do-detail/{fc_dono}', 'Apps\ReturBarangDetailController@datatables_do_detail');
            });
        });

        Route::prefix('stock-opname')->group(function () {
            Route::get('/', 'Apps\StockOpnameController@index');
            Route::delete('/cancel', 'Apps\StockOpnameController@cancel');
            Route::get('/detail-gudang/{fc_warehousecode}', 'Apps\StockOpnameController@detail_gudang');
            Route::post('/store-update', 'Apps\StockOpnameController@store_update');

            Route::prefix('detail')->group(function () {
                Route::put('/lock-update', 'Apps\StockOpnameDetailController@lock_update');
                Route::post('/select_stock', 'Apps\StockOpnameDetailController@select_stock');
                Route::delete('/delete/{fn_rownum}', 'Apps\StockOpnameDetailController@delete_item');
                Route::get('/inventory/datatables/{fc_warehousecode}', 'Apps\StockOpnameDetailController@datatable_inventory');
                Route::get('/datatables', 'Apps\StockOpnameDetailController@datatables');
                Route::get('/datatables-persediaan/{fc_warehousecode}', 'Apps\StockOpnameDetailController@datatables_persediaan');
                Route::get('/datatables-satuan', 'Apps\StockOpnameDetailController@datatables_satuan');
                Route::put('/submit-stockopname', 'Apps\StockOpnameDetailController@submit_stockopname');
            });
        });

        Route::prefix('daftar-retur-barang')->group(function () {
            Route::get('/', 'Apps\DaftarReturBarangController@index');
            Route::get('/detail/{fc_returno}', 'Apps\DaftarReturBarangController@detail');
            Route::get('/datatables', 'Apps\DaftarReturBarangController@datatables');
            Route::get('/datatables-detail/{fc_returno}', 'Apps\DaftarReturBarangController@datatables_detail');

            Route::post('/pdf', 'Apps\DaftarReturBarangController@pdf');
            Route::get('/get_pdf/{fc_returno}/{nama_pj}', 'Apps\DaftarReturBarangController@get_pdf');
            Route::post('/export-excel', 'Apps\DaftarReturBarangController@export_excel');
        });

        Route::prefix('master-coa')->group(function () {
            Route::get('/', 'DataMaster\MasterCoaController@index');
            Route::get('/detail/{fc_coacode}', 'DataMaster\MasterCoaController@detail');
            Route::get('/datatables', 'DataMaster\MasterCoaController@datatables');
            Route::get('/for-mapping/datatables', 'DataMaster\MasterCoaController@datatables_coa_mapping');
            Route::get('/{layer}', 'DataMaster\MasterCoaController@getParent');
            Route::post('/store-update', 'DataMaster\MasterCoaController@storeUpdate');
            Route::delete('/delete/{fc_coacode}', 'DataMaster\MasterCoaController@delete');
        });

        Route::prefix('master-mapping')->group(function () {
            Route::get('/', 'Apps\MasterMappingController@index');
            Route::get('/detail/{fc_mappingcode}', 'Apps\MasterMappingController@detail');
            Route::get('/datatables', 'Apps\MasterMappingController@datatables');
            Route::get('/{action}', 'Apps\MasterMappingController@get_transaksi');
            Route::post('/store-update', 'Apps\MasterMappingController@store_update');
            Route::put('/hold/{fc_mappingcode}', 'Apps\MasterMappingController@hold');
            Route::put('/unhold/{fc_mappingcode}', 'Apps\MasterMappingController@unhold');
            Route::delete('/cancel/{fc_mappingcode}', 'Apps\MasterMappingController@cancel');
            Route::put('/submit/{fc_mappingcode}', 'Apps\MasterMappingController@submit');
            Route::put('/trxaccmethod_debit/{fc_mappingcode}', 'Apps\MasterMappingController@update_trxaccmethod_debit');
            Route::put('/trxaccmethod_kredit/{fc_mappingcode}', 'Apps\MasterMappingController@update_trxaccmethod_kredit');

            Route::prefix('delete')->group(function () {
                Route::delete('/debit/{fc_coacode}', 'Apps\MasterMappingCreateController@delete_debit');
                Route::delete('/kredit/{fc_coacode}', 'Apps\MasterMappingCreateController@delete_kredit');
            });

            Route::prefix('create')->group(function () {
                Route::post('/insert-debit', 'Apps\MasterMappingCreateController@insert_debit');
                Route::post('/insert-kredit', 'Apps\MasterMappingCreateController@insert_kredit');
                Route::get('/{fc_mappingcode}', 'Apps\MasterMappingCreateController@create');
                Route::get('/datatables-debit/{fc_mappingcode}', 'Apps\MasterMappingCreateController@datatables_debit');
                Route::get('/datatables-kredit/{fc_mappingcode}', 'Apps\MasterMappingCreateController@datatables_kredit');
                Route::put('/trxaccmethod_debit/{fc_mappingcode}', 'Apps\MasterMappingCreateController@update_trxaccmethod_debit');
                Route::put('/trxaccmethod_kredit/{fc_mappingcode}', 'Apps\MasterMappingCreateController@update_trxaccmethod_kredit');
            });
        });

        Route::prefix('mapping-user')->group(function () {
            Route::get('/', 'Apps\MappingUserController@index');
            Route::get('/datatables', 'Apps\MappingUserController@datatables');
            Route::get('/get-user', 'Apps\MappingUserController@get_user');
            Route::get('/get-mapping', 'Apps\MappingUserController@get_mapping');
            Route::post('/store-update', 'Apps\MappingUserController@store_update');
            Route::get('/detail/{fc_mappingcode}', 'Apps\MappingUserController@detail');
            Route::delete('/delete/{id}', 'Apps\MappingUserController@delete');
        });

        Route::prefix('transaksi')->group(function () {
            Route::get('/', 'Apps\TransaksiController@index');
            Route::get('/get-data/{fc_trxno}', 'Apps\TransaksiController@detail');
            Route::get('/get/{fc_trxno}', 'Apps\TransaksiController@get');
            Route::get('/giro', 'Apps\TransaksiController@giro');
            Route::get('/edit/{fc_trxno}', 'Apps\TransaksiController@edit');
            Route::get('/edit-opsi/{fc_trxno}', 'Apps\TransaksiController@edit_opsi');
            Route::get('/datatable-edit-opsi/{fc_trxno}', 'Apps\TransaksiController@datatables_edit_opsi');
            Route::get('/bookmark-index', 'Apps\TransaksiController@bookmark_index');
            Route::get('/create-index', 'Apps\TransaksiController@create');
            Route::get('/datatables', 'Apps\TransaksiController@datatables');
            Route::get('/data/{fc_trxno}', 'Apps\TransaksiController@data');
            Route::get('/data-debit/{fc_trxno}', 'Apps\TransaksiController@data_debit');
            Route::get('/data-kredit/{fc_trxno}', 'Apps\TransaksiController@data_kredit');
            Route::get('/data-opsi/{fc_trxno}', 'Apps\TransaksiController@data_opsi');
            Route::get('/datatables-bookmark', 'Apps\TransaksiController@datatables_bookmark');
            Route::get('/datatables-bookmark-all', 'Apps\TransaksiController@datatables_bookmark_all');
            Route::get('/datatables-giro/{fc_giropos}', 'Apps\TransaksiController@datatables_giro');
            Route::get('/datatables-mapping', 'Apps\TransaksiController@datatables_mapping');
            Route::get('/datatables-invoice', 'Apps\TransaksiController@datatables_invoice');
            Route::post('/store-update', 'Apps\TransaksiController@store_update');
            Route::post('/request-approval', 'Apps\TransaksiController@request_approval');
            Route::get('/get-detail/{fc_mappingcode}', 'Apps\TransaksiController@get_detail');
            Route::delete('/cancel_transaksi', 'Apps\TransaksiController@cancel_transaksi');
            Route::put('/lanjutkan-bookmark/{fc_trxno}', 'Apps\TransaksiController@lanjutkan_bookmark');
            Route::put('/pending', 'Apps\TransaksiController@pending');
            Route::put('/clear', 'Apps\TransaksiController@clear');
            Route::get('/cek-exist-approval/{fc_trxno}', 'Apps\TransaksiController@cek_exist_approval');
            Route::put('/update-status-opsi-lanjutan', 'Apps\TransaksiController@update_status_opsi_lanjutan');
            Route::get('/opsi-lanjutan', 'Apps\TransaksiController@opsi_lanjutan');
            Route::get('/datatables-opsi', 'Apps\TransaksiController@datatables_opsi');
            Route::post('/store-opsi', 'Apps\TransaksiController@store_opsi');
            Route::post('/store-edit-opsi/{fc_trxno}', 'Apps\TransaksiController@store_edit_opsi');
            Route::put('/update-opsi', 'Apps\TransaksiController@update_opsi');
            Route::put('/update-edit-opsi/{fc_trxno}', 'Apps\TransaksiController@update_edit_opsi');
            Route::delete('/delete-opsi/{fc_trxno}/{fn_rownum}', 'Apps\TransaksiController@delete_opsi');
            Route::delete('/edit-delete-opsi/{fc_trxno}/{fn_rownum}', 'Apps\TransaksiController@edit_delete_opsi');

            Route::prefix('detail')->group(function () {
                Route::get('/datatables', 'Apps\TransaksiDetailController@datatables');
                Route::get('/datatables-debit', 'Apps\TransaksiDetailController@datatables_debit');
                Route::get('/datatables-kredit', 'Apps\TransaksiDetailController@datatables_kredit');
                Route::get('/get-coa/{fc_mappingmst}', 'Apps\TransaksiDetailController@get_coa');
                Route::get('/get-coa-kredit/{fc_mappingmst}', 'Apps\TransaksiDetailController@get_coa_kredit');
                Route::get('/{coacode}', 'Apps\TransaksiDetailController@get_data_coa');
                Route::get('/kredit/{coacode}', 'Apps\TransaksiDetailController@get_data_coa_kredit');
                Route::post('/store-debit', 'Apps\TransaksiDetailController@store_debit');
                Route::post('/store-from-bpb', 'Apps\TransaksiDetailController@store_bpb');
                Route::post('/store-from-inv', 'Apps\TransaksiDetailController@store_invoice');
                Route::post('/store-kredit', 'Apps\TransaksiDetailController@store_kredit');
                Route::put('update-debit-transaksi', 'Apps\TransaksiDetailController@update_debit_transaksi');
                Route::put('update-kredit-transaksi', 'Apps\TransaksiDetailController@update_kredit_transaksi');
                Route::delete('/delete/{fc_coacode}/{fn_rownum}/{fc_balancerelation}/{fc_mappingcode}', 'Apps\TransaksiDetailController@delete');
                Route::put('/submit_transaksi', 'Apps\TransaksiDetailController@submit_transaksi');
                Route::put('/update-pembayaran', 'Apps\TransaksiDetailController@update_pembayaran');
                Route::get('/datatables-invoice/{fc_docreference}', 'Apps\TransaksiDetailController@datatables_invoice');
                Route::get('/datatables-bpb/{fc_docreference}', 'Apps\TransaksiDetailController@datatables_bpb');
            });

            Route::prefix('edit')->group(function () {
                Route::post('/edit-debit/{fc_trxno}', 'Apps\TransaksiDetailController@edit_debit');
                Route::post('/edit-kredit/{fc_trxno}', 'Apps\TransaksiDetailController@edit_kredit');
                Route::put('update-edit-debit-transaksi/{fc_trxno}', 'Apps\TransaksiDetailController@update_edit_debit_transaksi');
                Route::put('update-edit-kredit-transaksi/{fc_trxno}', 'Apps\TransaksiDetailController@update_edit_kredit_transaksi');
                Route::delete('/delete/{fc_trxno}/{fc_coacode}/{fn_rownum}/{fc_balancerelation}/{fc_mappingcode}', 'Apps\TransaksiDetailController@edit_delete');
                Route::put('/submit-edit/{fc_trxno}', 'Apps\TransaksiDetailController@submit_edit');
                Route::put('/update-edit-pembayaran/{fc_trxno}', 'Apps\TransaksiDetailController@update_edit_pembayaran');
                Route::post('/store-from-bpb', 'Apps\TransaksiDetailController@store_bpb_edit');
                Route::post('/store-from-inv', 'Apps\TransaksiDetailController@store_invoice_edit');
                Route::put('/update-edit-status-opsi-lanjutan/{fc_trxno}', 'Apps\TransaksiController@update_edit_status_opsi_lanjutan');
            });
        });

        Route::prefix('approvement')->group(function () {
            Route::get('/', 'Apps\ApprovementController@index');
            Route::get('/datatables', 'Apps\ApprovementController@datatables');
            Route::get('/datatables-applicant', 'Apps\ApprovementController@datatables_applicant');
            Route::put('/cancel-approval', 'Apps\ApprovementController@cancel');
            Route::post('/reject', 'Apps\ApprovementController@reject');
            Route::post('/accept', 'Apps\ApprovementController@accept');
            Route::get('/get/{fc_approvalno}', 'Apps\ApprovementController@get');
            Route::get('/get-detail/{fc_approvalno}', 'Apps\ApprovementController@get_data');
            Route::put('/edit/{fc_trxno}', 'Apps\ApprovementController@edit');
        });

        Route::prefix('approval-invoice')->group(function () {
            Route::get('/', 'Apps\ApprovalInvoiceController@index');
            Route::get('/datatables-accessor', 'Apps\ApprovalInvoiceController@datatables_accessor');
            Route::get('/datatables-applicant', 'Apps\ApprovalInvoiceController@datatables_applicant');
            Route::put('/cancel-approval', 'Apps\ApprovalInvoiceController@cancel');
            Route::post('/reject', 'Apps\ApprovalInvoiceController@reject');
            Route::post('/accept', 'Apps\ApprovalInvoiceController@accept');
            Route::get('/get/{fc_approvalno}', 'Apps\ApprovalInvoiceController@get');
            Route::get('/get-detail/{fc_approvalno}', 'Apps\ApprovalInvoiceController@get_data');
            Route::post('/pdf', 'Apps\ApprovalInvoiceController@pdf');
            Route::get('/get_pdf/{fc_docno}/{nama_pj}', 'Apps\ApprovalInvoiceController@get_pdf');
        });

        Route::prefix('upcoming-stock')->group(function () {
            Route::get('/', 'Apps\UpcomingStockController@index');
            Route::get('/datatables', 'Apps\UpcomingStockController@datatables');
            Route::get('/datatables-detail/{fc_stockcode}', 'Apps\UpcomingStockController@datatables_detail');
        });

        Route::prefix('kas-bon')->group(function () {
            Route::get('/', [KasBonController::class, 'index']);
            Route::post('/store', [KasBonController::class, 'store']);
            Route::PUT('/update/{kasbonno}', [KasbonController::class, 'update']);
            Route::get('/datatables', [KasBonController::class, 'datatables']);
        });

        Route::prefix('marketing')->group(function () {
            Route::get('/', 'Apps\MarketingController@index');
            Route::get('/datatable-preview-marketing', 'Apps\MarketingController@datatable_preview');
            Route::get('/datatables-filter-customer', 'Apps\MarketingController@get_customer_by_sales');
            Route::get('/datatables-sales-customer/{fc_salescode}', 'Apps\MarketingController@datatables_sales_customer');
            Route::get('/datatables-customer/{fc_salescode}', 'Apps\MarketingController@datatables_customer');
            // disini route export data untuk pdf
            Route::post('/export-pdf', 'Apps\MarketingController@export_pdf');
            Route::get('/export-pdf', 'Apps\MarketingController@export_pdf');

            // untuk excel masih query lama
            Route::post('/export-excel', 'Apps\MarketingController@export_excel');

            // get role user sales
            Route::get('/get-role-sales/{fc_salescode}', 'Apps\MarketingController@get_role_sales');
            Route::prefix('persediaan')->group(function () {
                Route::get('/', 'Apps\MarketingController@persediaan');
                Route::get('/detail/{fc_warehousecode}', 'Apps\MarketingController@detail');
                Route::get('/export-rekap', 'Apps\MarketingController@export_rekap');
            });
        });
    });
});
