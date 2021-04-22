<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\DeliveryAndPaymentController;
use App\Http\Controllers\ProductPropertyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Notifications\OrderStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
/*Routes for e-shop*/
Route::middleware(['eshop'])->group(function () {
    Route::get('/', [HomePageController::class, 'show'])->name('home');
    Route::get('/vyhledavani', [SearchController::class, 'search'])->name('search');

    Route::get('/kategorie/{category}', [CategoryController::class, 'show'])->name('category');
    Route::get('/produkt/{product}', [ProductController::class, 'show'])->name('product');

    Route::get('image/{image}/{width?}/{height?}', [ImageController::class, 'show'])->name('image.show');
    Route::get('image/{image}/{height?}', [ImageController::class, 'show'])->name('image.show');
    Route::get('image/{image}/{width?}', [ImageController::class, 'show'])->name('image.show');
    Route::get('/kosik/', [BasketController::class, 'show'])->name('basket');
    Route::post('/kosik/pridat', [BasketController::class, 'add'])->name('basket.add');
    Route::get('/kosik/odstranit/{basket_item}', [BasketController::class, 'delete'])->name('basket.delete');
    Route::post('/basket/form-data',  [BasketController::class, 'storeFormData']);
    Route::post('/basket/update-item',  [BasketController::class, 'updateBasketItem']);

    Route::post('/objednavka', [OrderController::class, 'create'])->name('order.add');
    Route::get('/objednavka/{order}', [OrderController::class, 'ordered'])->name('order.finished');

    Route::view('/kontakt', 'eshop.contact')->name('contact');
    Route::view('/obchodni-podminky', 'eshop.terms')->name('terms');
    Route::view('/o-nas', 'eshop.about')->name('about');


});

/*Routes for e-shop user's profile */

Route::middleware(['auth', 'eshop'])->prefix('uzivatel')->name('user.')->group(function () {
    Route::get('/profil', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profil/{user}', [UserController::class, 'update'])->name('profile.update');

    Route::get('/objednavky', [OrderController::class, 'index'])->name('orders');
    Route::get('/objednavky/{order}', [OrderController::class, 'show'])->name('order');
});
/*Routes for admin pages*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/objednavky', [OrderController::class, 'adminIndex'])->name('orders');
    Route::get('/objednavky/update-status',  [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/objednavky/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::delete('/objednavky/{order}', [OrderController::class, 'adminDelete'])->name('orders.delete');

    Route::get('/hlavni-stranka', [HomePageController::class, 'index'])->name('homepage');
    Route::get('/hlavni-stranka/pridat', [HomePageController::class, 'add'])->name('homepage.add');
    Route::post('/hlavni-stranka/pridat', [HomePageController::class, 'create'])->name('homepage.create');
    Route::get('/hlavni-stranka/{slide}', [HomePageController::class, 'edit'])->name('homepage.edit');
    Route::post('/hlavni-stranka/{slide}', [HomePageController::class, 'update'])->name('homepage.update');
    Route::delete('/hlavni-stranka/{slide}', [HomePageController::class, 'delete'])->name('homepage.delete');

    Route::get('/kategorie', [CategoryController::class, 'index'])->name('categories');
    Route::get('/kategorie/pridat', [CategoryController::class, 'add'])->name('categories.add');
    Route::post('/kategorie/pridat', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/kategorie/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/kategorie/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategorie/{category}', [CategoryController::class, 'delete'])->name('categories.delete');

    Route::get('/produkty', [ProductController::class, 'index'])->name('products');
    Route::get('/produkty/pridat', [ProductController::class, 'add'])->name('products.add');
    Route::post('/produkty/pridat', [ProductController::class, 'create'])->name('products.create');
    Route::get('/produkty/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/produkty/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produkty/{product}', [ProductController::class, 'delete'])->name('products.delete');

    Route::get('/dodani-a-platba', [DeliveryAndPaymentController::class, 'index'])->name('delivery_and_payment_methods');
    Route::get('/dodani/pridat', [DeliveryAndPaymentController::class, 'addDeliveryMethod'])->name('delivery_method.add');
    Route::post('/dodani/pridat', [DeliveryAndPaymentController::class, 'createDeliveryMethod'])->name('delivery_method.create');
    Route::get('/dodani/{delivery}', [DeliveryAndPaymentController::class, 'editDeliveryMethod'])->name('delivery_method.edit');
    Route::post('/dodani/{delivery}', [DeliveryAndPaymentController::class, 'updateDeliveryMethod'])->name('delivery_method.update');
    Route::delete('/dodani/{delivery}', [DeliveryAndPaymentController::class, 'deleteDeliveryMethod'])->name('delivery_method.delete');

    Route::get('/platby/pridat', [DeliveryAndPaymentController::class, 'addPaymentMethod'])->name('payment_method.add');
    Route::post('/platby/pridat', [DeliveryAndPaymentController::class, 'createPaymentMethod'])->name('payment_method.create');
    Route::get('/platby/{payment}', [DeliveryAndPaymentController::class, 'editPaymentMethod'])->name('payment_method.edit');
    Route::post('/platby/{payment}', [DeliveryAndPaymentController::class, 'updatePaymentMethod'])->name('payment_method.update');
    Route::delete('/platby/{payment}', [DeliveryAndPaymentController::class, 'deletePaymentMethod'])->name('payment_method.delete');

    Route::get('/uzivatele', [UserController::class, 'index'])->name('users');
    Route::get('/uzivatele/{user}', [UserController::class, 'adminEdit'])->name('users.edit');
    Route::post('/uzivatele/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/uzivatele/{user}', [UserController::class, 'delete'])->name('users.delete');

    Route::get('/ciselniky/znacky', [BrandController::class, 'index'])->name('dials.brands');
    Route::get('/ciselniky/znacky/pridat', [BrandController::class, 'add'])->name('dials.brands.add');
    Route::post('/ciselniky/znacky/pridat', [BrandController::class, 'create'])->name('dials.brands.create');
    Route::get('/ciselniky/znacky/{dial}', [BrandController::class, 'edit'])->name('dials.brands.edit');
    Route::post('/ciselniky/znacky/{dial}', [BrandController::class, 'update'])->name('dials.brands.update');
    Route::delete('/ciselniky/znacky/{dial}', [BrandController::class, 'delete'])->name('dials.brands.delete');

    Route::get('/ciselniky/vlastnosti-produktu', [ProductPropertyController::class, 'index'])->name('dials.product_properties');
    Route::get('/ciselniky/vlastnosti-produktu/pridat', [ProductPropertyController::class, 'add'])->name('dials.product_properties.add');
    Route::post('/ciselniky/vlastnosti-produktu/pridat', [ProductPropertyController::class, 'create'])->name('dials.product_properties.create');
    Route::get('/ciselniky/vlastnosti-produktu/{dial}', [ProductPropertyController::class, 'edit'])->name('dials.product_properties.edit');
    Route::post('/ciselniky/vlastnosti-produktu/{dial}', [ProductPropertyController::class, 'update'])->name('dials.product_properties.update');
    Route::delete('/ciselniky/vlastnosti-produktu/{dial}', [ProductPropertyController::class, 'delete'])->name('dials.product_properties.delete');

});
/* CRON that deletes old baskets*/

Route::get('/cron', function () {
    $result = DB::selectOne('CALL delete_old_baskets()');
    return response()->json(['result' => $result]);
})->name('cron');


require __DIR__.'/auth.php';


