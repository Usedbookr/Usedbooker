<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubcategoryController;
use App\Http\Controllers\Category\ChildcategoryController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Banner\BannerController;
use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\API\OTPController;
use App\Http\Controllers\API\EverythingController;
use App\Http\Controllers\API\HomeController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/newarrival/all', 'Newarrival'); 
});

// Category All Route 
Route::controller(HomeController::class)->group(function () {
    Route::get('/aboutus', 'aboutus'); 
    Route::get('/termscondition', 'termscondition'); 
    Route::get('/privacypolicy', 'privacypolicy'); 
    Route::get('/faqs', 'faqs'); 
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/newarrival/all', 'Newarrival'); 
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/bestseller/all', 'Bestseller'); 
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories/all', 'ApiAll'); 
});

Route::controller(LanguageController::class)->group(function () {
    Route::get('/languages/all', 'ApiAll'); 
});

// Sub Category All Route 
Route::controller(SubcategoryController::class)->group(function () {
    Route::get('/subcategories/all', 'ApiAll'); 
    Route::get('/categorywisesubcategory/{id}', 'ApiSubcategory'); 
});

// Child Category All Route 
Route::controller(ChildcategoryController::class)->group(function () {
    Route::get('/childcategories/all', 'ApiAll'); 
    Route::get('/subcategorywisechildcategory/{id}', 'ApiChildcategory'); 
});

// Book All Route 
Route::controller(BookController::class)->group(function () {
    Route::get('/books/all', 'ApibookAll'); 
    Route::get('/categorywisebook/{id}', 'ApiChildcategorybook');
    Route::get('/bookdetails/{id}', 'Bookdetails'); 
});

// Book All Route 
Route::controller(BannerController::class)->group(function () {
    Route::get('/banners/all', 'ApiAll');  
});





// Fetch Externel API All Route 
/*Route::controller(CategoryController::class)->group(function () {
    Route::get('/books', 'FetchBook')->name('fetch_book');     
});*/

// Fetch Externel API All Route 
Route::controller(HomeController::class)->group(function () {
    Route::get('/authors', 'FetchAuthor')->name('fetch_authors'); 
    Route::get('/home_books', 'Books')->name('fetch_books'); 
    Route::post('/pgredirect', 'pgredirect')->name('pgredirect'); 
   
});

//Fetch otp
Route::controller(OTPController::class)->group(function () {
    Route::post('/send-otp', 'SendOTP')->name('send-otp');
    Route::post('/verify-otp', 'verifyOtp')->name('verify-otp');  
    Route::post('/login', 'Login')->name('login');
});


Route::middleware('auth:sanctum')->controller(OTPController::class)->group(function () {
    Route::get('/user', 'FetchUser')->name('fetch_user'); 
});


Route::middleware('auth:sanctum')->controller(EverythingController::class)->group(function () {
    Route::post('/profileimgupdate', 'profileImgUpdate')->name('profileimgupdate'); 
    Route::post('/profileupdate', 'profileUpdate')->name('profileupdate'); 
    Route::get('/carts', 'CartList')->name('carts'); 
    Route::post('/addtocart', 'addtocart')->name('addtocart');
    Route::post('/updatecart', 'addtocart')->name('updatecart');
    Route::get('/cartremove/{id}', 'CartRemove')->name('cartremove');
    Route::get('/wishlists', 'WishList')->name('wishlists'); 
    Route::post('/wishliststore', 'wishliststore')->name('wishliststore');
    Route::get('/wishlistremove/{id}', 'WishlistRemove')->name('wishlistremove');
    Route::get('/orders', 'OrderList')->name('orders'); 
    Route::get('/order/detail/{id}', 'OrderDetails')->name('orderdetails');
    Route::post('/placeorder', 'PlaceOrder')->name('placeorder');
    Route::post('/couponapply', 'CouponApply')->name('couponapply');
    Route::post('/singleplaceorder', 'SingleOrder')->name('singleplaceorder');
    Route::post('/productreview', 'Productreview')->name('productreview');
});

 
