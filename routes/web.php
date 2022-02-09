<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminContactUsController;

use App\Http\Controllers\AdminEmployeesController;
use App\Http\Controllers\AdminProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PagesController;


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
Route::post('/store-contact-us', [Pagescontroller::class, 'storeContactUs'])->name('store.contact.us');
Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
Route::get('/cart', [PagesController::class, 'cart'])->name('cart');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('dashboard', [UserDashboardController::class, 'profile'])->name('user.dashboard');
});

Route::prefix('admin')->middleware(['admins'])->group(function(){
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



});
