<?php

use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminContactUsController;
use App\Http\Controllers\AdminEmployeesController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;



//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/products-by-category/{slug}', [PagesController::class, 'productsByCategory'])->name('products.by.category');
Route::get('/search', [PagesController::class, 'search'])->name('search');
Route::get('/show-product/{slug}', [PagesController::class, 'showProduct'])->name('product.show');
Route::get('/contact-us', [PagesController::class, 'contactUs'])->name('contact.us');
Route::post('/store-contact-us', [PagesController::class, 'storeContactUs'])->name('store.contact.us');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/cart', [PagesController::class, 'cart'])->name('cart');

Route::post('check-cart-items-and-coupon', [CartController::class, 'checkCartItemsAndCoupon'])->name('check.cart.items.and.coupon');

Route::get('/check-coupon/{code}', [CartController::class, 'checkCouponAndReturnValue'])->name('check.coupon');
Route::post('/create-order', [CheckoutController::class, 'createOrder'])->name('create.order');
Route::get('/thank-you', [CheckoutController::class, 'thankYou'])->name('thank_you');
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('user/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::get('user/edit-profile', [ProfileController::class, 'editProfile'])->name('user.edit.profile');
    Route::post('user/update-profile', [ProfileController::class, 'updateProfile'])->name('user.update.profile');
    Route::post('user/delete-profile', [ProfileController::class, 'deleteProfile'])->name('user.delete.profile');
    Route::get('user/orders', [ProfileController::class, 'orders'])->name('user.orders');
    Route::get('user/orders/{id}', [ProfileController::class, 'ordersShow'])->name('user.orders.show');
    Route::get('public/pdfs/{filename}', [ProfileController::class, 'downloadFile'])->name('user.download.file');

});


Route::prefix('admin')->middleware(['any.admins'])->group(function(){
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    //EMPLOYEES
    Route::get('employees', [AdminEmployeesController::class, 'index'])->name('admin.employees');
    Route::get('employees/create}', [AdminEmployeesController::class, 'create'])->name('admin.employees.create');
    Route::get('employees/edit/{user}', [AdminEmployeesController::class, 'edit'])->name('admin.employees.edit');
    Route::post('/employees', [AdminEmployeesController::class, 'store'])->name('admin.employees.store');
    Route::post('/employees/update/{user}', [AdminEmployeesController::class, 'update'])->name('admin.employees.update');
    //Route::post('/employees/delete/{employee}', [AdminEmployeesController::class, 'destroy'])->name('admin.employees.destroy');

    //CATEGORIES
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::post('/categories/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/categories/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    //PRODUCTS
    Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('products/out-of-stock', [AdminProductController::class, 'outOfStock'])->name('admin.products.out.of.stock');
    Route::get('products/unpublished', [AdminProductController::class, 'unpublished'])->name('admin.products.unpublished');
    Route::get('products/deleted', [AdminProductController::class, 'deletedProducts'])->name('admin.products.deleted');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('products/update/{product}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('products/update/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::post('products/delete/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/restore/{product}', [AdminProductController::class, 'restore'])->name('admin.products.restore');
    Route::post('/products/toggle-publish/{product}', [AdminProductController::class, 'togglePublishProduct'])->name('admin.products.toggle.publish');
    Route::get('/search', [AdminProductController::class, 'search'])->name('admin.products.search');


    //CUSTOMERS
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
    Route::get('customers/show/{id}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');

    //SETTINGS
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings');
    Route::post('/update-settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

    //CONTACT US
    Route::get('/contact-us-in-progress', [AdminContactUsController::class, 'index'])->name('admin.contact.us.in.progress');
    Route::get('/contact-us-closed', [AdminContactUsController::class, 'closed'])->name('admin.contact.us.closed');
    Route::get('/edit-contact-us/{id}', [AdminContactUsController::class, 'edit'])->name('admin.contact.us.edit');
    Route::post('/update-contact-us/{id}', [AdminContactUsController::class, 'update'])->name('admin.contact.us.update');

    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('admin.coupons');
    Route::get('/coupons-create', [AdminCouponController::class, 'create'])->name('admin.create.coupons');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/coupons/edit/{coupon}', [AdminCouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::post('/coupons/update/{coupon}', [AdminCouponController::class, 'update'])->name('admin.coupons.update');
    Route::post('/coupons/delete/{coupon}', [AdminCouponController::class, 'destroy'])->name('admin.coupons.destroy');

    //ORDERS AND CART ITEMS
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders-show/{order}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::post('/orders-update/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/get-chart-data', [AdminDashboardController::class, 'getChartData']);

});
