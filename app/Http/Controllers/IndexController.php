<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Books;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Search;
use App\Models\User;
use App\Models\BookCondition;
use App\Models\BookVarient;
use App\Models\Binding;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Orderitem;
use App\Models\Ratingreview;
use App\Models\Page;
use App\Models\AddCart;
use App\Models\Wishlist;
use App\Models\Wallet;
use App\Models\Blog;
use App\Models\BlogAuthor;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Subscripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\TempUser;
use Mail;
use DB;
use Cookie;
use App\Mail\OtpMail;
use App\Models\ApiLog;
use App\Services\SearchService;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiLogHelper;


class IndexController extends Controller
{
    public function __construct
    (
        SearchService $searchservice
    )
    {
        $this->SearchService         = $searchservice;
    }
    public function index()
    {
        
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        
        
        
        $total_product = AddCart::get();
        foreach($total_product as $key => $cart_product)
        {
            $product_details = \App\Models\Book::where('id', $cart_product->book_id)->first();
            if($product_details)
            {
                
            }
            else
            {
                $delete_cart = AddCart::find($cart_product->id);
                $delete_cart->delete();
            }
        }

        
        $wishlist_get = Wishlist::whereNull('user_id')->whereDate('created_at', '<', Carbon::now()->subDays(3))->get();
        
        if(count($wishlist_get))
        {
            foreach($wishlist_get as $key => $wishlist)
            {
                Wishlist::findOrFail($wishlist->id)->forceDelete();
            }
        }
        
        $slider = Banner::where('status', 1)->where('btype', 'S')->latest()->get();
        if($slider)
        {
            $slider = $slider->toArray();
        }
        $slider_m = Banner::where('status', 1)->where('btype', 'M')->latest()->get();
        if($slider_m)
        {
            $slider_m = $slider_m->toArray();
        }
        
        $side_banner = Banner::where('status', 1)->where('btype', 'B')->first();
        if($side_banner)
        {
            $side_banner = $side_banner->toArray();
        }
        
        $side_banner1 = Banner::where('status', 1)->where('btype', 'T')->first();
        if($side_banner1)
        {
            $side_banner1 = $side_banner1->toArray();
        }

        $categories = Category::where('status', 1)->where('level', '!=', 2)->limit(10)->latest()->get();
        if($categories)
        {
            $categories = $categories->toArray();
        }
        $word = "B";
        $best_seller = Book::where('section_id', 'like', '%'.$word.'%')->where('status', 1)->latest()->limit(10)->get();
        if($best_seller)
        {
            $best_seller = $best_seller->toArray();
        }
        $word = "N";
        $new_arrivals = Book::where('section_id', 'like', '%'.$word.'%')->where('status', 1)->latest()->limit(10)->get();
        
        $section_name = "B";
        $before_content = Category::with(['cat_books'])->where('best_seller', 'on')->where('before_content', 'off')->whereHas('cat_books', function ($query) use ($section_name){
            $query->where('section_id', 'like', '%'.$section_name.'%');
        });
        $before_content = $before_content->get();
        
        $section_name = "B";
        $after_content = Category::with(['cat_books'])->where('best_seller', 'on')->where('before_content', 'on');
        $after_content = $after_content->get();
        

        $author_details = DB::table('books')
                            ->select('author', DB::raw('count(*) as total'))
                            ->whereNotNull('author')  // This line filters out null authors
                            ->groupBy('author')
                            ->limit(5)
                            ->get();
        if ($author_details) {
            $author_details = $author_details->toArray();
        }
        
        
        return view('frontend.index', compact('slider','side_banner','categories','best_seller', 'new_arrivals', 'author_details', 'side_banner1', 'after_content', 'before_content', 'slider_m'));
    }

    public function categories(Request $request, $id)
    {
        $sort_by = $request->input('sort_id', '');
        $stock_check = $request->input('stock_check', '');

        $category = Category::where('url_slug', $id)->first();

        if (!$category) {

            ApiLogHelper::log(
                $request,
                'Category',
                'Category List',
                microtime(true),
                'failed',
                404,
                [
                    'category_slug' => $id,
                    'sort_id'       => $sort_by,
                    'stock_check'   => $stock_check,
                ],
                [
                    'total_results' => 0,
                ],
                'category_slug',
                $id,
                'Category not found for slug: ' . $id
            );

            abort(404);
        }

        if ($category->level == 1) {

            $books = Book::where('status', 1)
                ->where('category_id', $category->id);

        } elseif ($category->level == 2) {

            $books = Book::where('status', 1)
                ->where('subcategory_id', $category->id);

        } elseif ($category->level == 3) {

            $books = Book::where('status', 1)
                ->where('childcategory_id', $category->id);

        } else {

            ApiLogHelper::log(
                $request,
                'Category',
                'Category List',
                microtime(true),
                'failed',
                400,
                [
                    'category_slug' => $id,
                    'category_id'   => $category->id,
                    'category_level'=> $category->level,
                ],
                null,
                'category_id',
                $category->id,
                'Invalid category level: ' . $category->level
            );

            abort(400);
        }

        switch ($sort_by) {

            case 'alphp_a':

                $books->orderBy('name', 'ASC');

                break;


            case 'alphp_z':

                $books->orderBy('name', 'DESC');

                break;


            case 'low_to_hight':

                $books->orderBy('selling_price', 'ASC');

                break;


            case 'hight_to_low':

                $books->orderBy('selling_price', 'DESC');

                break;


            case 'latest':
            default:

                $books->latest();

                break;
        }


        if ($stock_check) {

            $books->whereHas('varients', function ($query) {

                $query->where('stock', '!=', 0);

            });
        }

        $books = $books->paginate(52);

        $expertusersid_arr = [];

        foreach ($books as $book) {

            $expertusersid_arr[] = $book->id;
        }

        if ($books->isEmpty()) {

            ApiLogHelper::log(
                $request,
                'Category',
                'Category List',
                microtime(true),
                'failed',
                200,
                [
                    'category_slug'  => $id,
                    'category_id'    => $category->id,
                    'category_level' => $category->level,
                    'sort_id'        => $sort_by,
                    'stock_check'    => $stock_check,
                ],
                [
                    'total_results' => 0,
                ],
                'category_id',
                $category->id,
                'No books found for this category'
            );
        }

        return view(
            'frontend.categories_list',
            compact(
                'category',
                'books',
                'sort_by',
                'expertusersid_arr',
                'id',
                'stock_check'
            )
        );
    }

    public function productdetails(Request $request, $cat_slu, $id)
    {
        $value_1 = [];

        $books = Books::where('url_slug', $id)
            ->where('status', 1)
            ->with([
                'varients',
                'category',
                'review',
                'review.customer',
                'product_category',
                'product_sub_category',
                'product_child_category',
                'categories'
            ])
            ->first();

     
        if (!$books) {

            ApiLogHelper::log(
                $request,
                'Product',
                'Product Details',
                microtime(true),
                'failed',
                404,
                [
                    'category_slug' => $cat_slu,
                    'product_slug'  => $id,
                ],
                [
                    'total_results' => 0,
                    'message'       => 'Product not found',
                ],
                'product_slug',
                $id,
                'Product not found for slug: ' . $id
            );

            abort(404);
        }

 
        $books = $books->toArray();



        if (!empty($books['varients'])) {

            foreach ($books['varients'] as $value) {

                if (isset($value['bookconditions'])) {
                    $value_1[] = $value['bookconditions'];
                }
            }
        }


        if (!empty($value_1)) {
            $value_1 = array_unique($value_1);
        }



        $related_books = Book::where(
                'childcategory_id',
                $books['childcategory_id']
            )
            ->whereNotIn('id', [$books['id']])
            ->where('status', 1)
            ->limit(10)
            ->get();



        $book_details = Books::where('url_slug', $id)
            ->where('status', 1)
            ->with([
                'varients',
                'category',
                'review',
                'review.customer',
                'product_category',
                'product_sub_category',
                'product_child_category',
                'categories'
            ])
            ->first();


        $route = route(
            'product.details',
            [
                $books['categories']['url_slug'] ?? '',
                $books['url_slug'] ?? ''
            ]
        );



        $share_buttons = \ShareButtons::page(
                $route,
                'Page title',
                [
                    'title' => $books['name'],
                    'rel'   => 'nofollow noopener noreferrer',
                ]
            )
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->copylink()
            ->mailto()
            ->getRawLinks();
                

        return view(
            'frontend.productdetails',
            compact(
                'books',
                'value_1',
                'related_books',
                'share_buttons',
                'book_details'
            )
        );
    }
    public function productattr(Request $request) 
    {
        // dd($request->all());
        $binding_value  = $request->binding_value;
        $product_id     = $request->product_id;
        $result = "";
        $productattr = BookVarient::where('book_id', $product_id)->where('bindings', $binding_value)->get();
        if (count($productattr) > 0) {
            foreach ($productattr as $key => $attr) {
                $result .= '<div class="col-md-2" id="binding1">
                <div class="address-card-shipping product_details h-auto mb-3">
                    <input class="radio-button" type="radio" name="attr2" onclick="amount('.$attr->id.')" value="'.$attr->bookconditions.'" required>
                    <div class="radio-tile front_style" style="padding: 10px;text-align: center;">
                    <div>
                        '.$attr->bookconditions.'
                    </div>
                    </div>
                </div>
            </div>';
            }
        }
        return $result;
    }

    public function product_attr_price(Request $request)
    {
        // dd($request->all());
        $html           = '';
        $id             = $request->id;
        $product_id     = $request->product_id;
        $product_details = Books::where('id', $product_id)->first();
        $productattr = BookVarient::where('book_id', $product_id)->where('bookconditions', $id)->first();
        // dd($productattr);
        if ($productattr) {
            $data['price'] = $productattr->price;
            $data['stock'] = $productattr->stock;
            
            $url_link = url('/');
            if ($image_count = json_decode($productattr->images)) {
                foreach($image_count as $key => $image)
                {
                    if ($key == 0) {
                        $html .= '<div class="owl-item active cloned" style="width: 582.088px;"><div class="item">
                                 <div class="img-box">
                                 <img src="'.$url_link.'/public/images/'.$image.'" />
                                 </div>
                              </div></div>';
                    }
                    else
                    {
                        $html .= '<div class="owl-item cloned" style="width: 582.088px;"><div class="item">
                                 <div class="img-box">
                                 <img src="'.$url_link.'/public/images/'.$image.'" />
                                 </div>
                              </div></div>';   
                    }
                }
            }
            $data['multiple_image'] = $html;
            $data['multiple_image1'] = $html;
            $data['message'] = "success";
        }
        else {
            $data['message'] = "error";
        }

        return $data;
    }

    public function productattr1(Request $request) 
    {
        $binding_value  = $request->binding_value;
        $product_id     = $request->product_id;
        $product_details = Books::where('id', $product_id)->first();
        $productattr = BookVarient::where('book_id', $product_id)->where('bookconditions', $binding_value)->first();
        $percent = 0;
        if($product_details->original_price != $product_details->selling_price)
        {
            $percent = (($product_details->original_price - $productattr->price)*100) /$product_details->original_price;
            $percent = round($percent, 2);
        }
        $result['percent'] = $percent;
        $result['stock'] = $productattr->stock;
        $result['amount'] = $productattr->price;
        return $result;
    }

    public function productbinding(Request $request) 
    {
        $binding_value  = $request->binding_value;
        $product_id     = $request->product_id;
        $result = "";
        $productattr = BookVarient::where('book_id', $product_id)->where('bookconditions', $binding_value)->first();
        if ($productattr) {
            $productattr = $productattr->toArray();
        }
        $product_price = number_format($productattr['price'], 2);
        return $product_price;
        
    }

    public function aboutus()
    {
        $pages = Page::where('id', 1)->first();
        return view('frontend.aboutus', compact('pages'));
    }

    public function contactus()
    {
        return view('frontend.contectus');
    }

    public function CategoryList()
    {
        $categories = Category::where('status', 1)->latest()->get();
        if($categories)
        {
            $categories = $categories->toArray();
        }

        return view('frontend.category', compact('categories'));
    }

    public function userOtplogin()
    {
        
        return view('frontend.otp_login');
    }

    public function user_otp_login(Request $request)
    {
        if (filter_var($request->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->phone_or_email)->first();
        }
        else
        {
            $user = User::where('phone_number', $request->phone_or_email)->first();
        }
        
        if ($user)
        {
            $otp        = rand(1000,9999);
            $phone      = $user->phone_number;
            $email      = $user->email;
            $message    = $otp;
            $type       = "forget_password";
            $response   = login_otp_send($phone, $otp, $type);
            
            // if ($response === true) {
            //     $user->otp = $otp;
            //     $user->save();
            // } else {
            //     $user->otp = null;
            //     $user->save();
            // }
            
            $user->otp = $otp;
            $user->save();

            $otp_mail = [
                'title' => 'Login OTP for UsedBookR',
                'otp' => "Your login OTP is $otp valid for 10 minutes.Visit Usedbookr.com to buy books at 40%-70%! Install SimplySellBooks app to sell! UsedBookR",
                'email' => $email,
                'name' => $user->name
            ];
            
            try{
                Mail::send('mail.OtpMail', $otp_mail, function($message)use($otp_mail) {
                    $message->to($otp_mail['email'], $otp_mail['name'])
                        ->from("noreplywebbitech@gmail.com", 'no-reply')
                    ->subject('Mail OTP');
                });
            }
            catch(\Exception $e){
                \Log::info($e);
                // dd($e);
            }
            return redirect()->route('user.get.otp', base64_encode($user->id))->with('success', 'OTP sent to Email and Mobile');
            // return view('frontend.get_otp',compact('user'))->with('success', 'OTP send successfully');
        }
        else
        {
            return redirect()->route('user.register')->with('error', 'Account does not exist for this email or phone!');
        }
    }

    public function get_otp($id)
    {
        $id = base64_decode($id);
        $user = User::where('id', $id)->first();

        return view('frontend.get_otp',compact('user'));
    }

    public function resend_otp(Request $request) 
    {
        
        $otp        = rand(1000,9999);
        
        // dd($user);
        $user = user::where('id',$request->id)->first();
        $phone      = $user->phone_number;
        $user->otp = $otp;
        $email      = $user->email;
        $message    = $otp;
        $type       = "forget_password";
        $response   = login_otp_send($phone, $otp, $type);
        
        $user->save();
        
        $otp_mail = [
            'title' => 'Resend OTP for UsedBookR',
            'otp' => "Your login OTP is $otp valid for 10 minutes.Visit Usedbookr.com to buy books at 40%-70%! Install SimplySellBooks app to sell! UsedBookR",
            'email' => $email,
            'name' => $user->name
        ];
        
        try{
            Mail::send('mail.OtpMail', $otp_mail, function($message)use($otp_mail) {
                $message->to($otp_mail['email'], $otp_mail['name'])
                    ->from("noreplywebbitech@gmail.com", 'no-reply')
                ->subject('Mail OTP');
            });
        }
        catch(\Exception $e){
            \Log::info($e);
            // dd($e);
        }
          
        return response()->json(['success' => 'OTP resent successfully to Mobile and Email', 'user' => $user]);
    }

    public function new_resend_otp(Request $request) 
    {
        
        $otp        = rand(1000,9999);
        
        // dd($user);
        $user = TempUser::where('id',$request->id)->first();
        $phone      = $user->phone;
        $user->verification_code = $otp;
        $email      = $user->email;
        $message    = $otp;
        $type       = "forget_password";
        $response   = login_otp_send($phone, $otp, $type);
        
        $user->save();
        
        $otp_mail = [
            'title' => 'Resend OTP for UsedBookR',
            'otp' => "Your login OTP is $otp valid for 10 minutes.Visit Usedbookr.com to buy books at 40%-70%! Install SimplySellBooks app to sell! UsedBookR",
            'email' => $email,
            'name' => $user->name
        ];
        
        try{
            Mail::send('mail.OtpMail', $otp_mail, function($message)use($otp_mail) {
                $message->to($otp_mail['email'], $otp_mail['name'])
                    ->from("noreplywebbitech@gmail.com", 'no-reply')
                ->subject('Mail OTP');
            });
        }
        catch(\Exception $e){
            \Log::info($e);
            // dd($e);
        }
          
        return response()->json(['success' => 'OTP resent successfully to Mobile and Email', 'user' => $user]);
    }

    public function check_user_otp(Request $request)
    {
        // dd($request->all());
        $verification_code = implode('', $request->otp);

        $user = User::where('otp',$verification_code)->where('id',$request->user_id)->first();
        // dd($user);
        if ($user)
        {
            $user->save();
            Auth::login($user);
            $redrick = session()->get('temp_redri_id');
            AddCart::where('user_id', auth()->user()->id)
                    ->update([
                        'buy_now' => 0
                    ]);

            if (session()->get('temp_user_id') != null) {
                AddCart::where('temp_user_id', session()->get('temp_user_id'))
                    ->update([
                        'user_id' => auth()->user()->id,
                        'temp_user_id' => null
                    ]);

                \Session::forget('temp_user_id');
            }
            
            if (session()->get('temp_wish_id') != null) {
                Wishlist::where('temp_wish_id', session()->get('temp_wish_id'))
                    ->update([
                        'user_id' => auth()->user()->id,
                        'temp_wish_id' => null
                    ]);

                \Session::forget('temp_wish_id');
            }
            $refferal_number = "";
            
            $check_buy = AddCart::where('user_id', auth()->user()->id)->where('buy_now', 1)->first();
            $reffer_check = true;
            $code_check = User::where('referral_number', session()->get('refferal_number_name'))->first();
            $InvalidCoupon3 = "";
            
            $order_details = Order::where('user_id', Auth::user()->id)->where('refferal_number_name', session()->get('refferal_number_name'))->count();
            $results = Order::where('user_id', Auth::user()->id)->whereNotNull('refferal_number_name')->first();
            
            $refe_check = refercheck(session()->get('refferal_number_name'), Auth::user()->id);
            // dd($refe_check);
            
            if($refe_check)
            {
                $InvalidCoupon3 = $refe_check;
                session()->put('refferal_number_name', '');
                session()->put('refferal_number_amount', '');
            }
            else if($results)
            {
                $InvalidCoupon3 = "You are Already Refferal code using Placed one Order";
                session()->put('refferal_number_name', '');
                session()->put('refferal_number_amount', '');
            }
            else if($order_details > 0)
            {
                $InvalidCoupon3 = "You are Already use this code";
                session()->put('refferal_number_name', '');
                session()->put('refferal_number_amount', '');
            }
            else
            {
                
            }
            
            if ($code_check) 
            {
                if(Auth::check() && $code_check->id == Auth::user()->id)
                {
                    $InvalidCoupon3 = "You are not using your referral code";
                    session()->put('refferal_number_name', '');
                    session()->put('refferal_number_amount', '');
                    $reffer_check = false;
                }
                else if(Auth::check())
                {
                    $order_details = Order::where('refferal_number_name', $code_check->referral_number)->count();
                    if($order_details > 0)
                    {
                        $reffer_check = false;
                        $InvalidCoupon3 = "";
                        session()->put('refferal_number_name', '');
                        session()->put('refferal_number_amount', '');
                    }
                }
            }
            
            // dd($InvalidCoupon3);
            
            $track_ord =   session()->get('track_order');
            
            if($track_ord == "track order page")
            {
                return redirect()->route('user.order')->with('success', 'You are logged in successfully');
            }
            
            if($check_buy)
            {
                if($reffer_check)
                {
                    return redirect('/user/checkout')->with('success', 'Please select the Address');
                }
                else
                {
                    return redirect('/user/checkout')->with('error', $InvalidCoupon3);
                }
                
            }
            
            if($reffer_check)
            {
                return redirect()->route('user.profile')->with('success', 'You are logged in successfully');
            }
            elseif($InvalidCoupon3)
            {
                return redirect()->route('user.profile')->with('error', $InvalidCoupon3);
            }
            else
            {
                return redirect()->route('user.profile')->with('success', 'You are logged in successfully');
            }
            
            
        }
        else
        {
            $user = User::where('id',$request->user_id)->first();

            return redirect()->route('user.get.otp', base64_encode($user->id))->with('error', 'Verification code does not match!!');
            // return redirect()->route('user.profile')->with('error', 'Verification code does not match!!');
        }
    }

    public function ModelRender(Request $request) 
    {
        // dd($request->all());
        $value_1 = [];
        $id = $request->product_id;
        $books = Books::where('id', $id)->with(['varients'])->first();
        // dd($books);
        if($books)
        {
            $books = $books->toArray();
        }
        if (count($books['varients']) > 0) {
            foreach ($books['varients'] as $key => $value) {
                $value_1[] = $value['bookconditions'];
            }
        }
        if ($value_1) {
            $value_1 = array_unique($value_1);
        }
        $image_slider = \App\Models\BookVarient::where('book_id', $books['id'])->where('bookconditions', $value_1[0])->first();
        $stock_number = $image_slider->stock;
        $gst_amount_var = $image_slider->price;
        $percent = 0;
        if($books['original_price'] != $books['selling_price'])
        {
            $percent = (($books['original_price'] - $image_slider->price)*100) /$books['original_price'];
            $percent = round($percent, 2);
        }
        $view =  view('frontend.modelrender', compact('books', 'value_1', 'image_slider', 'stock_number', 'gst_amount_var', 'percent'))->render();
        return response()->json(['html'=>$view]);
    }

    public function addTocard(Request $request)
    {
        // dd($request->all());
        $attr_price = 0;
        if (!Auth::check()) {

            if($request->session()->get('temp_user_id')) {
                $temp_user_id = $request->session()->get('temp_user_id');
            } else {
                $temp_user_id = bin2hex(random_bytes(10));
                $request->session()->put('temp_user_id', $temp_user_id);
            }


            $check_cart = AddCart::where('temp_user_id', $temp_user_id)->where('book_id',$request->product_id)->where('binding',$request->attr1)->first();

            if ($request->buy_now == "Buy Now") {
                if($check_cart)
                {
                    $delete_cart = AddCart::find($check_cart->id);
                    $delete_cart->delete();
                }
            }
            $check_cart = AddCart::where('temp_user_id', $temp_user_id)->where('book_id',$request->product_id)->where('binding',$request->attr1)->first();
            if ($check_cart) {
                return redirect()->back()->with('error', 'Product Already in Basket');
            }
            else
            {
                AddCart::where('temp_user_id', $temp_user_id)
                        ->update(
                                [
                                    'buy_now' => null
                                ]
                );
                $product = Books::findOrFail($request->product_id);
                if ($request->attr1) {
                    $productattr = BookVarient::where('book_id', $request->product_id)->where('bookconditions', $request->attr1)->first();
                    $attr_stock = $productattr->stock;
                    if ($attr_stock != 0 && $attr_stock > 0) {
                        $add_to_cart = new AddCart();
                        $add_to_cart->temp_user_id     = $temp_user_id;
                        $add_to_cart->book_id          = $request->product_id;
                        $add_to_cart->name             = $product->name;
                        $add_to_cart->quantity         = 1;
                        $add_to_cart->original_price   = $product->original_price;
                        $add_to_cart->gst              = $product->gst_charge;
                        $add_to_cart->price            = $productattr->price;
                        $add_to_cart->image            = $product->image;
                        $add_to_cart->binding          = $request->attr1;
                        $add_to_cart->condition        = $request->attr2;
                        $add_to_cart->book_weight      = $productattr->book_weight;
                        if ($request->buy_now == "Buy Now") {
                            $add_to_cart->buy_now        = 1;
                        }
                        $add_to_cart->save();
                        // dd($add_to_cart);
                        if ($request->buy_now == "Buy Now") {
                            if (Auth::check() && Auth::user()->user_type == 'user')
                            {
                                if(session('coupen_name'))
                                {
                                    session()->put('coupen_name', "");
                                    session()->put('coupen_amount', "");
                                    return redirect()->route('user.checkout')->with('success', 'Please select the Address... Please reapply  the coupen');
                                }
                                return redirect()->route('user.checkout')->with('success', 'Please select the Address... Please reapply  the coupen');
                            }
                            else
                            {
                                if(session('coupen_name'))
                                {
                                    session()->put('coupen_name', "");
                                    session()->put('coupen_amount', "");
                                    return redirect()->route('user.checkout')->with('success', 'Product added to cart successfully!... Please reapply  the coupen');
                                }
                                return redirect()->route('user.checkout')->with('success', 'Product added to cart successfully!');
                            }
                        }
                        if(session('coupen_name'))
                        {
                            session()->put('coupen_name', "");
                            session()->put('coupen_amount', "");
                            return redirect()->back()->with('success', 'Product added to cart successfully!... Please reapply  the coupen');
                        }
                        return redirect()->back()->with('success', 'Product added to cart successfully!');
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'No Stock Available');
                    }
                    
                }
            }
        }
        else
        {
            $check_cart = AddCart::where('user_id',Auth::user()->id)->where('book_id',$request->product_id)->where('binding',$request->attr1)->first();
            if ($request->buy_now == "Buy Now") {
                if($check_cart)
                {
                    $delete_cart = AddCart::find($check_cart->id);
                    $delete_cart->delete();
                }
            }
            $check_cart = AddCart::where('user_id',Auth::user()->id)->where('book_id',$request->product_id)->where('binding',$request->attr1)->first();
            if ($check_cart) {
                return redirect()->back()->with('error', 'Product Already in Basket');
            }
            else
            {
                AddCart::where('user_id', Auth::user()->id)
                        ->update(
                                [
                                    'buy_now' => null
                                ]
                );
                $product = Books::findOrFail($request->product_id);
                if ($request->attr1) {
                    $productattr = BookVarient::where('book_id', $request->product_id)->where('bookconditions', $request->attr1)->first();
                    $attr_stock = $productattr->stock;
                    if ($attr_stock != 0 && $attr_stock > 0) {
                        if (Auth::check() && Auth::user()->user_type == 'user') 
                        {
                            $add_to_cart = new AddCart();
                            $add_to_cart->user_id          = Auth::user()->id;
                            $add_to_cart->book_id          = $request->product_id;
                            $add_to_cart->name             = $product->name;
                            $add_to_cart->quantity         = 1;
                            $add_to_cart->original_price   = $product->original_price;
                            $add_to_cart->gst              = $product->gst_charge;
                            $add_to_cart->price            = $productattr->price;
                            $add_to_cart->image            = $product->image;
                            $add_to_cart->binding          = $request->attr1;
                            $add_to_cart->condition        = $request->attr2;
                            $add_to_cart->book_weight      = $productattr->book_weight;
                            if ($request->buy_now == "Buy Now") {
                                $add_to_cart->buy_now        = 1;
                            }
                            $add_to_cart->save();
                            if ($request->buy_now == "Buy Now") {
                                if (Auth::check() && Auth::user()->user_type == 'user')
                                {
                                    session()->put('coupen_name', "");
                                    session()->put('coupen_amount', "");
                                    if(session('coupen_name'))
                                    {
                                        session()->put('coupen_name', "");
                                        session()->put('coupen_amount', "");
                                        return redirect()->route('user.checkout')->with('success', 'Please select the Address... Please reapply  the coupen');
                                        // return redirect()->back()->with('success', 'Product added to cart successfully!... Please reapply  the coupen');
                                    }
                                    return redirect()->route('user.checkout')->with('success', 'Please select the Address');
                                }
                                else
                                {
                                    if(session('coupen_name'))
                                    {
                                        session()->put('coupen_name', "");
                                        session()->put('coupen_amount', "");
                                        return redirect()->back()->with('success', 'Product added to cart successfully!... Please reapply  the coupen');
                                    }
                                    return redirect()->route('user.checkout')->with('success', 'Product added to cart successfully!');
                                }
                            }
                            if(session('coupen_name'))
                            {
                                session()->put('coupen_name', "");
                                session()->put('coupen_amount', "");
                                return redirect()->back()->with('success', 'Product added to cart successfully!... Please reapply  the coupen');
                            }
                            return redirect()->back()->with('success', 'Product added to cart successfully!');
                        }
                        else
                        {
                            return redirect()->back()->with('error', 'Please login First');
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'No Stock Available');
                    }
                    
                }
            }
        }
        
        
        
        // $cart = session()->get('cart', []);
  
        // $cart[$request->product_id] = [
        //     "name" => $product->name,
        //     "quantity" => 1,
        //     "original_price" => $product->original_price,
        //     "gst" => $product->gst_charge,
        //     "price" => $attr_price,
        //     "image" => $product->image,
        //     "binding" => $request->attr1,
        //     "condition" => $request->attr2
        // ];
          
        // session()->put('cart', $cart);
        
        // else
        // {
        //     return redirect()->back()->with('success', 'Product added to cart successfully!');
        // }
        
    }

    public function viewcart()
    {
        $temp_user_id = "";

        if (session()->get('temp_user_id')) {
            $temp_user_id = session()->get('temp_user_id');
        }
        if (auth()->check()) {

            $user_id = Auth::user()->id;
            if (session()->get('temp_user_id')) {

                AddCart::where(
                    'temp_user_id',
                    session()->get('temp_user_id')
                )->update([
                    'user_id' => $user_id,
                    'temp_user_id' => null,
                    'buy_now' => null
                ]);

                session()->forget('temp_user_id');

            } else {
                AddCart::where(
                    'user_id',
                    $user_id
                )->update([
                    'buy_now' => null
                ]);
            }
            $cart_book = AddCart::where(
                'user_id',
                $user_id
            )->get();


        } else {
            $temp_user_id = session()->get('temp_user_id');

            $cart_book = $temp_user_id
                ? AddCart::where(
                    'temp_user_id',
                    $temp_user_id
                )->get()
                : collect();
        }
        return view(
            'frontend.cart',
            compact('cart_book')
        );
    }
    public function viewWhislist()
    {
        $temp_wish_id = "";
        $wishlist_product = "";
        if(Session()->get('temp_wish_id')) {
            $temp_wish_id = Session()->get('temp_wish_id');
        }
        
        if (Auth::check() && Auth::user()->user_type == 'user') 
        {
            $wishlist_product = Wishlist::where('user_id', Auth::user()->id)->with(['product', 'customer', 'product.varients'])->get();
        }
        elseif ($temp_wish_id) 
        {
            $wishlist_product = Wishlist::where('temp_wish_id', $temp_wish_id)->with(['product', 'customer', 'product.varients'])->get();
        }
        // dd($wishlist_product);
        return view('frontend.wishlist', compact('wishlist_product'));
    }

    // public function updatecart(Request $request)
    // {
    //     // dd($request->all());

    //     if ($request->id) {
    //         $list_wishlist = AddCart::where('id', $request->id)->first();
    //     }
    //     // dd($list_wishlist);

    //     if ($list_wishlist->binding) {
    //         $productattr = BookVarient::where('book_id', $list_wishlist->book_id)->where('bookconditions', $list_wishlist->binding)->first();
    //     }
        
    //     // dd($productattr);
    //     if ($request->action1 == "minus") {
    //         if ($list_wishlist->quantity == 1) {
    //             session()->put('coupen_name', "");
    //             session()->put('coupen_amount', "");
    //             session()->flash('error', 'Minimum One Quantity added the cart');
    //         }
    //         else {
    //             $stock = $request->quantity - 1;
    //             // dd($stock);
    //             $stock1 = AddCart::findOrFail($request->id);
    //             $stock1->quantity = $stock;
    //             $stock1->save();
    //             // $list_wishlist = AddCart::where('id', $request->id)->update(['quantity', $stock]);
    //             session()->put('coupen_name', "");
    //             session()->put('coupen_amount', "");
    //             session()->flash('success', 'Cart updated successfully');
    //         }
    //     }
    //     else
    //     {   
    //         if ($productattr->stock <= $request->quantity) {
    //             session()->put('coupen_name', "");
    //             session()->put('coupen_amount', "");
    //             session()->flash('error', 'Only '.$productattr->stock.' books available');
    //         }
    //         else {
    //             $stock = $request->quantity + 1;
    //             // dd($stock);
    //             $stock1 = AddCart::findOrFail($request->id);
    //             $stock1->quantity = $stock;
    //             $stock1->save();
    //             session()->put('coupen_name', "");
    //             session()->put('coupen_amount', "");
    //             session()->flash('success', 'Cart updated successfully');
    //         }
            
    //     }
    // }
    public function updatecart(Request $request)
    {
        if (!$request->id) {
            return response()->json([
                'success' => false,
                'message' => 'Cart ID is required.'
            ], 400);
        }
        $list_wishlist = AddCart::where('id', $request->id)->first();

        if (!$list_wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ], 404);
        }

        $productattr = null;
        if ($list_wishlist->binding) {
            $productattr = BookVarient::where('book_id', $list_wishlist->book_id)
                ->where('bookconditions', $list_wishlist->binding)
                ->first();
        }

        $current_stock = $productattr ? $productattr->stock : 0;

        if ($request->action1 == "minus") {
            if ($list_wishlist->quantity <= 1) {
                session()->put('coupen_name', "");
                session()->put('coupen_amount', "");
                session()->flash('error', 'Minimum One Quantity added to the cart');
                
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum quantity reached.',
                    'available_stock' => $current_stock 
                ]);
            } else {
                $list_wishlist->quantity = $list_wishlist->quantity - 1;
                $list_wishlist->save();

                session()->put('coupen_name', "");
                session()->put('coupen_amount', "");
                session()->flash('success', 'Cart updated successfully');
            }
        } 
        else {   
            if ($productattr && $productattr->stock <= $list_wishlist->quantity) {
                session()->put('coupen_name', "");
                session()->put('coupen_amount', "");
                
                session()->flash('error', 'Only ' . $productattr->stock . ' books available');
                
                return response()->json([
                    'success' => false,
                    'is_out_of_stock' => true, 
                    'message' => 'Only ' . $productattr->stock . ' books available',
                    'available_stock' => $current_stock
                ]);
            } else {
                $list_wishlist->quantity = $list_wishlist->quantity + 1;
                $list_wishlist->save();

                session()->put('coupen_name', "");
                session()->put('coupen_amount', "");
                session()->flash('success', 'Cart updated successfully');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'available_stock' => $current_stock
        ]);
    }

    public function decreasecart(Request $request)
    {
        // dd($request->all());
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity - 1;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function deletecart(Request $request)
    {
        // dd($request->all());

        $delete_file = \App\Models\AddCart::find($request->id);
        $delete_check = $delete_file->delete();
        if($delete_check) {
            
            if(session('coupen_name'))
            {
                session()->put('coupen_name', "");
                session()->put('coupen_amount', "");
                session()->flash('error', 'Product removed successfully... Please reapply  the coupen');
            }
                                
            session()->flash('error', 'Product removed successfully');
        }
    }

    public function couponcheck(Request $request)
    {
        // ── Cast all incoming amounts to float immediately ──────────
        $refferal_number_amount = (float) ($request->refferal_number_amount ?? 0);
        $payment_method_amount  = (float) ($request->payment_method_amount  ?? 0);
        $wallet_remain_amount   = (float) ($request->wallet_remain_amount   ?? 0);
        $wallet_using_amount    = (float) ($request->wallet_using_amount    ?? 0);
        $extra_shipping_amount  = (float) ($request->extra_shipping_amount  ?? 0);
        $shipping               = (float) ($request->shiping                ?? 0);
        $cartSubtotal           = (float) ($request->total                  ?? 0);
        $gst_add                = (float) ($request->gst_add                ?? 0);
    
        // ── Helper: build error response (no coupon applied) ────────
        $errorResponse = function (string $msg) use (
            $cartSubtotal, $shipping, $gst_add,
            $refferal_number_amount, $payment_method_amount,
            $wallet_remain_amount, $wallet_using_amount,
            $extra_shipping_amount
        ) {
            // BUG 1 FIX: total returned here does NOT include shipping yet
            // (shipping is shown separately on the shipping screen)
            $total = $cartSubtotal
                + $gst_add
                - $refferal_number_amount
                + $payment_method_amount
                + $wallet_remain_amount
                + $extra_shipping_amount
                - $wallet_using_amount;
    
            return response()->json([
                'coupen_amount'          => number_format(0, 2),
                'coupen_amount_raw'      => 0,
                'payment_method_amount'  => number_format($payment_method_amount, 2),
                'total_before_shipping'  => number_format($total, 2),   // subtotal without shipping
                'total'                  => number_format($total + $shipping, 2), // with shipping
                'shipping'               => number_format($shipping, 2),
                'free_shipping'          => false,
                'refferal_number_amount' => number_format($refferal_number_amount, 2),
                'coupon_code'            => '',
                'status1'                => $msg,
                'item_results'           => [],
            ]);
        };
    
        // ============================================================
        // STEP 1 — COUPON EXISTS & ACTIVE
        // ============================================================
        $coupon = Coupon::where('name', $request->coupon_val)
            ->where('status', 1)
            ->first();
    
        if (!$coupon) {
            return $errorResponse('Invalid Coupon Code');
        }
    
        // ============================================================
        // STEP 2 — DATE VALIDATION
        // ============================================================
        if (!$coupon->all_time) {
            $now = now();
            if (
                (!empty($coupon->start_date) && $now < $coupon->start_date) ||
                (!empty($coupon->end_date)   && $now > $coupon->end_date)
            ) {
                return $errorResponse('Coupon expired or not yet active');
            }
        }
    
        // ============================================================
        // STEP 3 — 1ST TIME BUYER CHECK  (BUG 2 FIX)
        // Runs on APPLY and on every re-check (same function, always)
        // ============================================================
        // if (!empty($coupon->first_time_buyer) && $coupon->first_time_buyer == 1) {
        // if (Auth::check()) {
        //     $previousOrders = Order::where('user_id', Auth::id())
        //         ->whereNotIn('order_status', ['Cancelled'])
        //         ->count();

        //     if ($previousOrders > 0) {
        //         return $errorResponse('This coupon is valid for first-time buyers only');
        //     }
        // }
        // }
        $previousOrders = 0; 

        // if (Auth::check()) {
        //     // Ellapoathum previous orders ethanai nu count eduthu vaipom
        //     $previousOrders = Order::where('user_id', Auth::id())
        //         ->whereNotIn('order_status', ['Cancelled'])
        //         ->count();
        //     // Intha coupon "First Time Buyer" coupon ah irunthaal mattum check seiyum
        //     if (!empty($coupon->first_time_buyer) && $coupon->first_time_buyer == 1) {
        //         if ($previousOrders > 0) {
        //             return $errorResponse('This coupon is valid for first-time buyers only');
        //         }
        //     }
        // }
        // 29-06-2026 urgent change manual refer and remove
        $incomingCouponName = strtoupper(trim($request->coupon_val));

        if (!empty($coupon->first_time_buyer) && $coupon->first_time_buyer == 1) {
            if (Auth::check()) {
                $previousOrders = Order::where('user_id', Auth::id())
                    ->whereNotIn('order_status', ['Cancelled'])
                    ->count();
                
                if ($previousOrders > 0) {
                    return $errorResponse('This coupon is valid for first-time buyers only');
                }
            } else {
                // User login pannala aana ithu first-time buyer coupon na direct-ah prompt panniralam
                return $errorResponse('Please log in to apply this first-time buyer coupon');
            }
        }
    
        // ============================================================
        // STEP 4 — USER USAGE LIMIT CHECK
        // ============================================================
        if (Auth::check() && !empty($coupon->coupon_limit_user)) {
            $couponUsedCount = Order::where('user_id', Auth::id())
                ->where('coupen_name', $request->coupon_val)
                ->count();
    
            if ($couponUsedCount >= $coupon->coupon_limit_user) {
                return $errorResponse('You have reached the usage limit for this coupon');
            }
        }
    
        // ============================================================
        // STEP 5 — MINIMUM ORDER VALUE CHECK (on subtotal, before shipping)
        // ============================================================
        if (!empty($coupon->amount) && $cartSubtotal < (float) $coupon->amount) {
            return $errorResponse('Minimum order value for this coupon is ₹' . $coupon->amount);
        }
    
        // ============================================================
        // STEP 6 — DECODE RESTRICTION LISTS ONCE
        // ============================================================
    
        // Included product IDs (SKU-level, BUG 4)
        $couponProducts = [];
        if (!empty($coupon->product_ids)) {
            $decoded = json_decode($coupon->product_ids, true);
            $couponProducts = is_array($decoded)
                ? array_map('strval', $decoded)
                : array_map('strval', array_map('trim', explode(',', $coupon->product_ids)));
        }
    
        // Excluded product IDs
        $excludedProducts = [];
        if (!empty($coupon->exclusion_product_ids)) {
            $decoded = json_decode($coupon->exclusion_product_ids, true);
            $excludedProducts = is_array($decoded)
                ? array_map('strval', $decoded)
                : array_map('strval', array_map('trim', explode(',', $coupon->exclusion_product_ids)));
        }
    
        // Author IDs (BUG 5)
        $couponAuthorIds = [];
        if (!empty($coupon->author_ids)) {
            $decoded = json_decode($coupon->author_ids, true);
            $couponAuthorIds = is_array($decoded)
                ? array_map('strval', $decoded)
                : array_map('strval', array_map('trim', explode(',', $coupon->author_ids)));
        }
        // Book condition IDs
        $couponConditions = [];
        if (!empty($coupon->book_condition_ids)) {
            $decoded = json_decode($coupon->book_condition_ids, true);
            $couponConditions = is_array($decoded)
                ? array_map('strval', $decoded)
                : array_map('strval', array_map('trim', explode(',', $coupon->book_condition_ids)));
        }
    
        // ============================================================
        // STEP 7 — GET CART ITEMS
        // ============================================================
        $cartItems = [];
        if (Auth::check()) {
            $cartItems = AddCart::where('user_id', auth()->user()->id)->get();
        }else{
            return $errorResponse('Please log in to apply the coupon');
        }
    
        // ============================================================
        // STEP 8 — PER-ITEM ELIGIBILITY LOOP
        // BUG 3: subcategory checked per item
        // BUG 4: book_id (SKU) checked per item
        // BUG 5: author_id checked per item
        // ============================================================
        $item_results        = [];
        $total_coupon_amount = 0.0;
        $applicable_subtotal = 0.0;
    
        foreach ($cartItems as $cart) {
    
            $bookId    = (string) $cart->book_id;
            $bookName  = $cart->book_details?->name ?? ('Book #' . $cart->book_id);
            $bookPrice = (float) ($cart->price * $cart->quantity);
            $applicable = true;
            $reason     = '';
    
            // ── Category check ──────────────────────────────────────
            if ($applicable && !empty($coupon->category_id)) {
                $bookCat = (string) ($cart->book_details?->category_id ?? '');
                if ($bookCat !== (string) $coupon->category_id) {
                    $applicable = false;
                    $reason     = 'Not in the required category for this coupon';
                }
            }
    
            // ── Sub-category check (BUG 3 FIX) ─────────────────────
            // Applied per line item — only qualifying sub-category gets discount
            if ($applicable && !empty($coupon->subcategory_id)) {
                $bookSubCat = (string) ($cart->book_details?->subcategory_id ?? '');
                if ($bookSubCat !== (string) $coupon->subcategory_id) {
                    $applicable = false;
                    $reason     = 'Not in the required sub-category ('
                                . ($cart->book_details?->subcategory?->name ?? 'N/A')
                                . ') — coupon applies to a specific sub-category only';
                }
            }
    
            // ── Child category check ─────────────────────────────────
            if ($applicable && !empty($coupon->childcategory_id)) {
                $bookChild = (string) ($cart->book_details?->childcategory_id ?? '');
                if ($bookChild !== (string) $coupon->childcategory_id) {
                    $applicable = false;
                    $reason     = 'Not in the required child category for this coupon';
                }
            }
    
            // ── Specific product / SKU inclusion check (BUG 4 FIX) ─
            // Only the exact book_id gets the discount; all others skip
            if ($applicable && !empty($couponProducts)) {
                if (!in_array($bookId, $couponProducts, true)) {
                    $applicable = false;
                    $reason     = 'This coupon is valid only for specific book(s) — this title is not included';
                }
            }
    
            // ── Exclusion product check ──────────────────────────────
            if ($applicable && !empty($excludedProducts)) {
                if (in_array($bookId, $excludedProducts, true)) {
                    $applicable = false;
                    $reason     = 'This book is excluded from the coupon offer';
                }
            }
    
            // ── Book condition check ─────────────────────────────────
            if ($applicable && !empty($couponConditions)) {
                $bookCondition = (string) ($cart->book_detail?->bookconditions ?? '');
                if (!in_array($bookCondition, $couponConditions, true)) {
                    $applicable = false;
                    $reason     = 'Book condition does not match the coupon requirement';
                }
            }
            // ── Author-wise check (BUG 5 FIX) ───────────────────────
            // Case-insensitive trim match on both author_id and author name
            if ($applicable && !empty($couponAuthorIds)) {
                $bookAuthorId = (string) ($cart->book_details?->author ?? '');

                if (!in_array($bookAuthorId, $couponAuthorIds, true)) {
                    $applicable = false;
                    $reason     = 'This coupon applies only to books by a specific author — this book\'s author is not eligible';
                }
            }
    
            // ── Per-item discount calculation ────────────────────────
            $item_discount = 0.0;
            if ($applicable) {
                if ($coupon->amounttype === 'A') {
                    // Fixed flat amount — each eligible item gets the full amount
                    // capped to item price so final price never goes negative
                    $item_discount = min((float) $coupon->details, $bookPrice);
                } else {
                    // Percentage — applied to this item's price
                    $item_discount = ($bookPrice * (float) $coupon->details) / 100;
                    if (!empty($coupon->maxi_discount) && $item_discount > (float) $coupon->maxi_discount) {
                        $item_discount = (float) $coupon->maxi_discount;
                    }
                }
                $total_coupon_amount += $item_discount;
                $applicable_subtotal  += $bookPrice;
            }
    
            $item_results[] = [
                'book_id'     => $bookId,
                'book_name'   => $bookName,
                'price'       => number_format($bookPrice, 2),
                'applicable'  => $applicable,
                'reason'      => $reason,
                'discount'    => number_format($item_discount, 2),
                'final_price' => number_format(max(0.0, $bookPrice - $item_discount), 2),
            ];
        }
    
        // ============================================================
        // STEP 9 — NO ITEM QUALIFIED
        // ============================================================
        if ($applicable_subtotal == 0) {
            return response()->json([
                'coupen_amount'          => number_format(0, 2),
                'coupen_amount_raw'      => 0,
                'payment_method_amount'  => number_format($payment_method_amount, 2),
                'total_before_shipping'  => number_format($cartSubtotal + $gst_add - $refferal_number_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount, 2),
                'total'                  => number_format($cartSubtotal + $shipping + $gst_add - $refferal_number_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount, 2),
                'shipping'               => number_format($shipping, 2),
                'free_shipping'          => false,
                'refferal_number_amount' => number_format($refferal_number_amount, 2),
                'coupon_code'            => '',
                'status1'                => 'None of your cart items qualify for this coupon',
                'item_results'           => $item_results,
            ]);
        }
    
        
        $free_shipping = (bool) $coupon->is_free_shipping;
        if($previousOrders > 0) {
            $free_shipping = session('free_shipping', true);
        }
        $effective_shipping = $free_shipping ? 0.0 : $shipping;
        
        
        $coupon_amount = $total_coupon_amount;
    
        $total_before_shipping = $cartSubtotal
            - $coupon_amount
            + $gst_add
            - $refferal_number_amount
            + $payment_method_amount
            + $wallet_remain_amount
            + $extra_shipping_amount
            - $wallet_using_amount;
    
        $total = $total_before_shipping + $effective_shipping;
    
        
        $coupen_name = $request->coupon_val;
    
        session()->put('coupen_name',    $coupen_name);
        session()->put('coupen_amount',  $coupon_amount);
        session()->put('free_shipping',  $free_shipping);
    
        $temp_user_id = bin2hex(random_bytes(10));
        session()->put('temp_coupen_id', $temp_user_id);
    
        return response()->json([
            'coupen_amount'          => number_format($coupon_amount, 2),
            'coupen_amount_raw'      => round($coupon_amount, 2),
            'payment_method_amount'  => number_format($payment_method_amount, 2),
            'total_before_shipping'  => number_format($total_before_shipping, 2),
            'total'                  => number_format($total, 2),
            'shipping'               => number_format($effective_shipping, 2),
            'free_shipping'          => $free_shipping,
            'refferal_number_amount' => number_format($refferal_number_amount, 2),
            'coupon_code'            => $coupen_name,
            'status1'                => 'Coupon added',
            'item_results'           => $item_results,
        ]);
    }

    // ─── Private helper ────────────────────────────────────────────────────────────

    private function couponResponse($coupen_amount, $coupen_name, $total, $payment_method_amount, $refferal_number_amount, $status)
    {
        session()->put('coupen_name', $coupen_name ?? "");
        session()->put('coupen_amount', $coupen_amount ?? 0);

        return [
            'coupen_amount'        => number_format($coupen_amount, 2),
            'payment_method_amount'=> number_format($payment_method_amount, 2),
            'total'                => number_format($total, 2),
            'refferal_number_amount'=> number_format($refferal_number_amount, 2),
            'coupon_code'          => $coupen_name,
            'status1'              => $status,
        ];
    }

    public function couponremove(Request $request)
    {
        // dd($request->all());
        
        $coupen_amount = 0;
        $refferal_number_amount = $request->refferal_number_amount;
        $payment_method_amount = $request->payment_method_amount;
        $wallet_remain_amount = $request->wallet_remain_amount;
        $wallet_using_amount = $request->wallet_using_amount;
        $extra_shipping_amount = $request->extra_shipping_amount;
        
        $total = $request->total + $request->shiping + $request->gst_add - $refferal_number_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
        
        $coupen_name = "";
        $status = "Coupon Removed";
        $request->session()->put('temp_coupen_id', '');
        session()->put('coupen_name', '');
        session()->put('coupen_amount', '');
        session()->put('free_shipping', '');
        
        $data['coupen_amount'] = number_format($coupen_amount, 2);
        $data['payment_method_amount'] = number_format($payment_method_amount, 2);
        $data['total'] = number_format($total, 2);
        $data['refferal_number_amount'] = number_format($refferal_number_amount, 2);
        $data['coupon_code'] = $coupen_name;
        $data['status1'] = $status;
        
        return $data;
    }

    public function referralcheck(Request $request)
    {
        // dd($request->all());

        $refferal_number = $request->refferal_number;
        $coupen_amount1  = $request->coupen_amount1;
        $shiping         = $request->shiping;
        $total1          = $request->total1;
        $gst_add         = $request->gst_add;
        $payment_method_amount  = $request->payment_method_amount;
        $wallet_remain_amount = $request->wallet_remain_amount;
        $wallet_using_amount = $request->wallet_using_amount;
        $extra_shipping_amount = $request->extra_shipping_amount;
    

        if ($refferal_number) {
            $code_check = User::where('referral_number', $request->refferal_number)->first();
            // dd($code_check);
            if ($code_check) 
            {
                if(Auth::check() && $code_check->id == Auth::user()->id)
                {
                    $refferal_receiver_amount = 0;
                    $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                    $status = "error";
                    $InvalidCoupon3 = "you cannot use your own referral code";
                    session()->put('refferal_number_name', '');
                    session()->put('refferal_number_amount', '');
                }
                else if(Auth::check())
                {
                    $order_details = Order::where('user_id', Auth::user()->id)->where('refferal_number_name', $code_check->referral_number)->count();
                    $results = Order::where('user_id', Auth::user()->id)->whereNotNull('refferal_number_name')->first();
                    
                    $refe_check = refercheck($refferal_number, Auth::user()->id);
                    // dd($refe_check);
                    
                    if($refe_check)
                    {
                        $refferal_receiver_amount = 0;
                        $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                        $status = "error";
                        $InvalidCoupon3 = $refe_check;
                        session()->put('refferal_number_name', '');
                        session()->put('refferal_number_amount', '');
                    }
                    else if($results)
                    {
                        $refferal_receiver_amount = 0;
                        $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                        $status = "error";
                        $InvalidCoupon3 = "You have already used this referral code";
                        session()->put('refferal_number_name', '');
                        session()->put('refferal_number_amount', '');
                    }
                    else if($order_details > 0)
                    {
                        $refferal_receiver_amount = 0;
                        $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                        $status = "error";
                        $InvalidCoupon3 = "You are Already use this code";
                        session()->put('refferal_number_name', '');
                        session()->put('refferal_number_amount', '');
                    }
                    else
                    {
                        $refferal_receiver_amount = referral_receiver_amount();
                        $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                        $status = "success";
                        $InvalidCoupon3 = "Referral Code Valid";
                        session()->put('refferal_number_name', $refferal_number);
                        session()->put('refferal_number_amount', $refferal_receiver_amount);
                    }
                }
                else
                {
                    $refferal_receiver_amount = referral_receiver_amount();
                    $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                    $status = "success";
                    $InvalidCoupon3 = "Referral Code Valid";
                    session()->put('refferal_number_name', $refferal_number);
                    session()->put('refferal_number_amount', $refferal_receiver_amount);
                }
            }
            else
            {
                $refferal_receiver_amount = 0;
                $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
                $status = "error";
                $InvalidCoupon3 = "Invalid code";
                session()->put('refferal_number_name', '');
                session()->put('refferal_number_amount', '');
            }
        }
        else
        {
            $refferal_receiver_amount = 0;
            $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
            $status = "error";
            $InvalidCoupon3 = "Please Enter Valid Referral code";
            session()->put('refferal_number_name', '');
            session()->put('refferal_number_amount', '');
        }
        
        

        $data['coupen_amount'] = number_format($coupen_amount1, 2);
        $data['refferal_receiver_amount'] = number_format($refferal_receiver_amount, 2);
        $data['payment_method_amount'] = number_format($payment_method_amount, 2);
        $data['total'] = number_format($total1, 2);
        $data['total1'] = number_format($total1, 2);
        $data['gst_add'] = $gst_add;
        $data['InvalidCoupon3'] = $InvalidCoupon3;
        $data['shiping'] = $shiping;
        $data['status1'] = $status;
        
        return $data;

    }

    public function referralremove(Request $request)
    {
        // dd($request->all());

        $refferal_number = "";
        $coupen_amount1  = $request->coupen_amount1;
        $shiping         = $request->shiping;
        $total1          = $request->total1;
        $gst_add         = $request->gst_add;
        $payment_method_amount  = $request->payment_method_amount;
        $wallet_remain_amount = $request->wallet_remain_amount;
        $wallet_using_amount = $request->wallet_using_amount;
        $extra_shipping_amount = $request->extra_shipping_amount;

        $refferal_receiver_amount = 0;
        $total1 = $total1 + $gst_add + $shiping - $coupen_amount1 - $refferal_receiver_amount + $payment_method_amount + $wallet_remain_amount + $extra_shipping_amount - $wallet_using_amount;
        $status = "success";

        session()->put('refferal_number_name', '');
        session()->put('refferal_number_amount', '');

        $data['coupen_amount'] = number_format($coupen_amount1, 2);
        $data['refferal_receiver_amount'] = number_format($refferal_receiver_amount, 2);
        $data['payment_method_amount'] = number_format($payment_method_amount, 2);
        $data['total'] = number_format($total1, 2);
        $data['total1'] = number_format($total1, 2);
        $data['gst_add'] = $gst_add;
        $data['shiping'] = $shiping;
        $data['status1'] = $status;
        
        return $data;

    }
    public function checkout(Request $request)
    {
        session()->put('coupen_name', $request->coupen_name);
        session()->put('coupen_amount', $request->coupen_amount);

        if (Auth::check()) {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        } else {
            $temp_user_id = session()->get('temp_user_id');
            $cart_book = AddCart::where('temp_user_id', $temp_user_id)->get();
        }

        if ($cart_book->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $unavailable_books = [];

        foreach ($cart_book as $cart_item) {
            $book = \App\Models\Book::find($cart_item->book_id);

            if (!$book) {
                $unavailable_books[] = 'Product not found';
                continue;
            }

            $is_active = (int)$book->status === 1;

            $variant = \App\Models\BookVarient::where('book_id', $cart_item->book_id)
                ->where('bookconditions', $cart_item->binding)
                ->first();

            $stock_available = $variant && (int)$variant->stock > 0;

            if (!$is_active || !$stock_available) {
                $unavailable_books[] = $book->name ?? 'Product';
            } elseif ((int)$variant->stock < (int)$cart_item->quantity) {
                $unavailable_books[] = $book->name ?? 'Product';
            }
        }

        if (!empty($unavailable_books)) {
            $message = 'The following product(s) are no longer available: ' . implode(', ', $unavailable_books);

            return redirect()->back()->with('error', $message);
        }

        if (Auth::check()) {
            return redirect()->route('user.checkout', compact('cart_book'));
        }

        return redirect()->route('guest.checkout', compact('cart_book'));

    }


    public function userlogin()
    {
        // dd(session());
        $url = \URL::previous();
        $arr_url =  explode('/', $url);
        // dd($arr_url[3]);
        
        if($arr_url[3] == "view-cart") {
            $temp_redri_id = bin2hex(random_bytes(10));
            session()->put('temp_redri_id', $temp_redri_id);
        }
    
        return view('frontend.login');
    }

    public function user_login(Request $request)
    {
        // dd($request->all());
        $field = 'username';

        if (is_numeric($request->input('login'))) {
            $field = 'phone';
        } elseif (filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }

        $request->merge([$field => $request->input('login')]);

        if (Auth::attempt($request->only($field, 'password'))) {

            if (session()->get('temp_user_id') != null) {
                AddCart::where('temp_user_id', session()->get('temp_user_id'))
                    ->update([
                        'user_id' => auth()->user()->id,
                        'temp_user_id' => null
                    ]);

                \Session::forget('temp_user_id');
            }
            
            $coupen_name = session()->get('coupen_name');
            $check_coupen = Coupon::where('name', $coupen_name)->first();
            
            
            $coupen_check = Order::where('user_id', Auth::user()->id)->where('coupen_name', $coupen_name)->count();
            if($coupen_check > 0 && $check_coupen)
            {
                $check_buy = AddCart::where('user_id', auth()->user()->id)->first();
                // dd($check_buy);   
                if($coupen_check == $check_coupen->limit_user)
                {
                    session()->put('coupen_name', "");
                    session()->put('coupen_amount', "");
                    return redirect('/user/profile')->with('error', 'Coupon is removed as you have already reach the coupon use limit.');
                }
                
            }
            else
            {
                $check_buy = AddCart::where('user_id', auth()->user()->id)->first();
                // dd($check_buy);
                if($check_buy)
                {
                    return redirect('/user/checkout');
                }
                else
                {
                    return redirect('/user/profile');
                }
            }
            
        }

        return redirect('/user/login')->with('error', 'These credentials do not match our records.');
    }

    public function userregister()
    {
        return view('frontend.register');
    }

    public function user_register(Request $request)
    {
        
        
        $checkUser = User::where('phone_number', $request->phone)->first();
        if($checkUser)
        {
            return redirect()->back()->with('error', 'This Phone Number already exists');
        }
        $checkUser = User::where('email', $request->email)->first();
        if($checkUser)
        {
            return redirect()->back()->with('error', 'This Email already exists');
        }

        $checktempuser = TempUser::where('phone', $request->phone)->where('email', $request->email)->first();
        if ($checktempuser) {
            $checktempuser->delete();
        }
        
        $otp_number = random_int(1000, 9999);

        $user = TempUser::create([
            'name'     => $request->fname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'verification_code'    => $otp_number,
            'password' => Hash::make($request->phone),
        ]);

        $phone = $request->phone;
        $otp = "Your OTP is $otp_number valid for 10 minutes. Thanks for registering with us.Install SimplySellBooks app to get upto 50% back! UsedBookR";
        $type = "register_otp";
        $email = $request->email;

        // $otp_mail = [
        //     'title' => 'Regestration OTP for UsedBookR',
        //     'otp' => $otp_number
        // ];
        
        $sms_sent = otp_send($phone, $otp_number, $type);
        // dd($sms_sent);
        $otp_mail = [
            'title' => 'Register OTP for UsedBookR',
            'otp' => $otp,
            'email' => $email,
            'name' => $request->fname
        ];
        
        try{
            Mail::send('mail.OtpMail', $otp_mail, function($message)use($otp_mail) {
                $message->to($otp_mail['email'], $otp_mail['name'])
                    ->from("info@usedbookr.com", 'no-reply')
                ->subject('Mail OTP');
            });
        }
        catch(\Exception $e){
            \Log::info($e);
            // dd($e);
        }
        
        
        $user_id_sent = base64_encode($user->id);
        
        // Auth::login($user);

        return redirect()->route('otpverify', $user_id_sent)->with('success', 'OTP Sent to Phone and Email');
        
    }

    public function otpverify($id)
    {
        if (Auth::check() && Auth::user()->user_type == 'user'  && Auth::user()->otp_verify == 1) {
            return redirect()->route('user.profile');
        }
        $user_id_sent = base64_decode($id);
        $user_details = TempUser::where('id', $user_id_sent)->first();
        return view('frontend.otpverify', compact('user_details'));
    }

    public function otp_check(Request $request)
    {
        // dd($request->all());
        $otp_verify = $request->otp_verify;
        $user_id_otp_check = $request->user_id_otp_check;

        $user_check = TempUser::where('id', $user_id_otp_check)->first();

        if ($otp_verify == $user_check->verification_code) {
            $data['check'] = true;
            return $data;
        }
        else{
            $data['check'] = false;
            return $data;
        }
    }

    public function otp_verify(Request $request)
    {
        // dd($request->all());

        $verification_code = implode('', $request->otp);

        $temp_user_id = TempUser::where('id', $request->user_id_otp_check)->where('verification_code', $verification_code)->first();
        // dd($temp_user_id);
        if ($temp_user_id) {
            $user = User::create([
                'name' => $temp_user_id->name,
                'email' => $temp_user_id->email,
                'phone_number' => $temp_user_id->phone,
                'otp' => $verification_code,
                'user_type' => 'user',
                'otp_verify' => 1,
                'password' => Hash::make($temp_user_id->phone),
            ]);
            
            $ran_num        = rand(1000,9999);
            $refer_number   = '#UBR_'.$ran_num.'_'.$user->id;
    
            $user_update = User::find($user->id);
            $user_update->referral_number = $refer_number;
            $user_update->save();

            $delet_temp = TempUser::find($temp_user_id->id);
            $delet_temp->delete();

            Auth::login($user);

            if ($user) {
                return redirect()->route('user.profile')->with('success', 'Welcome to UsedBookR');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Something Wrong');
        }
        
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function search(Request $request)
    {
        // dd( $request->all());
        // $sort_by = '';
        // if(request('sort_id') && request('sort_id')!=''){
        //     $sort_by = request('sort_id');
        //     $books = Books::where('status', 1);
        //     if ($sort_by == "alphp_a") {
        //         $books = $books->orderBy('name', 'ASC')->get();
        //     }
        //     else if ($sort_by == "alphp_z")
        //     {
        //         $books = $books->orderBy('name', 'DESC')->get();
        //     }
        //     else if ($sort_by == "low_to_hight")
        //     {
        //         $books = $books->orderBy('selling_price', 'ASC')->get();
        //     }
        //     else if ($sort_by == "hight_to_low")
        //     {
        //         $books = $books->orderBy('selling_price', 'DESC')->get();
        //     }
        //     else if ($sort_by == "latest")
        //     {
        //         $books = $books->latest()->get();
        //     }
        //     else
        //     {
        //         $books = $books->get();
        //     }

        //     $search_result = $books;

        //     return view('frontend.search', compact('search_result', 'sort_by'));
        // }
        // else
        // {
            $stock_check = "";
            if(request('stock_check') && request('stock_check')!=''){
                $stock_check = request('stock_check');
            }
            
            $form_data        = [];
            if (request('sort_id')) {
                $sort_by = request('sort_id');
                $form_data        = $request->all();
                $form_data['sort_books']   = $sort_by;
            }
            else {
                $sort_by = "";
                $form_data              = $request->all();
                $form_data['sort_id']   = "latest";
            }
            // dd($form_data);
            $search_result1    = $this->SearchService->make_filer_search($form_data);
            // dd($search_result1);
            $search_result = $search_result1['book_details'];
            $expertusersid_arr = [];
            if (isset($search_result1['book_details1']) && !empty($search_result1['book_details1'])) {
              foreach ($search_result1['book_details1'] as $key => $expdata) {
                array_push($expertusersid_arr, $expdata['id']);
              }
            }
            // dd($expertusersid_arr);
            
            // if($request->page == null)
            // {
            //     $page_pagi_count = "";
            // }
            // else
            // {
            //     $page_pagi_count =  $request->page != 1;
            // }
            
            // dd($request->page);
            // if($page_pagi_count)
            // {
            //     if($page_pagi_count != null || $page_pagi_count != 1 )
            //     {
            //         $search_result->appends($request->except('page'));
            //     }
            //     else
            //     {
            //         $search_result;
            //     }
            // }
            // else
            // {
            //     $search_result;
            // }
            
            // dd($search_result);
            return view('frontend.search', compact('search_result', 'sort_by', 'expertusersid_arr', 'stock_check'));
        // }
        
    }

    public function addToWhislist($id)
    {
        
        $id = base64_decode($id);
        
        if(session()->get('temp_wish_id')) {
            $temp_user_id = session()->get('temp_wish_id');
        } else {
            $temp_user_id = bin2hex(random_bytes(10));
            session()->put('temp_wish_id', $temp_user_id);
        }
            
        $product = Books::findOrFail($id);
        
        if (Auth::check() && Auth::user()->user_type == 'user') {
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::user()->id;
            $wishlist->book_id = $id;
            $wishlist->save();

            return redirect()->back()->with('success', 'Product added to Wishlist successfully!');
        }
        else
        {
            $wishlist = new Wishlist();
            // $wishlist->user_id = Auth::user()->id;
            $wishlist->temp_wish_id = $temp_user_id;
            $wishlist->book_id = $id;
            $wishlist->save();

            return redirect()->back()->with('success', 'Product added to Wishlist successfully!');
            
            // return redirect()->back()->with('error', 'Please login First');
        }
        // $whislist = session()->get('cart', []);
  
        // if(isset($whislist[$id])) {
        //     $whislist[$id]['quantity']++;
        // } else {
        //     $whislist[$id] = [
        //         "name" => $product->name,
        //         "price" => $product->selling_price,
        //         "original_price" => $product->original_price,
        //         "image" => $product->image
        //     ];
        // }
          
        // session()->put('whislist', $whislist);
        
    }

    public function delete_whislist($id)
    {
        // dd($id);
        $id1 = base64_decode($id);

        if(Session()->get('temp_wish_id')) {
            $temp_wish_id = Session()->get('temp_wish_id');
        }
        if (Auth::check() && Auth::user()->user_type == 'user') 
        {
            $list_wishlist = Wishlist::where('user_id', Auth::user()->id)->where('book_id', $id1)->first();
        }
        else
        {
            $list_wishlist = Wishlist::where('temp_wish_id', $temp_wish_id)->where('book_id', $id1)->first();
        }
        
        if($list_wishlist) {
            
            $delete_wish = Wishlist::find($list_wishlist->id);
            $delete_wish->delete();
            if($delete_wish) {
                return redirect()->back()->with('error', 'Wishlist Product removed successfully');
            }
        }
        return redirect()->back()->with('error', 'Something Wrong');
    }

    public function phonepeReturn(Request $request)
    {
        // dd($request->all());
        $total = 0;
        $total1 = 0;
        $gst_amount = 0;
        $gst = 0;
        $book_weight1 = 0;
        $book_weight = 0;
        $payment_method = session()->get('payment_method');
        $wallet_cart    = session()->get('wallet_cart');
        
        $wallet_remain_amount = session()->get('wallet_remain_amount');
        $wallet_using_amount = session()->get('wallet_using_amount');
        // dd($wallet_remain_amount);
        $cart_book1 = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->first();
        if($cart_book1)
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->get();
            // dd($cart_book);
        }
        else
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        }
        
        // $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        foreach($cart_book as $key => $details)
        {
            $total += $details->price * $details->quantity;
            $gst_amount = gst_calculate($details->gst, $details->price);
            $gst += $gst_amount * $details->quantity;
            $total1 += $details->original_price * $details->quantity;
            $book_weight1 += $details->book_weight;
            if ($details->book_weight > extra_weight())
            {
                $book_weight += 1;
            }
        }
        // dd(count($cart_book));
        $calclulate_extra1 = calclulate_extra($book_weight);
        if($request->code == 'PAYMENT_SUCCESS' && $total != 0 && count($cart_book) > 0)
        {
            $transactionId = $request->transactionId;
            $merchantId=$request->merchantId;
            $providerReferenceId=$request->providerReferenceId;
            $checksum=$request->checksum;
            $status=$request->code;
            $data = [
                'providerReferenceId' => $providerReferenceId,
                'checksum' => $checksum,
            ];

            $user_address = Address::where('id', session('address_id'))->first();
            if($user_address)
            {
                $user_address = $user_address->toArray();
            }
            // dd($user_address);
            $order_details = Order::latest()->first();
            if ($order_details) {
                $invoice_no = $order_details->invoice_no + 1;
            }
            else {
                $invoice_no = "10000000001";
            }
            if ($data) {
                $order = new Order();
                $order->user_id          = Auth::user()->id;
                $order->invoice_no       = $invoice_no;
                $order->name             = $user_address['first_name'] .' '. $user_address['last_name'];
                $order->email            = $user_address['email'];
                $order->mobile           = $user_address['phone'];
                $order->gross_amount     = $total1;
                $order->shipping_charge  = session('shipping_amount');
                $order->gst_charge       = $gst;
                $order->final_amount     = $total;
                $order->order_date       = date('Y-m-d');
                $order->coupen_name      = session('coupen_name');
                $order->coupen_amount    = session('coupen_amount');
                $order->refferal_number_name    = session('refferal_number_name');
                $order->refferal_number_amount    = session('refferal_number_amount');
                $order->wallet_remain_amount    = $wallet_remain_amount;
                $order->wallet_using_amount    = $wallet_using_amount;
                $order->extra_shipping_charge    = $calclulate_extra1;
                
                if (session('refferal_number_amount') != 0) {
                    $order->referral_person_amount    = referral_sender_amount();
                }
                $order->notes            = "Test Order";
                $order->house_no         = $user_address['house_no'];
                $order->shipping_address = $user_address['street'];
                $order->state            = $user_address['state'];
                $order->city             = $user_address['city'];
                $order->pincode          = $user_address['zipcode'];
                $order->country          = $user_address['country'];
                $order->payment_mode     = $payment_method;
                $order->order_status     = "pending";
                $order->payment_status   = "Paid";
                $order->merchantId       = $merchantId;
                $order->providerReferenceId   = $providerReferenceId;
                $order->checksum        = $checksum;
                $order->transactionId   = $transactionId;
                $order->save();

                if ($order->id) 
                {
                    if(count($cart_book) > 0)
                    {
                        foreach ($cart_book as $key => $value) 
                        {
    
                            $gst_amount1 = gst_calculate($value->gst, $value->price);
                            $book_details = Books::where('id', $value->book_id)->first();
                            $productattr = BookVarient::where('book_id', $value->book_id)->where('bookconditions', $value->binding)->first();
                            
                            if($book_details)
                            {
                                $order_item                 = new Orderitem();
                                $order_item->order_id       = $order->id;
                                $order_item->book_id        = $value->book_id;
                                $order_item->qty            = $value->quantity;
                                $order_item->original_price = $value->original_price;
                                $order_item->selling_price  = $value->price;
                                $order_item->gst_charge     = $value->gst;
                                $order_item->gst_amount     = $gst_amount1;
                                $order_item->sku            = $productattr->sku_number;
                                $order_item->hsn_code       = $book_details->hsn_code;
                                $order_item->isbn           = $book_details->isbn13;
                                $order_item->binding        = $value->binding;
                                $order_item->condition      = $value->condition;
                                $order_item->weight         = $value->book_weight;
                                $order_item->status         = 1;
                                $order_item->save();
        
                                $update_stock = BookVarient::findOrFail($productattr->id);
                                $update_stock->stock = $productattr->stock - $value->quantity;
                                $update_stock->save();
                                
                                $delete = AddCart::findOrFail($value->id);
                                $delete->delete();
                            }
                            else
                            {
                                $order_delete = Order::findOrFail($order->id);
                                $order_delete->delete();
                                return redirect()->route('final.order.now.page')->with('success', 'Thank you for shopping on UsedbookR');
                            }
                            
                        }
    
                        $code_check = User::where('referral_number', session('refferal_number_name'))->first();
    
                        if (session('refferal_number_name')) 
                        {
    
                            if ($code_check) 
                            {
                                $wallet = new Wallet();
                                $wallet->order_id = $order->id;
                                $wallet->receiver_id = Auth::user()->id;
                                $wallet->sender_id = $code_check->id;
                                $wallet->receiver_amount = session('refferal_number_amount');
                                $wallet->sender_amount = referral_sender_amount();
                                $wallet->save();
    
                                $user_add_amount = User::find($code_check->id);
                                if ($user_add_amount->wallet_amount) {
                                    $user_add_amount->wallet_amount += (float)referral_sender_amount();
                                }
                                else
                                {
                                    $user_add_amount->wallet_amount = (float)referral_sender_amount();
                                }
                                $user_add_amount->save();
                            }
                            
                            $number_of_order = ["3","6","9","12","15","18","21","24","27","30","33","36","39","42","45","48","51","54","57","60"];
                        
                            $order_counts = Order::where('refferal_number_name', session('refferal_number_name'))->count();
                            
                            if(in_array($order_counts, $number_of_order))
                            {
                                $wallet = new Wallet();
                                $wallet->order_id = "Bonus";
                                $wallet->receiver_id = 1;
                                $wallet->sender_id = $code_check->id;
                                $wallet->receiver_amount = session('refferal_number_amount');
                                $wallet->sender_amount = 25;
                                $wallet->save();
                                
                                $user_add_amount = User::find($code_check->id);
                                if ($user_add_amount->wallet_amount) {
                                    $user_add_amount->wallet_amount += 25;
                                }
                                else
                                {
                                    $user_add_amount->wallet_amount = 25;
                                }
                                $user_add_amount->save();
                                    
                            }
                        
                        }
                        
                        if($wallet_remain_amount)
                        {
                            $user_details = User::find(Auth::user()->id);
                            $user_details->wallet_amount = 0;
                            $user_details->save();
                        }
                        
                        if($wallet_using_amount)
                        {
                            $user_details1 = User::find(Auth::user()->id);
                            $user_details1->wallet_amount = Auth::user()->wallet_amount - $wallet_using_amount;
                            $user_details1->save();
                        }
                        
    
                        $order_details = Order::where('id', $order->id)->with(['orderitems', 'orderitems.FetchBook'])->first();
                        if ($order_details) {
                            $order_details = $order_details->toArray();
                        }
                        
                        $wishlist_check1 = order_send($user_address['phone'], Auth::user()->name);
                        // dd($wishlist_check1);
                        $data['name'] = Auth::user()->name;
                        $data['email'] = Auth::user()->email;
                        $data['order_details'] = $order_details;
    
                        // return view('emails.order_details', compact('order_details'));
    
                        try
                        {
                            Mail::send('emails.order_details', $data, function($message)use($data) {
                                $message->to($data['email'], $data['name'])
                                    ->from("noreplywebbitech@gmail.com", 'no-reply')
                                ->subject('Order Details from UsedBookR');
                            });
                        }
                        catch(\Exception $e){
                            // dd($e);
                        }
    
                        session()->put('cart', []);
                        session()->put('coupen_name', '');
                        session()->put('coupen_amount', '');
                        session()->put('shiping_charge', '');
                        session()->put('refferal_number_name', '');
                        session()->put('refferal_number_amount', '');
                        session()->put('payment_method', '');
                        session()->put('wallet_remain_amount', '');
                        session()->put('wallet_using_amount', '');
                        return redirect()->route('user.order.success', base64_encode($order->id))->with('success', 'Thank you for shopping on UsedbookR');
                    }
                    else
                    {
                        return redirect()->route('final.order.now.page')->with('error', 'Something Wrong!');
                    }
                    
                }
                else
                {
                    return redirect()->route('final.order.now.page')->with('error', 'Something Wrong!');
                }

            }
        }
        else {
            return redirect()->route('final.order.now.page')->with('error', 'Something Wrong!');
            // return redirect()->back()->with('error', 'Something Wrong!');
        }
    }

    public function autherCheck($id)
    {
        
        $books = Book::where('author', $id)->where('status',1)->paginate(52);
        
        return view('frontend.authorbooks', compact('books', 'id'));
    }

    public function autherList()
    {
        // dd($id);
        $books = Book::where('status', 1)->where('status',1)->paginate(52);
        
        return view('frontend.authorbooks', compact('books'));
    }

    public function new_arrival()
    {
        $sort_by = '';
        if(request('sort_id') && request('sort_id')!=''){
          $sort_by = request('sort_id');
        }

        $word = "N";
        $books = Book::where('status', 1)->where('section_id', 'like', '%'.$word.'%');
        if ($sort_by == "alphp_a") {
            $books = $books->where('status', 1)->orderBy('name', 'ASC')->paginate(52);
        }
        else if ($sort_by == "alphp_z")
        {
            $books = $books->where('status', 1)->orderBy('name', 'DESC')->paginate(52);
        }
        else if ($sort_by == "low_to_hight")
        {
            $books = $books->where('status', 1)->orderBy('selling_price', 'ASC')->paginate(52);
        }
        else if ($sort_by == "hight_to_low")
        {
            $books = $books->where('status', 1)->orderBy('selling_price', 'DESC')->paginate(52);
        }
        else if ($sort_by == "latest")
        {
            $books = $books->where('status', 1)->latest()->paginate(52);
        }
        else
        {
            $books = $books->where('status', 1)->latest()->paginate(52);
        }
        
        $expertusersid_arr = [];
        if (isset($books) && !empty($books)) {
          foreach ($books as $key => $expdata) {
            array_push($expertusersid_arr, $expdata['id']);
          }
        }
        
        return view('frontend.new-arrival', compact('books', 'sort_by', 'expertusersid_arr'));
    }

    // public function search_book(Request $request)
    // {
    //     // dd($request->all());
    //     $user_id = "";
    //     $search = $request->book_search;
    //     $search_word = $request->book_search;
    //     if (Auth::check()) {
    //         $user_id = Auth::user()->id;
    //     }
    //     $clientIP = request()->ip();
    //     // dd($clientIP);

    //     if ($search) {
    //         $search_save = Search::create([
    //             'user_id' => $user_id,
    //             'key_word' => $search,
    //             'ip_address' => $clientIP,
    //         ]);
    //     }
        
    //     $id = base64_encode($search);
        
    //     return redirect()->route('product.search.get', $id);
        
    // }
    public function search_book(Request $request)
    {
        $search = trim($request->book_search);

        // Input empty-a irundha simple-ah same page-ukku back poyidum (404 varadhu)
        if (empty($search)) {
            return redirect()->back();
        }

        $user_id = Auth::check() ? Auth::user()->id : null;
        $clientIP = $request->ip();

        Search::create([
            'user_id'    => $user_id,
            'key_word'   => $search,
            'ip_address' => $clientIP,
        ]);
        
        $id = base64_encode($search);
        
        return redirect()->route('product.search.get', $id);
    }
    
   public function search_book_get(Request $request, $id)
    {
        $user_id = "";
        $search = base64_decode($id);

        $search_word = $search;
        $stock_check = $request->input('stock_check', '');
        $sort_by = "latest";
        $books = Book::where('status', 1)
            ->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', '%' . $search . '%')

                    ->orWhere('hsn_code', 'LIKE', '%' . $search . '%')

                    ->orWhere('isbn', 'LIKE', '%' . $search . '%')

                    ->orWhere('isbn13', 'LIKE', '%' . $search . '%')

                    ->orWhere('publisher', 'LIKE', '%' . $search . '%')

                    ->orWhere('overview', 'LIKE', '%' . $search . '%')

                    ->orWhere('date_published', 'LIKE', '%' . $search . '%')

                    ->orWhere('language', 'LIKE', '%' . $search . '%')

                    ->orWhere('edition', 'LIKE', '%' . $search . '%')

                    ->orWhere('author', 'LIKE', '%' . $search . '%')

                    ->orWhereHas('childcategories', function ($q) use ($search) {

                        $q->where(
                            'name',
                            'LIKE',
                            '%' . $search . '%'
                        );

                    });
            });
        if ($stock_check) {

            $books->whereHas('varients', function ($query) {

                $query->where('stock', '!=', 0);

            });
        }
        $books = $books
            ->with(['childcategories'])
            ->latest()
            ->paginate(52);
        if ($books->isEmpty()) {

            ApiLogHelper::log(

                $request,

                'Search',

                'Search Book Get',

                microtime(true),

                'failed',

                200,

                [
                    'encoded_id'  => $id,
                    'decoded_id'  => $search,
                    'stock_check' => $stock_check,
                ],

                [
                    'total_results' => 0,
                    'message'       => 'No books found',
                ],

                'search_keyword',

                $search,

                'No books found for search term: ' . $search

            );

        } else {
            ApiLogHelper::log(

                $request,

                'Search',

                'Search Book Get',

                microtime(true),

                'success',

                200,

                [
                    'encoded_id'  => $id,
                    'decoded_id'  => $search,
                    'stock_check' => $stock_check,
                ],

                [
                    'total_results' => $books->total(),
                    'current_page'  => $books->currentPage(),
                    'per_page'      => $books->perPage(),
                ],

                'search_keyword',

                $search,

                null

            );
        }
        $expertusersid_arr = [];
        if (!$books->isEmpty()) {

            foreach ($books as $expdata) {

                $expertusersid_arr[] = $expdata->id;
            }
        }
        return view(
            'frontend.search_list1',
            compact(
                'books',
                'sort_by',
                'expertusersid_arr',
                'search_word',
                'stock_check',
                'id'
            )
        );
    }

    public function SearchWordText(Request $request)
    {
        // dd($request->all());

        $search = $request->book_search;

        if ($search) {
            $books = Book::where('status', '1')
                      ->where(function($q) use ($search) { 
                        $q->where('name', 'LIKE', "%".$search."%")
                        ->orwhere('hsn_code', 'LIKE', "%".$search."%")
                        ->orwhere('isbn', 'LIKE', "%".$search."%")
                        ->orwhere('isbn13', 'LIKE', "%".$search."%")
                        ->orwhere('publisher', 'LIKE', "%".$search."%")
                        ->orwhere('overview', 'LIKE', "%".$search."%")
                        ->orwhere('date_published', 'LIKE', "%".$search."%")
                        ->orwhere('language', 'LIKE', "%".$search."%")
                        ->orwhere('edition', 'LIKE', "%".$search."%")
                        ->orwhere('author', 'LIKE', "%".$search."%")
                        ->orWhereHas('childcategories', function($q) use ($search){
                            $q->where('name', 'LIKE', "%".$search."%");
                        });
                    });

            $books = $books->where('status', 1)
            ->with(['childcategories'])
            ->latest()
            ->paginate(10);

            $view =  view('frontend.search_list', compact('books'))->render();

            if ($books) {
                $data['books'] = $view;
                $data['status'] = "success";
            }
            else
            {
                $data['status'] = "error";
            }
        }
        else
        {
            $data['status'] = "error";
        }
            
        return $data;
        
    }

    public function subscription_sent(Request $request)
    {
        // dd($request->all());

        $check = Subscripe::where('email_address', $request->subscripe_mail)->first();
        if ($check) {
            return redirect()->back()->with('success', 'Something New is Arriving to your E-Mail');
        }
        else
        {
            $subscripe = new Subscripe();
            $subscripe->email_address = $request->subscripe_mail;
            if ($subscripe->save()) {
                return redirect()->back()->with('success', 'Something New is Arriving to your E-Mail');
            }
            return redirect()->back()->with('error', 'Something Wrong');
        }
    }
    
    public function faq()
    {
        $pages = Page::where('id', 4)->first();
        return view('frontend.faq', compact('pages'));
    }

    public function terms()
    {
        $pages = Page::where('id', 3)->first();
        return view('frontend.terms', compact('pages'));
    }

    public function policy()
    {
        $pages = Page::where('id', 2)->first();
        return view('frontend.terms', compact('pages'));
    }
    
    public function refundPolicy()
    {
        return view('frontend.refund_cancellation');
    }

    public function shippingPolicy()
    {
        return view('frontend.shipping_delivery');
    }

    public function about()
    {
        $pages = Page::where('id', 1)->first();
        return view('frontend.terms', compact('pages'));
    }
    
    public function SitemapXml()
    {
        
        $posts = Book::latest()->get();
        $category = Category::latest()->get();
  
        return response()->view('sitemap', [
            'posts' => $posts,
            'category' => $category
        ])->header('Content-Type', 'text/xml');
    }

    public function MailCheck(Request $request)
    {
        // dd($request->all());

        $user_check = User::where('email', $request->email_id)->first();

        if ($user_check) {
            return response()->json(['success' => 'This Email already exists', 'user' => $user_check]);
        }
        else
        {
            return response()->json(['success' => 'no user', 'user' => '']);
        }
        
        // dd($user_check);
    }

    public function PhoneCheck(Request $request)
    {
        // dd($request->all());

        $user_check = User::where('phone_number', $request->phone_id)->first();

        if ($user_check) {
            return response()->json(['success' => 'This Phone Number already exists', 'user' => $user_check]);
        }
        else
        {
            return response()->json(['success' => 'no user', 'user' => '']);
        }
        
        // dd($user_check);
    }

    public function UserBlog()
    {
        $category_details = BlogCategory::where('status', 'active')->get();
        $blog_details = Blog::where('status', 'active')->latest()->get();

        return view('frontend.blog', compact('blog_details', 'category_details'));
    }

    public function UserBlogDetails($slug)
    {
        $category_details = BlogCategory::where('status', 'active')->get();
        $blog_details = Blog::where('slug', $slug)->where('status', 'active')->first();
        if (!$blog_details) {
            abort(404, 'Blog not found');
        }
        $recent_blog = Blog::whereNot('id', $blog_details->id)->where('status', 'active')->get();

        return view('frontend.blogdetails', compact('blog_details', 'category_details', 'recent_blog'));
    }

    public function BlogCommentStore(Request $request)
    {
        // dd($request->all());

        $new_comment                = new BlogComment();
        $new_comment->blog_id       = $request->blog_id;
        $new_comment->name          = $request->name;
        $new_comment->email         = $request->email;
        $new_comment->comments      = $request->comment;
        $new_comment->status        = "Pending";

        if ($new_comment->save()) {
            return redirect()->back()->with('success', 'Blog Comment Added Successfully');
        }

    }
    
    public function Usercategory($slug)
    {
        // dd($slug);
        $category_details1 = BlogCategory::where('category_slug', $slug)->where('status', 'active')->first();
        $category_details = BlogCategory::where('status', 'active')->get();
        $blog_details = Blog::where('category_id', $category_details1->id)->where('status', 'active')->latest()->get();

        return view('frontend.blog_category', compact('blog_details', 'category_details', 'category_details1'));
    }


}