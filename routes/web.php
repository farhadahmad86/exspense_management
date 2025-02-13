<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

    Route::resources([
        'users' => 'UserController',
        'providers' => 'ProviderController',
        'inventory/products' => 'ProductController',
//        'clients' => 'ClientController',
        'inventory/categories' => 'ProductCategoryController',
        'transactions/transfer' => 'TransferController',
        'methods' => 'MethodController',
    ]);
    ///////////////////////////////////////////  Role Routes //////////////////////////////////////////////////////////
    Route::resource('/roles', App\Http\Controllers\RoleController::class);
    ///////////////////////////////////////////  CashAccountController Routes //////////////////////////////////////////////////////////
    Route::resource('/cash_account', App\Http\Controllers\CashAccountController::class);
    ///////////////////////////////////////////  PartRegistrationController Routes //////////////////////////////////////////////////////////
    Route::resource('/product_registration', App\Http\Controllers\ProductRegistrationController::class);
    ///////////////////////////////////////////  Client Routes //////////////////////////////////////////////////////////
    Route::resource('/client', App\Http\Controllers\ClientController::class);
    ///////////////////////////////////////////  Employee Registration Routes //////////////////////////////////////////////////////////
    Route::resource('/employee_registration', App\Http\Controllers\EmployeeRegistrationController::class);
    ///////////////////////////////////////////  ProductLossController Routes //////////////////////////////////////////////////////////
    Route::resource('/product_loss', App\Http\Controllers\ProductLossController::class);
    ///////////////////////////////////////////  ProductRecoverController Routes //////////////////////////////////////////////////////////
    Route::resource('/product_recover', App\Http\Controllers\ProductRecoverController::class);
    ///////////////////////////////////////////  OpeningStockController Routes //////////////////////////////////////////////////////////
    Route::resource('/opening_stock', App\Http\Controllers\OpeningStockController::class);
    ///////////////////////////////////////////  SaleInvoiceController Routes //////////////////////////////////////////////////////////
    Route::resource('/sale_invoice', App\Http\Controllers\SaleInvoiceController::class);
    ///////////////////////////////////////////  PurchaseInvoiceController Routes //////////////////////////////////////////////////////////
    Route::resource('/purchase_invoice', App\Http\Controllers\PurchaseInvoiceController::class);
    ///////////////////////////////////////////  PurchaseReturnInvoiceController Routes //////////////////////////////////////////////////////////
    Route::resource('/purchase_return_invoice', App\Http\Controllers\PurchaseReturnInvoiceController::class);
    ///////////////////////////////////////////  CashReceiptVoucherController Routes //////////////////////////////////////////////////////////
    Route::resource('/cash_receipt_voucher', App\Http\Controllers\CashReceiptVoucherController::class);
    ///////////////////////////////////////////  CashPaymentVoucherController Routes //////////////////////////////////////////////////////////
    Route::resource('/cash_payment_voucher', App\Http\Controllers\CashPaymentVoucherController::class);///////////////////////////////////////////  \App\Http\Controllers\ChangePasswordController //////////////////////////////////////////////////////////
    ///////////////////////////////////////////  ChangePasswordController Routes //////////////////////////////////////////////////////////
    Route::resource('/settings', App\Http\Controllers\ChangePasswordController::class);



    ////////////////////////////////////////////  Openning Routes //////////////////////////////////////////////////////////
    Route::get('/add_openning', [App\Http\Controllers\OpenningController::class, 'add_openning'])->name('add_openning');
    Route::post('/store_openning', [App\Http\Controllers\OpenningController::class, 'store_openning'])->name('store_openning');
    Route::get('/openning_list', [App\Http\Controllers\OpenningController::class, 'openning_list'])->name('openning_list');
    ////////////////////////////////////////////  Party Routes //////////////////////////////////////////////////////////
    Route::get('/add_party', [App\Http\Controllers\PartyController::class, 'add_party'])->name('add_party');
    Route::post('/store_party', [App\Http\Controllers\PartyController::class, 'store_party'])->name('store_party');
    Route::get('/party_list', [App\Http\Controllers\PartyController::class, 'party_list'])->name('party_list');
    Route::get('/edit_party/{id}', [App\Http\Controllers\PartyController::class, 'edit_party'])->name('edit_party');
    Route::post('/update_party/{id}', [App\Http\Controllers\PartyController::class, 'update_party'])->name('update_party');

    ////////////////////////////////////////////  CreditSaleController Routes //////////////////////////////////////////////////////////
    Route::get('/add_credit_sale/{id}', [App\Http\Controllers\CreditSaleController::class, 'add_credit_sale'])->name('add_credit_sale');
    Route::post('/store_credit_sale', [App\Http\Controllers\CreditSaleController::class, 'store_credit_sale'])->name('store_credit_sale');
    Route::get('/credit_sale_list', [App\Http\Controllers\CreditSaleController::class, 'credit_sale_list'])->name('credit_sale_list');

    Route::get('/credit_sale_modal_view_details', [App\Http\Controllers\CreditSaleController::class, 'credit_sale_modal_view_details'])->name('credit_sale_modal_view_details');
    Route::get('/credit_sale_modal_view_details/view/{id}', [App\Http\Controllers\CreditSaleController::class, 'credit_sale_modal_view_details_SH'])->name('credit_sale_modal_view_details_sh');
    Route::get('/credit_sale_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CreditSaleController::class, 'credit_sale_modal_view_details_pdf_SH'])->name('credit_sale_modal_view_details_pdf_sh');
    ////////////////////////////////////////////  CashBook Routes //////////////////////////////////////////////////////////
    Route::get('/cash_book_list', [App\Http\Controllers\CashBookController::class, 'cash_book_list'])->name('cash_book_list');
    ////////////////////////////////////////////  StockReports Routes //////////////////////////////////////////////////////////
    Route::get('/stock_report', [App\Http\Controllers\OpeningStockController::class, 'stock_smmary_report'])->name('stock_report');
    ////////////////////////////////////////////  ProfitReports Routes //////////////////////////////////////////////////////////
    Route::get('/Profit_Report', [App\Http\Controllers\ProfitReportController::class, 'index'])->name('Profit_Report');
    ////////////////////////////////////////////  company profile Routes //////////////////////////////////////////////////////////
    Route::get('/company_profile', [App\Http\Controllers\CompanyProfileController::class, 'company_profile'])->name('company_profile');
    Route::post('/update_company_profile', [App\Http\Controllers\CompanyProfileController::class, 'update_company_profile'])->name('update_company_profile');


    ////////////////////////////////////////////  CreditPurchaseController Routes //////////////////////////////////////////////////////////
    Route::get('/add_credit_purchase/{id}', [App\Http\Controllers\CreditPurchaseController::class, 'add_credit_purchase'])->name('add_credit_purchase');
    Route::post('/store_credit_purchase', [App\Http\Controllers\CreditPurchaseController::class, 'store_credit_purchase'])->name('store_credit_purchase');
    Route::get('/credit_purchase_list', [App\Http\Controllers\CreditPurchaseController::class, 'credit_purchase_list'])->name('credit_purchase_list');

    Route::get('/credit_purchase_modal_view_details', [App\Http\Controllers\CreditPurchaseController::class, 'credit_purchase_modal_view_details'])->name('credit_purchase_modal_view_details');
    Route::get('/credit_purchase_modal_view_details/view/{id}', [App\Http\Controllers\CreditPurchaseController::class, 'credit_purchase_modal_view_details_SH'])->name('credit_purchase_modal_view_details_sh');
    Route::get('/credit_purchase_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CreditPurchaseController::class, 'credit_purchase_modal_view_details_pdf_SH'])->name('credit_purchase_modal_view_details_pdf_sh');
    //sale invoice views
    Route::get('/sale_invoice_modal_view_details', [App\Http\Controllers\CustomController::class, 'sale_invoice_modal_view_details'])->name('sale_invoice_modal_view_details');

    Route::get('/sale_invoice_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'sale_invoice_modal_view_details_SH'])->name('sale_invoice_modal_view_details_sh');

    Route::get('/sale_invoice_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CustomController::class, 'sale_invoice_modal_view_details_pdf_SH'])->name('sale_invoice_modal_view_details_pdf_sh');

    //purchase invoice views
    Route::get('/purchase_invoice_modal_view_details', [App\Http\Controllers\CustomController::class, 'purchase_invoice_modal_view_details'])->name('purchase_invoice_modal_view_details');

    Route::get('/purchase_invoice_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'purchase_invoice_modal_view_details_SH'])->name('purchase_invoice_modal_view_details_sh');

    Route::get('/purchase_invoice_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CustomController::class, 'purchase_invoice_modal_view_details_pdf_SH'])->name('purchase_invoice_modal_view_details_pdf_sh');

    Route::get('/refresh-data', [App\Http\Controllers\CustomController::class, 'refreshData'])->name('refresh-data');


    ////////////////////////////////////////////  Custom Routes //////////////////////////////////////////////////////////
    //Product Loss
    Route::get('/product_loss_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'product_loss_modal_view_details_SH'])->name('product_loss_modal_view_details_sh');
    Route::get('/product_loss_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CustomController::class, 'product_loss_modal_view_details_pdf_SH'])->name('product_loss_modal_view_details_pdf_sh');
    // Product Recover
    Route::get('/part_recover_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'part_recover_modal_view_details_SH'])->name('part_recover_modal_view_details_sh');
    Route::get('/part_recover_modal_view_details/view/pdf/{id}/{array?}/{str?}', [App\Http\Controllers\CustomController::class, 'part_recover_modal_view_details_pdf_SH'])->name('part_recover_modal_view_details_pdf_sh');
    // cash payment
    Route::get('/cash_payment_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'cash_payment_modal_view_details_SH'])->name('cash_payment_modal_view_details_sh');
    // cash receipt
    Route::get('/cash_receipt_modal_view_details/view/{id}', [App\Http\Controllers\CustomController::class, 'cash_receipt_modal_view_details_SH'])->name('cash_receipt_modal_view_details_sh');
    // get purchase inv data
    Route::get('/get_invoice_data', [App\Http\Controllers\CustomController::class, 'getInvoiceData'])->name('get_invoice_data');


    ////////////////////////////////////////////  Company Routes //////////////////////////////////////////////////////////
    Route::middleware(['checkUserIdIsOne'])->group(function () {
        Route::get('/add_company', [App\Http\Controllers\CompanyController::class, 'create'])->name('add_company');
        Route::post('/store_company', [App\Http\Controllers\CompanyController::class, 'store'])->name('store_company');
        Route::get('/company_list', [App\Http\Controllers\CompanyController::class, 'company_list'])->name('company_list');
    });

});
