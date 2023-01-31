<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\StockController;
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

Route::get('/', function () {
    return view('welcome');
});

// Admin All Route
Route::controller(AdminController::class)->group(function() {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'profile')->name('admin.profile');
    Route::get('/admin/profile/edit', 'editprofile')->name('edit.profile');
    Route::post('/admin/profile/store', 'storeprofile')->name('store.profile');
    Route::get('/admin/profile/changepassword', 'changepassword')->name('change.password');
    Route::post('/admin/profile/updatepassword', 'updatepassword')->name('update.password');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){

    Route::controller(SupplierController::class)->group(function(){
        Route::get('/supplier/all/page', 'allSuppliersPage')->name('all.suppliers.page');
        Route::get('/supplier/add/page', 'addSupplierPage')->name('add.supplier.page');
        Route::post('/supplier/add', 'addSupplier')->name('add.supplier');
        Route::get('supplier/edit/page/{id}', 'editSupplierPage')->name('edit.supplier.page');
        Route::post('/supplier/edit/{id}', 'editSupplier')->name('edit.supplier');
        Route::get('/supplier/delete/{id}', 'deleteSupplier')->name('delete.supplier');
    });

    Route::controller(CustomerController::class)->group(function(){
        Route::get('/customer/all/page', 'allCustomersPage')->name('all.customers.page');
        Route::get('/customer/add/page', 'addCustomerPage')->name('add.customer.page');
        Route::post('/customer/add', 'addCustomer')->name('add.customer');
        Route::get('/customer/edit/page/{id}', 'editCustomerPage')->name('edit.customer.page');
        Route::post('/customer/edit/{id}', 'editCustomer')->name('edit.customer');
        Route::get('/customer/delete/{id}', 'deleteCustomer')->name('delete.customer');
        Route::get('/customer/credit', 'creditCustomer')->name('credit.customer');
        Route::get('/customer/credit/print', 'creditCustomerPrint')->name('customer.credit.print');
        Route::get('/customer/edit/credit/{invoice_id}', 'editCustomerCreditPage')->name('edit.customer.credit.invoice.page');
        Route::post('/customer/update/invoice/{invoice_id}', 'updateCustomerInvoice')->name('update.customer.invoice');
        Route::get('/customer/invoice/details/pdf/{invoice_id}', 'customerInvoiceDetails')->name('customer.invoice.details.pdf');
        Route::get('/customer/paid', 'paidCustomer')->name('paid.customer');
        Route::get('/customer/paid/print', 'paidCustomerPrint')->name('paid.customer.print');
        Route::get('/customer/wise/report', 'customerWiseReport')->name('customer.wise.report');
        Route::get('/customer/credit/report', 'customerCreditReport')->name('customer.credit.report');
        Route::get('/customer/paid/report', 'customerPaidReport')->name('customer.paid.report');
    });

    Route::controller(UnitController::class)->group(function(){
        Route::get('/unit/all/page', 'allUnitPage')->name('all.units.page');
        Route::get('/unit/add/page', 'addUnitPage')->name('add.unit.page');
        Route::post('/unit/add', 'addUnit')->name('add.unit');
        Route::get('/unit/edit/page/{id}', 'editUnitPage')->name('edit.unit.page');
        Route::post('/unit/edit/{id}', 'editUnit')->name('edit.unit');
        Route::get('/unit/delete/{id}', 'deleteUnit')->name('delete.unit');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category/all/page', 'allCategoriesPage')->name('all.categories.page');
        Route::get('/category/add/page', 'addCategoryPage')->name('add.category.page');
        Route::post('/category/add', 'addCategory')->name('add.category');
        Route::get('/category/edit/page/{id}', 'editCategoryPage')->name('edit.category.page');
        Route::post('/category/edit/{id}', 'editCategory')->name('edit.category');
        Route::get('/category/delete/{id}', 'deleteCategory')->name('delete.category');
    });

    Route::controller(ProductController::class)->group(function(){
        Route::get('/product/all/page', 'allProductsPage')->name('all.products.page');
        Route::get('/product/add/page', 'addProductPage')->name('add.product.page');
        Route::post('/product/add', 'addProduct')->name('add.product');
        Route::get('/product/edit/page/{id}', 'editProductPage')->name('edit.product.page');
        Route::post('/product/edit/{id}', 'editProduct')->name('edit.product');
        Route::get('/product/delete/{id}', 'deleteProduct')->name('delete.product');
    });

    Route::controller(PurchaseController::class)->group(function(){
        Route::get('/purchase/all/page', 'allPurchasePage')->name('all.purchases.page');
        Route::get('/purchase/add/page', 'addPurchasePage')->name('add.purchase.page');
        Route::post('/purchase/add', 'addPurchase')->name('add.purchase');
        Route::get('/purchase/delete/{id}', 'deletePurchase')->name('delete.purchase');
        Route::get('/purchase/approve/page', 'approvePurchasePage')->name('approve.purchase.page');
        Route::get('/purchase/approve/{id}', 'approvePurchase')->name('approve.purchase');
        Route::get('/purchase/daily/report', 'dailyPurchaseReport')->name('daily.purchase.report');
        Route::get('/purchase/daily/pdf', 'dailyPurchaseReportPdf')->name('daily.purchase.report.pdf');
    });

    Route::controller(InvoiceController::class)->group(function(){
        Route::get('/invoice/all/page', 'allInvoicesPage')->name('all.invoices.page');
        Route::get('/invoice/add/page', 'addInvoicePage')->name('add.invoice.page');
        Route::post('/invoice/add', 'addInvoice')->name('add.invoice');
        Route::get('/invoice/pending/page', 'pendingInvoicesPage')->name('pending.invoices.page');
        Route::get('/invoice/delete/{id}', 'deleteInvoice')->name('delete.invoice');
        Route::get('/invoice/approve/page/{id}', 'approveInvoicePage')->name('approve.invoice.page');
        Route::post('/invoice/approve/{id}', 'approveInvoice')->name('approve.invoice');
        Route::get('/invoice/print/page', 'invoicePrintPage')->name('invoice.print.page');
        Route::get('/invoice/print/{id}', 'printInvoice')->name('print.invoice');
        Route::get('/invoice/dailyInvoiceReport/page', 'dailyInvoiceReportPage')->name('daily.invoice.report.page');
        Route::get('/invoice/dailyReportPdf', 'dailyReportPdf')->name('daily.invoice.report.pdf');
    });

    Route::controller(StockController::class)->group(function(){
        Route::get('/stock/report/page', 'stockReportPage')->name('stock.report.page');
        Route::get('/stock/report/pdf', 'stockReportPdf')->name('stock.report.pdf');
        Route::get('/stock/supplier/wise/page', 'stockSupplierWisePage')->name('stock.supplier.wise.page');
        Route::get('/supplier/wise/pdf', 'supplierWisePdf')->name('supplier.wise.pdf');
        Route::get('/product/wise/pdf', 'productWisePdf')->name('product.wise.pdf');
    });

});

Route::controller(DefaultController::class)->group(function(){
    Route::get('/get/category', 'getCategory')->name('get.category');
    Route::get('/get/product', 'getProduct')->name('get.product');
    Route::get('/get/stock', 'getStock')->name('get.stock');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
