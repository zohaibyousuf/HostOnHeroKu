<?php

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

 Route::group(['middleware' => 'auth'], function() {
	Route::get('/dashboard', 'HomeController@report');
	Route::get('/', 'HomeController@report');
	Route::get('/logout', 'HomeController@logoutIfAuthenticated');
	Route::get('language_switch/{locale}', 'HomeController@switchLanguage');
	
	Route::post('importcategory', 'CategoryController@importCategory')->name('category.import');
	Route::resource('category', 'CategoryController');

	Route::post('importproduct', 'ProductController@importProduct')->name('product.import');
	Route::get('products/gencode', 'ProductController@generateCode');
	Route::get('products/print_barcode','ProductController@printBarcode')->name('product.printBarcode');
	Route::get('products/lsms_product_search', 'ProductController@lsmsProductSearch');
	Route::resource('products', 'ProductController');

	Route::get('purchases/product_purchase/{id}','PurchaseController@productPurchaseData');
	Route::get('purchases/lsms_product_search', 'PurchaseController@lsmsProductSearch')->name('product_purchase.search');
	Route::get('purchases/purchase_by_csv', 'PurchaseController@purchaseByCsv');
	Route::post('importpurchase', 'PurchaseController@importPurchase')->name('purchase.import');
	Route::resource('purchases', 'PurchaseController');

	Route::post('customer/import', 'CustomerController@importCustomer')->name('customer.import');
	Route::resource('customer', 'CustomerController');

	Route::get('sales/product_sale/{id}','SaleController@productSaleData');
	Route::get('sales/sale_by_csv', 'SaleController@saleByCsv');
	Route::post('importsale', 'SaleController@importSale')->name('sale.import');
	Route::get('sales/lsms_product_search', 'SaleController@lsmsProductSearch')->name('product_sale.search');
	Route::get('sales/getproduct/{id}', 'SaleController@getProduct')->name('sale.getproduct');
	Route::post('sales/add_payment', 'SaleController@addPayment')->name('sale.add-payment');
	Route::get('sales/getpayment/{id}', 'SaleController@getPayment')->name('sale.get-payment');
	Route::post('sales/updatepayment', 'SaleController@updatePayment')->name('sale.update-payment');
	Route::post('sales/deletepayment', 'SaleController@deletePayment')->name('sale.delete-payment');
	Route::resource('sales', 'SaleController');

	Route::get('returns/product_return/{id}','ReturnController@productReturnData');
	Route::get('returns/lsms_product_search', 'ReturnController@lsmsProductSearch')->name('product_return.search');
	Route::resource('returns', 'ReturnController');

	Route::get('report/best_seller', 'ReportController@bestSeller');
	Route::post('report/profit_loss', 'ReportController@profitLoss')->name('report.profitLoss');
	Route::post('report/report_by_date', 'ReportController@productReportByDate')->name('report.byDate');
	Route::get('report/product_quantity_alert', 'ReportController@productQuantityAlert')->name('report.qtyAlert');
	Route::post('report/purchase_report_by_date', 'ReportController@purchaseReportByDate')->name('report.purchaseByDate');
	Route::post('report/sale_report_by_date', 'ReportController@saleReportByDate')->name('report.saleByDate');
	Route::post('report/customer_report_by_date', 'ReportController@customerReportByDate')->name('report.customerByDate');
	Route::post('report/due_report_by_date', 'ReportController@dueReportByDate')->name('report.dueByDate');

	Route::get('users/profile/{id}', 'UserController@profile')->name('user.profile');
	Route::post('users/update_profile/{id}', 'UserController@profileUpdate')->name('user.profileUpdate');
	Route::put('users/changepass/{id}', 'UserController@changePassword')->name('user.password');
	Route::get('users/genpass', 'UserController@generatePassword');
	Route::resource('users', 'UserController');
	Route::resource('settings', 'SettingsController');

	Route::get('roles/permission/{id}', 'RoleController@permission')->name('role.permission');
	Route::post('roles/set_permission', 'RoleController@setPermission')->name('role.setPermission');
	Route::resource('roles', 'RoleController');
 });


