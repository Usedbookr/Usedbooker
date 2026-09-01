<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubcategoryController;
use App\Http\Controllers\Banner\BannerController;
use App\Http\Controllers\Category\ChildcategoryController;
use App\Http\Controllers\BookCondition\BookConditionController;
use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\State\StateController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Binding\BindingController;
use App\Http\Controllers\Rating\RatingreviewController;
use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogAuthorController;
use App\Http\Controllers\BlogCategoryController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FeedController;


Route::controller(PaymentController::class)->group(function () {
    Route::get('/phonepe', 'index')->name('phonepe');
    Route::post('/phonepe-store', 'phonepeStore')->name('phonepe.store');
    Route::get('/confirm', 'confirm')->name('confirm');
});

Route::get('/clear-my-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    
    return "<h1>clear</h1>";
});

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index')->name('index.home');
    Route::get('/category-list', 'CategoryList')->name('user.categorieslist.index');
    Route::get('/about-us', 'aboutus')->name('about');
    Route::get('/search', 'search')->name('categories.search');
    Route::get('/contact-us', 'contactus')->name('index.contact');
    Route::get('/new-arrivals', 'new_arrival')->name('new.arrival');
    Route::get('/buy-second-hand-books-usedbooks/categories/{id}', 'categories')->name('index.categories');
    Route::get('/author/{id}', 'autherCheck')->name('check.author');
    Route::get('/authors', 'autherList')->name('list.author');
    Route::get('/buy-second-hand-books-usedbooks/{cat_id}/{id}', 'productdetails')->name('product.details');
    Route::post('/product-attr', 'productattr')->name('product.attr');
    Route::post('/product-attr-price', 'product_attr_price')->name('product.attr.price');
    Route::post('/product-attr1', 'productattr1')->name('product.attr1');
    Route::post('/product-binding', 'productbinding')->name('product.binding');
    Route::post('/product-submit', 'productsubmit')->name('product.submit');
    
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/terms-and-conditions', 'terms')->name('terms');
    
    Route::get('/privacy-policy', 'policy')->name('policy');
    
    Route::get('/refund-and-cancellation-policy', [IndexController::class, 'refundPolicy'])->name('refund.policy');
    Route::get('/shipping-and-delivery-policy', [IndexController::class, 'shippingPolicy'])->name('shipping.policy');
    
    Route::get('/blogs', 'UserBlog')->name('user.front.blog');
    Route::get('/blog/{slug}', 'UserBlogDetails')->name('user.front.blog.details');
    Route::get('/blog-category/{slug}', 'Usercategory')->name('user.front.blog.category');

    //Search Book

    // Reset Password
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    // Reset Password

    Route::any('/product-search-search', 'search_book')->name('product.search');
    
    Route::get('/product-search/{id}', 'search_book_get')->name('product.search.get');

    // Subscription Sent
    Route::post('/subscription', 'subscription_sent')->name('subscription.sent');

    //Add to cart Section
    Route::post('/add-cart', 'addTocard')->name('add.card');
    Route::get('/view-cart', 'viewcart')->name('view.cart');
    Route::post('/update-cart', 'updatecart')->name('update.cart');
    Route::post('/decrease-cart', 'decreasecart')->name('decrease.cart');
    Route::post('/model-render', 'ModelRender')->name('model.render');
    Route::post('/delete-cart', 'deletecart')->name('remove.cart');

    //Add to Whislist Section
    Route::get('/add-Wishlist/{id}', 'addToWhislist')->name('add.Whislist');
    Route::get('/view-wishlist', 'viewWhislist')->name('view.Whislist');
    Route::post('/update-Wishlist', 'updateWhislist')->name('update.Whislist');
    Route::get('/delete-wish/{id}', 'delete_whislist')->name('remove.Whislist');

    //Coupon Section
    Route::post('/coupon-check', 'couponcheck')->name('coupon.check');
    Route::post('/coupon-remove', 'couponremove')->name('coupon.remove');

    //Referral Section
    Route::post('/referral-check', 'referralcheck')->name('referral.check');
    Route::post('/referral-remove', 'referralremove')->name('referral.remove');

    Route::post('/process-checkout', 'checkout')->name('process.checkout');
    Route::post('/blog-comment-store', 'BlogCommentStore')->name('user.blog.comment.store');

});

Route::group(['prefix'=>'user'],function (){
    Route::controller(IndexController::class)->group(function () {
        Route::get('/login', 'userlogin')->name('user.login');
        Route::get('/otp-login', 'userOtplogin')->name('user.otp');
        Route::get('/register', 'userregister')->name('user.register');
        Route::get('/front-logout', 'logout')->name('front.logout');
        Route::post('/user-login', 'user_login')->name('login.user');
        Route::post('/user-otp-login', 'user_otp_login')->name('otp.login.user');
        Route::post('/user-register', 'user_register')->name('register.user');

        Route::get('/otp-check', 'otp_user')->name('user.verify.otp');
        Route::get('/get-otp/{id}', 'get_otp')->name('user.get.otp');
        Route::post('/resend-otp', 'resend_otp')->name('user.resend.otp');
        Route::post('/new-resend-otp', 'new_resend_otp')->name('new.user.resend.otp');
        Route::post('/check-otp', 'check_user_otp')->name('check.user.otp');

        Route::get('/otpverify/{id}', 'otpverify')->name('otpverify');
        Route::post('/otp-check', 'otp_check')->name('otp.check');
        Route::post('/otp-verify', 'otp_verify')->name('otp.verify');

        Route::post('/check-email', 'MailCheck')->name('mail.check');
        Route::post('/check-phone', 'PhoneCheck')->name('phone.check');

        Route::post('/search-word-text', 'SearchWordText')->name('search.word.text');

        Route::any('/phonepe-return', 'phonepeReturn')->name('phonepe.return');
        Route::post('phonepe-callback', 'phonepeCallback')->name('phonepe.callback');


    });
    
    Route::controller(UserController::class)->group(function () {
        Route::get('/orders', 'order')->name('user.order');
    });
    Route::get('/guest-checkout',[UserController::class, 'guestCheckout'])->name('guest.checkout');
    
    Route::middleware(['otp_verify'])->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'index')->name('user.profile');
            Route::post('/profile-upload', 'profileupload')->name('profile.upload');
            Route::get('/wishlist', 'whislist')->name('user.whislist');
            Route::post('/romove-wish', 'RemoveWhislist')->name('user.whislist.remove');
            Route::get('/address', 'address')->name('user.address');
            Route::post('/storeaddress', 'storeAddress')->name('user.address.store');
            Route::get('/edit-address/{id}', 'edit_address')->name('user.address.edit');
            Route::get('/checkout', 'checkout')->name('user.checkout');
            Route::get('/order-details/{id}', 'order_details')->name('user.order.details');
            Route::get('/invoice-download/{id}', 'invoice_download')->name('user.invoice.download');
            Route::get('/order-now', 'order_now')->name('final.order.now.page');
            Route::post('/address-select', 'select_address')->name('select.address');
            Route::post('/final-step', 'finalStep')->name('final.step');
            Route::post('/process-order', 'orderNow')->name('order.now');
            Route::get('/referral-details/{id}', 'ReferralDetails')->name('user.referral.details');
            Route::get('/order-success/{id}', 'order_success')->name('user.order.success');
            Route::get('/set-default/{id}', 'set_default')->name('set.default');
            Route::get('/delete-address/{id}', 'delete_address')->name('delete.address');

            Route::post('/order-review-details', 'order_review_details')->name('order.details.review');
            Route::post('/order-review', 'order_review')->name('order.review');
            Route::post('/user-image-add', 'user_image_add')->name('user.image.add');
            Route::post('/create-referral-code', 'create_referral_code')->name('create.referral.code');

        });
    }); 
});

Route::group(['prefix'=>'admin'],function (){
    Route::controller(DemoController::class)->group(function () {
        Route::get('/login', 'login')->name('admin.login');
        Route::post('/admin-login', 'admin_login')->name('login.admin');
        // Route::get('/regiser', 'register')->name('admin.login');
        // Route::get('/rest-password', 'rest_password')->name('admin.login');
        // Route::get('/contact', 'ContactMethod')->name('cotact.page');
    });
});

Route::middleware(['IsAdmin'])->group(function() {
    Route::group(['prefix'=>'admin'],function (){

        Route::get('/', function () {
            return view('admin.index');
        });
    
        Route::controller(DemoController::class)->group(function () {
            Route::get('/about', 'Index')->name('about.page');
            Route::get('/contact', 'ContactMethod')->name('cotact.page');
        });
        
        
         // Admin All Route 
        Route::controller(AdminController::class)->group(function () {
            Route::get('/logout', 'destroy')->name('admin.logout');
            Route::get('/profile', 'Profile')->name('admin.profile');
            Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
            Route::post('/store/profile', 'StoreProfile')->name('store.profile');
        
            Route::get('/change/password', 'ChangePassword')->name('change.password');
            Route::post('/update/password', 'UpdatePassword')->name('update.password');

            // Search Result
            Route::get('/search-result', 'search')->name('search.result');
            Route::get('/search-result-download', 'SearchDownload')->name('search.result.download');

            Route::get('/subscribe-user', 'subscribe_user')->name('subscribe.user');

            Route::get('/admin-setting', 'admin_setting')->name('admin.setting');
            Route::post('/setting/{id}', 'SettingUpdate')->name('admin.setting.update');
            Route::get('/admin/get-subcategories', 'getSubcategories')->name('admin.get.subcategories');

            Route::get('/errorlog/all', 'apiLogs')->name('admin.api.logs'); 
            Route::get('/admin/api-logs/{id}',[AdminController::class, 'apiLogDetails'])->name('admin.api.log.details');

        });
        
        
         // Coupon All Route 
         Route::controller(CouponController::class)->group(function () {
            Route::get('/coupons/all', 'All')->name('coupons.all'); 
            Route::get('/coupons/add', 'Add')->name('coupons.add'); 
            Route::post('/coupons/store', 'Store')->name('coupons.store');
            Route::get('/coupons/edit/{id}', 'Edit')->name('coupons.edit'); 
            Route::post('/coupons/update', 'Update')->name('coupons.update');
            Route::get('/coupons/delete/{id}', 'Delete')->name('coupons.delete');
            Route::get('/coupons/download', 'Download')->name('coupons.download');
        });
        
         // Admin All Route 
        Route::controller(SupplierController::class)->group(function () {
            Route::get('/supplier/all', 'SupplierAll')->name('supplier.all'); 
            Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add'); 
            Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
            Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit'); 
            Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
            Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');
        });
        
        // Sub Category All Route 
         Route::controller(AuthorController::class)->group(function () {
            Route::get('/users/all', 'All')->name('users.all'); 
            Route::get('/users/edit/{id}', 'edit')->name('users.edit'); 
            Route::get('/users/view/{id}', 'details')->name('users.view'); 
            Route::post('/users/update/{id}', 'update')->name('users.store');
            Route::get('/users/delete/{id}', 'Delete')->name('users.delete');
            Route::get('/users/admin-edit-address/{id}', 'admin_edit_address')->name('admin.user.address.edit');
            Route::post('/users/store-address', 'storeAddress')->name('admin.users.store.address');
            Route::get('/users/address/delete/{id}', 'AddressDelete')->name('users.address.delete');
        });
        
         // Category All Route 
         Route::controller(PageController::class)->group(function () {
            Route::get('/pages/all', 'All')->name('pages.all'); 
            Route::get('/pages/edit/{id}', 'Edit')->name('pages.edit'); 
            Route::post('/pages/update', 'Update')->name('pages.update');
        });
        
         // Category All Route 
         Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories/all', 'All')->name('categories.all'); 
            Route::get('/categories/add', 'Add')->name('categories.add'); 
            Route::post('/categories/store', 'Store')->name('categories.store');
            Route::get('/categories/edit/{id}', 'Edit')->name('categories.edit'); 
            Route::post('/categories/update', 'Update')->name('categories.update');
            Route::get('/categories/delete/{id}', 'Delete')->name('categories.delete');
        });
        
         // Sub Category All Route 
         Route::controller(SubcategoryController::class)->group(function () {
            Route::get('/subcategories/all', 'All')->name('subcategories.all'); 
            Route::get('/subcategories/add', 'Add')->name('subcategories.add'); 
            Route::post('/subcategories/store', 'Store')->name('subcategories.store');
            Route::get('/subcategories/edit/{id}', 'Edit')->name('subcategories.edit'); 
            Route::post('/subcategories/update', 'Update')->name('subcategories.update');
            Route::get('/subcategories/delete/{id}', 'Delete')->name('subcategories.delete');
        });
        
         // Child Category All Route 
         Route::controller(ChildcategoryController::class)->group(function () {
            Route::get('/childcategories/all', 'All')->name('childcategories.all'); 
            Route::get('/childcategories/add', 'Add')->name('childcategories.add'); 
            Route::post('/childcategories/store', 'Store')->name('childcategories.store');
            Route::get('/childcategories/edit/{id}', 'Edit')->name('childcategories.edit'); 
            Route::post('/childcategories/update', 'Update')->name('childcategories.update');
            Route::get('/childcategories/delete/{id}', 'Delete')->name('childcategories.delete');
        });
        
        // Sub Category All Route 
        Route::controller(BannerController::class)->group(function () {
            Route::get('/banners/all', 'All')->name('banners.all'); 
            Route::get('/banners/add', 'Add')->name('banners.add'); 
            Route::post('/banners/store', 'Store')->name('banners.store');
            Route::get('/banners/delete/{id}', 'Delete')->name('banners.delete');
        });
        
        
         //Book Conditions All Route 
         Route::controller(LanguageController::class)->group(function () {
            Route::get('/languages/all', 'All')->name('languages.all'); 
            Route::get('/languages/add', 'Add')->name('languages.add'); 
            Route::post('/languages/store', 'Store')->name('languages.store');
            Route::get('/languages/edit/{id}', 'Edit')->name('languages.edit'); 
            Route::post('/languages/update', 'Update')->name('languages.update');
            Route::get('/languages/delete/{id}', 'Delete')->name('languages.delete');
        });
        
         // Binding All Route 
         Route::controller(BindingController::class)->group(function () {
            Route::get('/bindings/all', 'All')->name('bindings.all'); 
            Route::get('/bindings/add', 'Add')->name('bindings.add'); 
            Route::post('/bindings/store', 'Store')->name('bindings.store');
            Route::get('/bindings/edit/{id}', 'Edit')->name('bindings.edit'); 
            Route::post('/bindings/update', 'Update')->name('bindings.update');
            Route::get('/bindings/delete/{id}', 'Delete')->name('bindings.delete');
        });
        
        
        
         //Book Conditions All Route 
         Route::controller(BookConditionController::class)->group(function () {
            Route::get('/book_conditions/all', 'All')->name('book_conditions.all'); 
            Route::get('/book_conditions/add', 'Add')->name('book_conditions.add'); 
            Route::post('/book_conditions/store', 'Store')->name('book_conditions.store');
             
            Route::get('/book_conditions/edit/{id}', 'Edit')->name('book_conditions.edit'); 
            Route::post('/book_conditions/update', 'Update')->name('book_conditions.update');
            Route::get('/book_conditions/delete/{id}', 'Delete')->name('book_conditions.delete');
        });
        
        
        
         //Country Add All Route 
         Route::controller(CountryController::class)->group(function () {
            Route::get('/countries/all', 'All')->name('countries.all'); 
            Route::get('/countries/add', 'Add')->name('countries.add'); 
            Route::post('/countries/store', 'Store')->name('countries.store');
            Route::get('/countries/edit/{id}', 'Edit')->name('countries.edit'); 
            Route::post('/countries/update', 'Update')->name('countries.update');
            Route::get('/countries/delete/{id}', 'Delete')->name('countries.delete');
        });
        
        
        
         //State Add All Route 
         Route::controller(StateController::class)->group(function () {
            Route::get('/states/all', 'All')->name('states.all'); 
            Route::get('/states/add', 'Add')->name('states.add'); 
            Route::post('/states/store', 'Store')->name('states.store');
            Route::get('/states/edit/{id}', 'Edit')->name('states.edit'); 
            Route::post('/states/update', 'Update')->name('states.update');
            Route::get('/states/delete/{id}', 'Delete')->name('states.delete');
        });
        
        //City Add All Route 
        Route::controller(CityController::class)->group(function () {
            Route::get('/cities/all', 'All')->name('cities.all'); 
            Route::get('/cities/add', 'Add')->name('cities.add'); 
            Route::post('/cities/store', 'Store')->name('cities.store');
            Route::get('/cities/edit/{id}', 'Edit')->name('cities.edit'); 
            Route::post('/cities/update', 'Update')->name('cities.update');
            Route::get('/cities/delete/{id}', 'Delete')->name('cities.delete');
            Route::post('/fetch/states', 'FetchStates')->name('fetch-states');
        });
        
        
        
         //Book All Route 
         Route::controller(BookController::class)->group(function () {
            Route::get('/books/all', 'All')->name('books.all'); 
            Route::get('/books/add', 'Add')->name('books.add'); 
            Route::post('/books/store', 'Store')->name('books.store');
            Route::get('/books/edit/{id}', 'Edit')->name('books.edit'); 
            Route::post('/books/update', 'Update')->name('books.update');
            Route::get('/book-attribute/{id}', 'AttributeTest')->name('book_attribute.add');
            Route::post('/books/update/multi', 'AttributeUpdate')->name('books.update.multi');
            Route::get('/books/delete/{id}', 'Delete')->name('books.delete');
            Route::post('crop-image-upload-ajax_gallery', 'AjaxCrop')->name('crop-image-upload-ajax_gallery');
            Route::post('/books_api/store', 'APIBooksStore')->name('api_books.store');

            Route::get('/books/download', 'download_books')->name('books.download.books');
            Route::get('/book-categories/{id}', 'BookDownloadCategories')->name('books.categories.download');
            Route::post('/books/search', 'search')->name('admin.book.search');
            Route::post('/books/multiple-upload', 'BookImportStore')->name('admin.book.multiple.upload');
            Route::get('/books/next-sku', 'nextSku')->name('books.next.sku');
        });
        
         //Author All Route 
         Route::controller(AuthorController::class)->group(function () {
            Route::get('/authors/all', 'All')->name('authors.all'); 
            Route::get('/authors/add', 'Add')->name('authors.add'); 
            Route::post('/authors/store', 'Store')->name('authors.store');
            Route::get('/authors/edit/{id}', 'Edit')->name('authors.edit'); 
            Route::post('/authors/update', 'Update')->name('authors.update');
            Route::get('/authors/delete/{id}', 'Delete')->name('authors.delete');
        
            
        });
        
         //Author All Route 
         Route::controller(BookController::class)->group(function () {
            Route::get('/books/api/all', 'ApiBooksAll')->name('api.books.all'); 
            Route::get('/book/api/edit/{id}', 'ApiEdit')->name('book_api.edit'); 
            
        });
        
        
         //Author All Route 
         Route::controller(CommonController::class)->group(function () {
            Route::post('/subcategories', 'subcategories')->name('common.subcategories.all'); 
            Route::post('/childcategories', 'childcategories')->name('common.childcategories.all'); 
            Route::get('/bindings', 'bindings')->name('common.bindings.all'); 
            Route::get('/bookconditions', 'bookconditions')->name('common.bookconditions.all'); 
            Route::post('/pgredirect', 'pgredirect')->name('common.pgredirect'); 
        });
        
         //Order Add All Route 
         Route::controller(OrderController::class)->group(function () {
            Route::get('/orders/all', 'All')->name('orders.all'); 
            Route::get('/order/{id}', 'Details')->name('order.details'); 
            Route::get('/invoice/{id}', 'invoice_download')->name('invoice.download');
            Route::post('/order/report', 'Report')->name('order.report'); 
            Route::post('/order-shipping', 'shippingDetails')->name('order.shipping.details');
            Route::post('/order-status', 'shippingStatus')->name('order.shipping.status');

            Route::post('/order/search', 'search')->name('admin.order.search');

        });
        
         //ratingreview Add All Route 
         Route::controller(RatingreviewController::class)->group(function () {
            Route::get('/ratingreview/all', 'All')->name('ratingreview.all'); 
            Route::get('/ratingreview/edit/{id}', 'Edit')->name('ratingreview.edit'); 
            Route::post('/ratingreview/update', 'Update')->name('ratingreview.update');
            Route::get('/ratingreview/delete/{id}', 'Delete')->name('ratingreview.delete');
        });

        // Blog Category All Route 
        Route::controller(BlogCategoryController::class)->group(function () {
            Route::get('/blog-category/all', 'All')->name('blog.category.all'); 
            Route::get('/blog-category/add', 'Add')->name('blog.category.add'); 
            Route::post('/blog-category/store', 'Store')->name('blog.category.store');
            Route::get('/blog-category/edit/{id}', 'edit')->name('blog.category.edit');
            Route::get('/blog-category/delete/{id}', 'Delete')->name('blog.category.delete');
        });

        // Blog Author All Route 
        Route::controller(BlogAuthorController::class)->group(function () {
            Route::get('/blog-author/all', 'All')->name('blog.author.all'); 
            Route::get('/blog-author/add', 'Add')->name('blog.author.add'); 
            Route::post('/blog-author/store', 'Store')->name('blog.author.store');
            Route::get('/blog-author/edit/{id}', 'edit')->name('blog.author.edit');
            Route::get('/blog-author/delete/{id}', 'Delete')->name('blog.author.delete');
        });

        // Blog All Route 
        Route::controller(BlogController::class)->group(function () {
            Route::get('/blog/all', 'All')->name('blog.all'); 
            Route::get('/blog/add', 'Add')->name('blog.add'); 
            Route::post('/blog/store', 'Store')->name('blog.store');
            Route::get('/blog/edit/{id}', 'edit')->name('blog.edit');
            Route::get('/blog/delete/{id}', 'Delete')->name('blog.delete');
        });

        Route::controller(BlogController::class)->group(function () {
            Route::get('/blogs-comments', 'AllComments')->name('blog.comments.all'); 
            Route::get('/blog-comment/edit/{id}', 'CommentEdit')->name('blog.comments.edit'); 
            Route::get('/blog-comment/delete/{id}', 'CommentDelete')->name('blog.comment.delete');
            
            Route::post('/blog-comment/update', 'CommentUpdate')->name('blog.comment.edit.store');
        });
        
        
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->middleware(['auth'])->name('dashboard');
        
        // require __DIR__.'/auth.php';
    });
});

Route::get('/google-shopping-feed.xml', [FeedController::class, 'googleShoppingFeed']);
Route::get('/facebook-catalog-feed.php', [FeedController::class, 'facebookCatalogFeed']);

Route::get('/test-global-error', function () {
    throw new \Exception('TEST GLOBAL ERROR - UsedBookr');
});
Route::prefix('admin')->group(function () {

    Route::get('/sku-management', [BookController::class, 'Skuindex'])->name('sku.management');

    Route::post('/sku-management/generate', [BookController::class, 'generate'])->name('sku.generate');

    Route::get('/books/qc/{id}',[BookController::class, 'qcEdit'])->name('books.qc.edit');

    Route::post('/books/qc/approve',[BookController::class, 'approveQc'])->name('books.qc.approve');

    Route::post('/books/qc-approve-selected',[BookController::class, 'ApproveQcSelected'])->name('books.qc.approve.selected');

    Route::post('/books/check-isbn', [BookController::class, 'CheckIsbn'])->name('books.check.isbn');

    Route::post('/admin/books/bulk-images-upload',[BookController::class, 'bulkImagesUpload'])->name('books.bulk.images.upload');
    Route::post('/books/single-bulk-images-upload', [BookController::class, 'singleBookBulkImagesUpload'])->name('books.single.bulk.images.upload');
});