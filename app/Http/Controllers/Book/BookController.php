<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Auth;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Carbon;
use App\Models\Author;
use App\Models\Category;
use App\Models\Binding;
use App\Models\BookCondition;
use App\Models\BookVarient;
use App\Models\Book;
use App\Models\Language;
use App\Models\Ratingreview;
use App\Models\ImageUpload;
use Storage;
use Excel;
use App\Imports\ImportBooks;
use App\Exports\BookExport;
use App\Exports\ExportCategories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function All(Request $request)
    {
        $query = Books::with('category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('book_id', 'LIKE', "%{$search}%")
                    ->orWhere('isbn', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%")
                    ->orWhere('publisher', 'LIKE', "%{$search}%");
            });
        }
        $books = $query
            ->latest('id')
            ->paginate(100)
            ->withQueryString();

        return view(
            'backend.books.all',
            compact('books')
        );
    }

    public function search(Request $request)
    {

        $text_value_search = $request->text_value_search;

        $books = Books::latest();

        if ($text_value_search) {
            $books = $books->where(function($q) use ($text_value_search) { 
                        $q->where('name', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('book_id', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('isbn', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('isbn13', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('language', 'LIKE', "%".$text_value_search."%")
                        ->orWhereHas('category', function($q) use ($text_value_search){
                            $q->where('name', 'LIKE', "%".$text_value_search."%");
                        })
                        ->orWhereHas('binding', function($q) use ($text_value_search){
                            $q->where('bindings', 'LIKE', "%".$text_value_search."%");
                        });
                        
                    });
        }

        $books = $books->paginate(100);

        $view =  view('backend.books.BooksSearch', compact('books'))->render();

        if ($view) {
            $data['project'] = $view;
            $data['status'] = "success";
        }
        else
        {
            $data['status'] = "error";
        }

        return $data;
    }

    public function Add()
    {
        $categories = Category::where('status',1)->Where('level',1)->get();
        $bindings =Binding::where('status',1)->get();
        $languages =Language::where('status',1)->get();
        $condition_types = BookCondition::where('status',1)->get();
        return view('backend.books.add',compact('bindings','categories','condition_types','languages'));
    } // End Method 

    Public function ApibookAll()
    {
        $books = Book::Where('status',1)->latest()->get();
        if($books->isNotEmpty()){
            foreach($books as $book){
                $book->image = asset('public/upload/admin_images/books/'.$book->image);
                $book->varient = BookVarient::Where('book_id',$book->id)->get(['bindings','bookconditions','price']);
                $book->language_id = Language::Where('id',$book->language_id)->get(['name']);
                $book->category_id = Category::Where('id',$book->category_id)->get(['name']);
                $book->subcategory_id = Category::Where('id',$book->subcategory_id)->get(['name']);
                $book->childcategory_id = Category::Where('id',$book->childcategory_id)->get(['name']);
            }
        }
        return response([
            'success' => true,
            'books' => $books
        ]);
        //return view('backend.category.all',compact('categories'));
    }

    Public function Bookdetails($id)
    {
        $books = Book::Where('status',1)->Where('id',$id)->get();
        if($books->isNotEmpty()){
            foreach($books as $book){
                $book->image = asset('public/upload/admin_images/books/'.$book->image);
                $book->ratingreview = Ratingreview::Where('book_id',$book->id)->get(['rating','review']);
                $book->varient = BookVarient::Where('book_id',$book->id)->get(['bindings','bookconditions','price']);
                $book->language_id = Language::Where('id',$book->language_id)->get(['name']);
                $book->category_id = Category::Where('id',$book->category_id)->get(['name']);
                $book->subcategory_id = Category::Where('id',$book->subcategory_id)->get(['name']);
                $book->childcategory_id = Category::Where('id',$book->childcategory_id)->get(['name']);
            }
        }
        return response([
            'success' => true,
            'books' => $books
        ]);
        //return view('backend.category.all',compact('categories'));
    }

    Public function ApiChildcategorybook(Request $request, $id)
    {
        $books = Book::Where('childcategory_id',$id)->Where('status',1)->latest()->get();
        if($books->isNotEmpty()){
            foreach($books as $book){
                $book->varient = BookVarient::Where('book_id',$book->id)->get(['bindings','bookconditions','price']);
                $book->category_id = Category::Where('id',$book->category_id)->get(['name']);
                $book->subcategory_id = Category::Where('id',$book->subcategory_id)->get(['name']);
                $book->childcategory_id = Category::Where('id',$book->childcategory_id)->get(['name']);
                $book->language_id = Language::Where('id',$book->language_id)->get(['name']);
            }
        }
        return response([
            'success' => true,
            'books' => $books
        ]);
        //return view('backend.category.all',compact('categories'));
    }

    public function AjaxCrop(Request $request){
        if(isset($request->image))
        {
            $data = $request->image;
            $image_array_1 = explode(";", $data);
            
            $image_array_2 = explode(",", $image_array_1[1]);
            $image_data = base64_decode($image_array_2[1]);
        
            $imageName = time() . '.jpg';
        
            $image_path = public_path('upload/admin_images/books') . '/' . $imageName;
        
            file_put_contents($image_path, $image_data);
        
            return response()->json(['image_url' =>  asset('public/upload/admin_images/books/'.$imageName),'image_name'=>$imageName]);
        }
    }


    public function ApiBooksAll()
    {

        try{
             

            $url = "https://api.premium.isbndb.com/books/isbn";  
            $restKey = env('REST_KEY');  
            
            $headers = array(  
              "Content-Type: application/json",  
              "Authorization: " . $restKey  
            );  
            $rest = curl_init();  
            curl_setopt($rest,CURLOPT_URL,$url);  
            curl_setopt($rest,CURLOPT_HTTPHEADER,$headers);  
            curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);  
            
            $response = curl_exec($rest);
            $jsonResponse = json_decode($response, true);
           $books = $jsonResponse['books'];
          
           
            // return response([
            //     'success' => true,
            //     'response' => $jsonResponse
            // ]);
           
             return view('backend.api_books.all',compact('books'));
        }catch (Exception $exception) {
            return response([
                'success' => false,
                'generalerror' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }


    public function ApiEdit($id){


        try{
            $url = 'https://api.premium.isbndb.com/book/'.$id;  
            $restKey = '50363_9a77755a173b1d79066197d0ce1bf427';  
            
            $headers = array(  
              "Content-Type: application/json",  
              "Authorization: " . $restKey  
            ); 
            
            $headers = array(  
              "Content-Type: application/json",  
              "Authorization: " . $restKey  
            );  
            
            $rest = curl_init();  
            curl_setopt($rest,CURLOPT_URL,$url);  
            curl_setopt($rest,CURLOPT_HTTPHEADER,$headers);  
            curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);  
            
            $response = curl_exec($rest);
            $jsonResponse = json_decode($response, true);
            $categories = Category::where('status',1)->get();
            $bindings =Binding::where('status',1)->get();
            $condition_types = BookCondition::where('status',1)->get();
           
            return view('backend.api_books.add',compact('jsonResponse','categories','bindings','condition_types'));
        }catch (Exception $exception) {
            return response([
                'success' => false,
                'generalerror' => true,
                'message' => $exception->getMessage()
            ]);
        }
       
        // $response;  
        //print_r($response);  
        //curl_close($rest);
    }


    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'listed_by' => 'required|string|max:10',

            'name' => 'required|string|max:255',

            'thumbnail_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ],

            'original_price' => 'required|numeric|min:0',

            'selling_price' => 'required|numeric|min:0',

            'discount' => 'nullable|numeric|min:0|max:100',

            'isbn13' => 'required|string|max:50',

            'language' => 'required|string|max:100',

            'category' => 'required|integer',

            'subcategory' => 'required|integer',

            'childcategory' => 'required|integer',

            'hsn_code' => 'nullable|string|max:100',

            'gst_charge' => 'nullable|numeric',

            'status' => 'required|in:0,1,2',

            'url_slug' => 'required|string|max:255',

            'addmore' => 'required|array|min:1',

            'addmore.*.condition' => 'required|string|max:100',

            'addmore.*.price' => 'required|numeric|min:0',

            'addmore.*.stock' => 'required|numeric|min:1',

            'addmore.*.book_weight' => 'nullable|numeric|min:0',

            'addmore.*.sku_number' => [
                'required',
                'string',
                'max:100'
            ],

            'addmore.*.images' => 'nullable|array',

            'addmore.*.images.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ],

        ], [

            'listed_by.required' =>
                'Please select Listed By.',

            'name.required' =>
                'Please enter book title.',

            'thumbnail_image.required' =>
                'Please upload outer cover image.',

            'original_price.required' =>
                'Please enter MRP.',

            'selling_price.required' =>
                'Please enter selling price.',

            'isbn13.required' =>
                'Please enter ISBN13.',

            'language.required' =>
                'Please select language.',

            'category.required' =>
                'Please select category.',

            'subcategory.required' =>
                'Please select sub category.',

            'childcategory.required' =>
                'Please select child category.',

            'addmore.required' =>
                'At least one inventory item is required.',

            'addmore.*.condition.required' =>
                'Please select book condition.',

            'addmore.*.price.required' =>
                'Please enter inventory price.',

            'addmore.*.stock.required' =>
                'Please enter stock.',

            'addmore.*.sku_number.required' =>
                'Please enter SKU number.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validation Response
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            if ($request->ajax()) {

                return response()->json([
                    'status' => false,
                    'message' => 'Please check the entered details.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | SKU Duplicate Check
        |--------------------------------------------------------------------------
        */

        $skuNumbers = collect($request->addmore)
            ->pluck('sku_number')
            ->map(function ($sku) {
                return trim($sku);
            })
            ->filter()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Duplicate SKU Inside Request
        |--------------------------------------------------------------------------
        */

        if ($skuNumbers->duplicates()->isNotEmpty()) {

            $duplicateSkus = $skuNumbers
                ->duplicates()
                ->values()
                ->implode(', ');

            if ($request->ajax()) {

                return response()->json([
                    'status' => false,
                    'message' => 'Duplicate SKU found: ' . $duplicateSkus,
                    'errors' => [
                        'sku_number' => [
                            'Duplicate SKU found: ' . $duplicateSkus
                        ]
                    ]
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'sku_number' =>
                        'Duplicate SKU found: ' . $duplicateSkus
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Check SKU Already Exists In Database
        |--------------------------------------------------------------------------
        */

        $existingSkus = BookVarient::whereIn(
            'sku_number',
            $skuNumbers->toArray()
        )->pluck('sku_number');


        if ($existingSkus->isNotEmpty()) {

            $existingSkuList = $existingSkus->implode(', ');

            if ($request->ajax()) {

                return response()->json([
                    'status' => false,
                    'message' =>
                        'SKU already exists: ' . $existingSkuList,
                    'errors' => [
                        'sku_number' => [
                            'SKU already exists: ' .
                            $existingSkuList
                        ]
                    ]
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'sku_number' =>
                        'SKU already exists: ' .
                        $existingSkuList
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Variables For Cleanup
        |--------------------------------------------------------------------------
        */

        $uploadedFiles = [];

        $thumbnailPath = public_path(
            'upload/admin_images/books'
        );

        $variantImagePath = public_path('images');


        /*
        |--------------------------------------------------------------------------
        | Create Directories If Not Exists
        |--------------------------------------------------------------------------
        */

        if (!File::exists($thumbnailPath)) {
            File::makeDirectory(
                $thumbnailPath,
                0755,
                true
            );
        }

        if (!File::exists($variantImagePath)) {
            File::makeDirectory(
                $variantImagePath,
                0755,
                true
            );
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Thumbnail Upload
            |--------------------------------------------------------------------------
            */

            $imageName2 = null;

            if ($request->hasFile('thumbnail_image')) {

                $imageFile =
                    $request->file('thumbnail_image');

                $time = now()->format('YmdHis');

                $originalName = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                // Remove unwanted characters
                $originalName = preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '-',
                    $originalName
                );

                $extension =
                    strtolower(
                        $imageFile->getClientOriginalExtension()
                    );

                $imageName2 =
                    $originalName .
                    '-' .
                    $time .
                    '-' .
                    uniqid() .
                    '.' .
                    $extension;

                $imageFile->move(
                    $thumbnailPath,
                    $imageName2
                );

                $uploadedFiles[] =
                    $thumbnailPath .
                    '/' .
                    $imageName2;
            }


            /*
            |--------------------------------------------------------------------------
            | Create Book
            |--------------------------------------------------------------------------
            */

            $book = new Book();

            $book->category_id =
                $request->input('category');

            $book->subcategory_id =
                $request->input('subcategory');

            $book->childcategory_id =
                $request->input('childcategory');

            $book->author =
                $request->input('author');

            $book->name =
                $request->input('name');

            $book->title_long =
                $request->input('title_long');

            $book->isbn13 =
                trim($request->input('isbn13'));

            $book->publisher =
                $request->input('publisher');

            $book->date_published =
                $request->input('date_published');

            $book->section_id =
                !empty($request->input('section_id'))
                    ? implode(
                        ',',
                        $request->input('section_id')
                    )
                    : '';
            $book->format = $request->input('format');
            $book->language =
                $request->input('language');

            $book->edition =
                $request->input('edition');

            $book->overview =
                $request->input('overview');

            $book->pages =
                $request->input('pages');

            $book->dimensions =
                $request->input('dimensions');

            $book->multi_image =
                json_encode([]);

            $book->image =
                $imageName2;

            $book->meta_name =
                $request->input('meta_name');

            $book->url_slug =
                $request->input('url_slug');

            $book->meta_description =
                $request->input('meta_description');

            $book->meta_keyword =
                $request->input('meta_keyword');

            $book->hsn_code =
                $request->input('hsn_code');

            $book->synopsis =
                $request->input('synopsis');

            $book->original_price =
                $request->input('original_price');

            $book->selling_price =
                $request->input('selling_price');

            $book->discount =
                $request->input('discount');

            $book->gst_charge =
                $request->input('gst_charge', 0);

            $book->status = 2;

            $book->listed_by =
                $request->input('listed_by');

            $book->save();


            /*
            |--------------------------------------------------------------------------
            | Generate Book ID
            |--------------------------------------------------------------------------
            */

            $book->book_id =
                '#UBRB' . $book->id;

            $book->save();


            /*
            |--------------------------------------------------------------------------
            | Create Inventory / Variants
            |--------------------------------------------------------------------------
            */

            foreach ($request->addmore as $index => $admm) {

                $gallery = new BookVarient();

                $gallery->book_id =
                    $book->id;

                $gallery->bookconditions =
                    trim($admm['condition']);

                $gallery->price =
                    $admm['price'];

                $gallery->stock =
                    $admm['stock'];

                $gallery->book_weight =
                    $admm['book_weight'] ?? null;


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT:
                | Use SKU entered from frontend
                |--------------------------------------------------------------------------
                */

                $gallery->sku_number =
                    trim($admm['sku_number']);


                /*
                |--------------------------------------------------------------------------
                | Variant Images
                |--------------------------------------------------------------------------
                */

                $multiple_image = [];


                if (
                    isset($admm['images']) &&
                    is_array($admm['images'])
                ) {

                    foreach (
                        $admm['images']
                        as $imageIndex => $image
                    ) {

                        if (
                            $image &&
                            $image->isValid()
                        ) {

                            $extension =
                                strtolower(
                                    $image->getClientOriginalExtension()
                                );

                            $imageName =
                                now()->format('YmdHis') .
                                '_' .
                                $book->id .
                                '_' .
                                $index .
                                '_' .
                                $imageIndex .
                                '_' .
                                uniqid() .
                                '.' .
                                $extension;


                            $image->move(
                                $variantImagePath,
                                $imageName
                            );


                            $multiple_image[] =
                                $imageName;


                            $uploadedFiles[] =
                                $variantImagePath .
                                '/' .
                                $imageName;
                        }
                    }
                }


                $gallery->images =
                    json_encode($multiple_image);

                $gallery->save();
            }


            /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | AJAX Success Response
            |--------------------------------------------------------------------------
            */

            if ($request->ajax()) {

                return response()->json([
                    'status' => true,
                    'message' =>
                        'Book added successfully.',
                    'book_id' =>
                        $book->id,
                    'book_code' =>
                        $book->book_id,
                    'redirect_url' =>
                        route('books.all')
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Normal Request Success
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('books.all')
                ->with([
                    'message' =>
                        'Book Added Successfully',
                    'alert-type' =>
                        'success'
                ]);


        } catch (\Throwable $e) {


            /*
            |--------------------------------------------------------------------------
            | Rollback
            |--------------------------------------------------------------------------
            */

            DB::rollBack();

            foreach ($uploadedFiles as $file) {

                if (File::exists($file)) {

                    File::delete($file);
                }
            }
            Log::error(
                'Book Store Error',
                [
                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),

                    'request' =>
                        $request->except([
                            'thumbnail_image',
                            'addmore'
                        ])
                ]
            );
            if ($request->ajax()) {

                return response()->json([
                    'status' => false,
                    'message' =>
                        'Unable to add book. Please try again.',
                    'error' =>
                        config('app.debug')
                            ? $e->getMessage()
                            : null
                ], 500);
            }
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' =>
                        'Unable to add book. Please try again.',
                    'alert-type' =>
                        'error'
                ]);
        }
    }
       public function AttributeTest($id)
    {
        $book_details = Book::where('id', $id)->first();
        $BookVarient = BookVarient::where('book_id', $id)->get();
        $condition_types = BookCondition::where('status',1)->get();
        
        return view('backend.books.multi',compact('book_details','BookVarient','condition_types'));
    }
    
    public function AttributeUpdate(Request $request)
    {
        
        
        BookVarient::Where('book_id',$request->id)->forceDelete();
        
        if($request->addmore)     
        {
            foreach($request->addmore as $key => $admm)
            {
                // dd($admm);
                $multiple_image = [];
                if($admm['price']){
                    $gallery = New BookVarient;
                    $gallery->book_id = $book->id;
                    $gallery->bookconditions = $admm['condition'];
                    $gallery->price = $admm['price'];
                    $gallery->stock = $admm['stock'];
                    if ($gallery->save()) {
                        if ($admm['images']) {
                            foreach ($admm['images'] as $key => $value) {
                                if (isset($value) && $value) {
                                    $old_name = $value->getClientOriginalName();

                                    $origi_name = str_replace($value->extension(), '', $old_name);

                                    $imageName1 = time().''.$key.'.'.$value->extension();
                                    $value->move(public_path('images'), $imageName1);

                                    $book_uploads                   = New ImageUpload;
                                    $book_uploads->book_id          = $book->id;
                                    $book_uploads->attribute_id     = $gallery->id;
                                    $book_uploads->image_name       = $imageName1;
                                    $book_uploads->image_old_name   = $origi_name;
                                    $book_uploads->save();

                                }
                                // $multiple_image[] = $imageName1;
                            }
                        }
                    }
                }
            }
        }

        $notification = array(
            'message' => 'Book Added Successfully', 
            'alert-type' => 'success'
        );
        
        return redirect()->route('books.all')->with($notification);
        
    }
    
    public function edit(Request $request, $id)
    {
        $books =Books::where('id',$id)->first();
        $categories = Category::where('status',1)->Where('level',1)->get();
        $subcategories = Category::where('status',1)->Where('level',2)->Where('parent_id',$books->category_id)->get();
        $childcategories = Category::where('status',1)->Where('level',3)->Where('parent_id',$books->subcategory_id)->get();
        $bindings =Binding::where('status',1)->get();
        $condition_types = BookCondition::where('status',1)->get();
        $languages =Language::where('status',1)->get();
        $varients = BookVarient::where('book_id',$id)->get();
        return view('backend.books.edit',compact('bindings','categories','subcategories','childcategories','books','varients','condition_types','languages'));
    } // End Method 
    
    public function Update(Request $request)
    {
        $imageName2 = $request->imgae_old_tump ?? "";
        if ($request->hasFile('thumbnail_image')) {
            $imgae_file = $request->file('thumbnail_image');
            $var1 = date_create();
            $time1 = date_format($var1, 'YmdHis');
            $file_name = pathinfo($imgae_file->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName2 = $file_name . '-' . $time1 . '.' . $imgae_file->getClientOriginalExtension();
            $imgae_file->move(public_path('upload/admin_images/books'), $imageName2);
        }

        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '20M');
        ini_set('max_input_time', 300);
        ini_set('max_execution_time', 300);

        $arr = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $value) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $imageName = $time . '-' . $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images'), $imageName);
                $arr[] = $imageName;
            }
        }

        $book = Book::findOrFail($request->input('id'));
        $book->section_id       = !empty($request->input('section_id')) ? implode(',', $request->input('section_id')) : '';
        $book->category_id      = $request->input('category');
        $book->subcategory_id   = $request->input('subcategory');
        $book->childcategory_id = $request->input('childcategory');
        $book->author           = $request->input('author');
        $book->name             = $request->input('name');
        $book->title_long       = $request->input('title_long');
        $book->isbn             = $request->input('isbn');
        $book->meta_name        = $request->meta_name;
        $book->url_slug         = $request->url_slug;
        $book->meta_description = $request->meta_description;
        $book->meta_keyword     = $request->meta_keyword;
        $book->isbn13           = $request->input('isbn13');
        $book->publisher        = $request->input('publisher');
        $book->date_published  = $request->input('date_published');
        $book->format           = $request->input('format');
        $book->language         = $request->input('language');
        $book->overview         = $request->input('overview');
        $book->edition          = $request->input('edition');
        $book->pages            = $request->input('pages');
        $book->dimensions       = $request->input('dimensions');
        $book->image            = $imageName2;
        
        $book->multi_image      = !empty($arr) ? json_encode($arr) : $request->input('old_multiple_image');
        
        $book->sku              = $request->input('sku_numer');
        $book->hsn_code         = $request->input('hsn_code');
        $book->synopsis         = $request->input('synopsis');
        $book->original_price   = $request->input('original_price');
        $book->selling_price    = $request->input('selling_price');
        $book->discount         = $request->input('discount');
        $book->gst_charge       = $request->input('gst_charge');
        $book->status           = $request->input('status');
        $book->listed_by        = $request->listed_by;
        $book->save();

        BookVarient::where('book_id', $book->id)->forceDelete();

        if ($request->addmore && is_array($request->addmore)) {
            foreach ($request->addmore as $admm) {
                if (!empty($admm['price'])) {
                    $gallery = new BookVarient();
                    $gallery->book_id        = $book->id;
                    $gallery->bookconditions = $admm['condition'] ?? null;
                    $gallery->price          = $admm['price'];
                    $gallery->stock          = $admm['stock'] ?? 0;
                    $gallery->book_weight    = $admm['book_weight'] ?? null;
                    $gallery->sku_number     = $admm['sku_number'] ?? null;

                    $finalVariantImages = [];

                    if (!empty($admm['hidden'])) {
                        $existingImages = is_string($admm['hidden']) 
                            ? json_decode($admm['hidden'], true) 
                            : $admm['hidden'];

                        if (is_array($existingImages)) {
                            $finalVariantImages = array_merge($finalVariantImages, $existingImages);
                        }
                    }
                    if (isset($admm['images']) && is_array($admm['images'])) {
                        foreach ($admm['images'] as $key => $file) {
                            if ($file && $file->isValid()) {
                                $imageName1 = time() . '_' . rand(100, 999) . '_' . $key . '.' . $file->getClientOriginalExtension();
                                $file->move(public_path('images'), $imageName1);
                                $finalVariantImages[] = $imageName1;
                            }
                        }
                    }

                    $gallery->images = !empty($finalVariantImages) 
                        ? json_encode(array_values(array_unique($finalVariantImages))) 
                        : null;

                    $gallery->save();
                }
            }
        }

        $notification = [
            'message'    => 'Book Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('books.all')->with($notification);
    }
    
    public function APIBooksStore(Request $request)
    {

        $book = new Book();
        $book->category_id = $request->input('category');
        $book->binding_type_id = $request->input('binding_type');
        $book->condition_id = $request->input('condition');
        $book->binding = $request->input('binding');
        $book->name = $request->input('name');
        $book->title_long = $request->input('title_long');
        $book->isbn = $request->input('isbn');
        $book->isbn13 = $request->input('isbn13');
        $book->publisher = $request->input('publisher');
        $book->language = $request->input('language');
        $book->edition = $request->input('edition');
        $book->pages = $request->input('pages');
        $book->dimensions = $request->input('dimensions');
        $book->image = $request->input('image');
        $book->synopsis = $request->input('synopsis');
        $book->price = $request->input('price');
        $book->original_price = $request->input('original_price');
        $book->offer = $request->input('offer');
        $book->status = $request->input('status');
        $book->save();

        $notification = array(
            'message' => 'Book Added Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('api.books.all')->with($notification);

    }

    public function Delete($id)
    {   
        $book_details = BookVarient::where('book_id', $id)->get();
        

        if (count($book_details)) {
            foreach ($book_details as $key => $value) {
               
                $delete_file = json_decode($value->images);
                if ($delete_file) {
                    foreach($delete_file as $image_delete)
                    {
                        $filePath = public_path('images/').$image_delete;
                        if(File::exists($filePath))
                        {
                            File::delete($filePath);
                        }
                        else
                        {
                            // dd("hlo");
                        }
                        
                    }
                }
            }
        }
        $book = Book::find($id);
        if ($book->delete()) {
            $notification = array(
                'message' => 'Book Deleted Successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('books.all')->with($notification);
        }
        $notification = array(
            'message' => 'Book Deleted Successfully', 
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function download_books()
    {
        return Excel::download(new BookExport(), 'BookDetails.xlsx');
    }

    // public function BookImportStore(Request $request)
    // {
    //     // dd($request->all());

    //     $this->validate($request, [
    //       'excel_file'  => 'required|mimes:xls,xlsx'
    //      ]);

    //     $path = $request->file('excel_file');

    //     $check_data = Excel::import(new ImportBooks(), $path);

    //     if ($check_data) {
    //         $notification = array(
    //             'message' => 'Book Added Successfully', 
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    //     else
    //     {
    //         $notification = array(
    //             'message' => 'Something Wrong', 
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->back()->with($notification);
    //     }

    // }
    public function BookImportStore(Request $request)
    {
    
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        try {

            $path = $request->file('excel_file');

            $import = new ImportBooks();

            Excel::import($import, $path);

            $summary = $import->getSummary();

            return redirect()
                ->back()
                ->with('import_summary', $summary);


        } catch (\Throwable $e) {

            Log::error('Book Excel Import Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Excel import failed: ' . $e->getMessage()
                );
        }
    }

    public function BookDownloadCategories($id)
    {

        $data['categories']   = $id;

        return Excel::download(new ExportCategories($data), $id.'.xlsx');

    }
   
    public function nextSku(Request $request)
    {
        try {

            $nextNumber =
                $this->getNextUdbSkuNumber();


            $sku =
                $this->makeUdbSku(
                    $nextNumber
                );


            return response()->json([

                'success' => true,

                'sku' => $sku,

                'number' => $nextNumber,

            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Next SKU Error',
                [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                    'Unable to get next SKU.',

            ], 500);
        }
    }
       

    // SKU MANAGEMENt
    public function Skuindex(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | GET ALL PENDING SKU ITEMS
        |--------------------------------------------------------------------------
        */

        $items = $this->getPendingSkuItems($request);


        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $bookCount = $items
            ->where('type', 'Book')
            ->count();


        $variantCount = $items
            ->where('type', 'Variant')
            ->count();


        $totalSkus = $items->count();


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $currentPage =
            LengthAwarePaginator::resolveCurrentPage();


        $perPage = 15;


        $currentItems = $items
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )
            ->values();


        $pagination = new LengthAwarePaginator(

            $currentItems,

            $items->count(),

            $perPage,

            $currentPage,

            [
                'path' =>
                    LengthAwarePaginator::resolveCurrentPath(),

                'query' =>
                    $request->query(),
            ]

        );


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.sku.index',
            compact(
                'pagination',
                'totalSkus',
                'bookCount',
                'variantCount'
            )
        );
    }


    private function getPendingSkuItems(Request $request): Collection
    {

        $search =
            trim($request->search ?? '');


        $type =
            $request->type;


        $items =
            collect();


        if (
            !$type ||
            $type === 'Book'
        ) {

            $books = Books::query()

                ->where(function ($query) {

                    $query
                        ->whereNull('sku')
                        ->orWhere('sku', '');

                })
                ->whereDoesntHave('varients')
                ->when(
                    $search,
                    function ($query) use ($search) {

                        $query->where(
                            function ($q) use ($search) {

                                $q
                                    ->where(
                                        'name',
                                        'LIKE',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'isbn13',
                                        'LIKE',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'id',
                                        'LIKE',
                                        "%{$search}%"
                                    );

                            }
                        );

                    }
                )
                ->orderByDesc('id')

                ->get([
                    'id',
                    'name',
                    'isbn13',
                    'sku'
                ])


                ->map(
                    function ($book) {

                        return [

                            'sku' =>
                                $book->sku,

                            'book_id' =>
                                $book->id,

                            'variant_id' =>
                                null,

                            'book_name' =>
                                $book->name,

                            'isbn' =>
                                $book->isbn13,

                            'type' =>
                                'Book',

                            'condition' =>
                                'Standard',

                            'stock' =>
                                0,

                        ];

                    }
                );


            $items =
                $items->concat($books);

        }
        if (
            !$type ||
            $type === 'Variant'
        ) {

            $variants = BookVarient::with('book')

                ->where(function ($query) {

                    $query
                        ->whereNull('sku_number')
                        ->orWhere('sku_number', '');

                })
                ->when(
                    $search,
                    function ($query) use ($search) {

                        $query->where(
                            function ($q) use ($search) {

                                $q

                                    ->where(
                                        'id',
                                        'LIKE',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'sku_number',
                                        'LIKE',
                                        "%{$search}%"
                                    )

                                    ->orWhereHas(
                                        'book',
                                        function ($bookQuery)
                                            use ($search) {

                                            $bookQuery

                                                ->where(
                                                    'name',
                                                    'LIKE',
                                                    "%{$search}%"
                                                )

                                                ->orWhere(
                                                    'isbn13',
                                                    'LIKE',
                                                    "%{$search}%"
                                                )

                                                ->orWhere(
                                                    'id',
                                                    'LIKE',
                                                    "%{$search}%"
                                                );

                                        }
                                    );

                            }
                        );

                    }
                )
                ->orderByDesc('book_id')

                ->orderByDesc('id')

                ->get()
                ->map(
                    function ($variant) {

                        return [

                            'sku' =>
                                $variant->sku_number,

                            'book_id' =>
                                $variant->book_id,

                            'variant_id' =>
                                $variant->id,

                            'book_name' =>
                                $variant->book->name ?? 'N/A',

                            'isbn' =>
                                $variant->book->isbn13 ?? 'N/A',

                            'type' =>
                                'Variant',

                            'condition' =>
                                $variant->bookconditions ?? 'N/A',

                            'stock' =>
                                $variant->stock ?? 0,
                        ];

                    }
                );
            $items =
                $items->concat($variants);

        }

        return $items
            ->sortByDesc(
                function ($item) {

                    return $item['book_id'];

                }
            )
            ->values();
    }


    public function generate(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        |
        | If select_all = true:
        | items can be empty.
        |
        | If select_all = false:
        | items are required.
        |
        */

        $request->validate([

            'select_all' =>
                'nullable|boolean',

            'items' =>
                'nullable|array|max:10000',

            'items.*.book_id' =>
                'required_with:items|integer',

            'items.*.type' =>
                'required_with:items|in:Book,Variant',

            'items.*.variant_id' =>
                'nullable|integer',

            'search' =>
                'nullable|string',

            'type' =>
                'nullable|in:Book,Variant',

            'status' =>
                'nullable|string',

        ]);


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | CHECK SELECT ALL
            |--------------------------------------------------------------------------
            */

            $selectAll =
                $request->boolean('select_all');


            /*
            |--------------------------------------------------------------------------
            | 1. GET EXISTING SKU NUMBERS
            |--------------------------------------------------------------------------
            */

            $usedNumbers =
                collect();


            /*
            |--------------------------------------------------------------------------
            | BOOK SKUS
            |--------------------------------------------------------------------------
            */

            Books::query()

                ->whereNotNull('sku')

                ->where('sku', '!=', '')

                ->pluck('sku')

                ->each(
                    function ($sku) use ($usedNumbers) {

                        if (
                            preg_match(
                                '/^UDB-(\d+)$/i',
                                trim($sku),
                                $match
                            )
                        ) {

                            $usedNumbers->push(
                                (int) $match[1]
                            );

                        }

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | VARIANT SKUS
            |--------------------------------------------------------------------------
            */

            BookVarient::query()

                ->whereNotNull('sku_number')

                ->where('sku_number', '!=', '')

                ->pluck('sku_number')

                ->each(
                    function ($sku) use ($usedNumbers) {

                        if (
                            preg_match(
                                '/^UDB-(\d+)$/i',
                                trim($sku),
                                $match
                            )
                        ) {

                            $usedNumbers->push(
                                (int) $match[1]
                            );

                        }

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | REMOVE DUPLICATES
            |--------------------------------------------------------------------------
            */

            $usedNumbers =
                $usedNumbers
                    ->unique()
                    ->values();


            /*
            |--------------------------------------------------------------------------
            | START NUMBER
            |--------------------------------------------------------------------------
            */

            $nextNumber =
                100000001;


            /*
            |--------------------------------------------------------------------------
            | ASSIGNED
            |--------------------------------------------------------------------------
            */

            $assigned =
                [];


            /*
            |--------------------------------------------------------------------------
            | 2. GET ITEMS TO PROCESS
            |--------------------------------------------------------------------------
            |
            | SELECT ALL:
            |   Get ALL matching pending items from database.
            |
            | NORMAL:
            |   Get only selected checkbox items.
            |
            */

            if ($selectAll) {

                /*
                |--------------------------------------------------------------------------
                | ALL MATCHING RECORDS
                |--------------------------------------------------------------------------
                */

                $items =
                    $this->getPendingSkuItems($request);

            } else {

                /*
                |--------------------------------------------------------------------------
                | SELECTED CHECKBOX RECORDS
                |--------------------------------------------------------------------------
                */

                $items =
                    collect($request->items ?? []);

            }


            /*
            |--------------------------------------------------------------------------
            | NO ITEMS
            |--------------------------------------------------------------------------
            */

            if ($items->isEmpty()) {

                DB::rollBack();

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'No items found for SKU assignment.',

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | 3. PROCESS ITEMS
            |--------------------------------------------------------------------------
            */

            foreach (
                $items
                as $item
            ) {


                /*
                |--------------------------------------------------------------------------
                | BOOK
                |--------------------------------------------------------------------------
                */

                if (
                    ($item['type'] ?? null)
                    === 'Book'
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | GET BOOK
                    |--------------------------------------------------------------------------
                    */

                    $book =
                        Books::find(
                            $item['book_id']
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | BOOK NOT FOUND
                    |--------------------------------------------------------------------------
                    */

                    if (!$book) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ALREADY HAS SKU
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty($book->sku)
                    ) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | BOOK HAS VARIANTS
                    |--------------------------------------------------------------------------
                    */

                    $hasVariants =
                        BookVarient::where(
                            'book_id',
                            $book->id
                        )->exists();


                    if ($hasVariants) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | FIND NEXT UNUSED NUMBER
                    |--------------------------------------------------------------------------
                    */

                    while (
                        $usedNumbers->contains(
                            $nextNumber
                        )
                    ) {

                        $nextNumber++;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | GENERATE SKU
                    |--------------------------------------------------------------------------
                    */

                    $sku =
                        'UDB-' .
                        str_pad(
                            $nextNumber,
                            9,
                            '0',
                            STR_PAD_LEFT
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | SAVE
                    |--------------------------------------------------------------------------
                    */

                    $book->sku =
                        $sku;

                    $book->save();


                    /*
                    |--------------------------------------------------------------------------
                    | MARK NUMBER USED
                    |--------------------------------------------------------------------------
                    */

                    $usedNumbers->push(
                        $nextNumber
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ASSIGNED RESULT
                    |--------------------------------------------------------------------------
                    */

                    $assigned[] = [

                        'type' =>
                            'Book',

                        'book_id' =>
                            $book->id,

                        'sku' =>
                            $sku,

                    ];


                    $nextNumber++;

                }


                /*
                |--------------------------------------------------------------------------
                | VARIANT
                |--------------------------------------------------------------------------
                */

                elseif (
                    ($item['type'] ?? null)
                    === 'Variant'
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | GET VARIANT ID
                    |--------------------------------------------------------------------------
                    */

                    $variantId =
                        $item['variant_id']
                        ?? null;


                    if (!$variantId) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | GET VARIANT
                    |--------------------------------------------------------------------------
                    */

                    $variant =
                        BookVarient::find(
                            $variantId
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | VARIANT NOT FOUND
                    |--------------------------------------------------------------------------
                    */

                    if (!$variant) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ALREADY HAS SKU
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $variant->sku_number
                        )
                    ) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | FIND NEXT UNUSED NUMBER
                    |--------------------------------------------------------------------------
                    */

                    while (
                        $usedNumbers->contains(
                            $nextNumber
                        )
                    ) {

                        $nextNumber++;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | GENERATE SKU
                    |--------------------------------------------------------------------------
                    */

                    $sku =
                        'UDB-' .
                        str_pad(
                            $nextNumber,
                            9,
                            '0',
                            STR_PAD_LEFT
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | SAVE
                    |--------------------------------------------------------------------------
                    */

                    $variant->sku_number =
                        $sku;

                    $variant->save();


                    /*
                    |--------------------------------------------------------------------------
                    | MARK NUMBER USED
                    |--------------------------------------------------------------------------
                    */

                    $usedNumbers->push(
                        $nextNumber
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ASSIGNED RESULT
                    |--------------------------------------------------------------------------
                    */

                    $assigned[] = [

                        'type' =>
                            'Variant',

                        'book_id' =>
                            $variant->book_id,

                        'variant_id' =>
                            $variant->id,

                        'sku' =>
                            $sku,

                    ];


                    $nextNumber++;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | NOTHING ASSIGNED
            |--------------------------------------------------------------------------
            */

            if (
                count($assigned) === 0
            ) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'No new SKU was assigned. Selected items may already have SKU or may no longer be eligible.',

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    count($assigned) .
                    ' SKU(s) generated and assigned successfully.',

                'assigned' =>
                    $assigned,

            ]);


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | LOG ERROR
            |--------------------------------------------------------------------------
            */

            Log::error(
                'SKU Generation Error',
                [

                    'message' =>
                        $e->getMessage(),

                    'line' =>
                        $e->getLine(),

                    'file' =>
                        $e->getFile(),

                    'trace' =>
                        $e->getTraceAsString(),

                ]
            );


            /*
            |--------------------------------------------------------------------------
            | ERROR RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Unable to generate and assign SKU.',

            ], 500);

        }

    }
    public function qcEdit($id)
    {
        $books = Books::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sub Categories
        |--------------------------------------------------------------------------
        */

        $subcategories = Category::where(
            'parent_id',
            $books->category_id
        )
        ->orderBy('name')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Child Categories
        |--------------------------------------------------------------------------
        */

        $childcategories = Category::where(
            'parent_id',
            $books->subcategory_id
        )
        ->orderBy('name')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Languages
        |--------------------------------------------------------------------------
        */

        $languages = Language::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | Conditions
        |--------------------------------------------------------------------------
        */

        $condition_types = BookCondition::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | Variants
        |--------------------------------------------------------------------------
        */

        $varients = BookVarient::where(
            'book_id',
            $books->id
        )
        ->orderBy('id')
        ->get();


        return view(
            'backend.books.qc_edit',
            compact(
                'books',
                'categories',
                'subcategories',
                'childcategories',
                'languages',
                'condition_types',
                'varients'
            )
        );
    }
public function ApproveQc(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:books,id',

        'name' => 'required|string|max:255',

        'isbn13' => 'nullable|string|max:50',

        'category' => 'required',

        'subcategory' => 'required',

        'thumbnail_image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120'
        ],
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | GET BOOK
        |--------------------------------------------------------------------------
        */

        $book = Book::findOrFail($request->id);


        /*
        |--------------------------------------------------------------------------
        | COVER IMAGE
        |--------------------------------------------------------------------------
        */

        $imageName2 = $book->image;

        if ($request->hasFile('thumbnail_image')) {

            $imageFile = $request->file('thumbnail_image');

            $time = date('YmdHis');

            $fileName = pathinfo(
                $imageFile->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $extension = $imageFile->getClientOriginalExtension();

            $imageName2 =
                $fileName . '-' . $time . '.' . $extension;

            $imageFile->move(
                public_path('upload/admin_images/books'),
                $imageName2
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BOOK GALLERY IMAGES
        |--------------------------------------------------------------------------
        */

        $arr = [];

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $value) {

                if (!$value) {
                    continue;
                }

                $time = date('YmdHis');

                $imageName =
                    $time . '-' . $key . '.' .
                    $value->getClientOriginalExtension();

                $value->move(
                    public_path('images'),
                    $imageName
                );

                $arr[] = $imageName;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BOOK DETAILS
        |--------------------------------------------------------------------------
        */

        $book->section_id = !empty($request->section_id)
            ? implode(',', $request->section_id)
            : '';

        $book->category_id = $request->category;

        $book->subcategory_id = $request->subcategory;

        $book->childcategory_id = $request->childcategory;

        $book->author = $request->author;

        $book->name = $request->name;

        $book->title_long = $request->title_long;

        $book->isbn = $request->isbn;

        $book->isbn13 = $request->isbn13;

        $book->publisher = $request->publisher;

        $book->date_published = $request->date_published;

        $book->format = $request->format;

        $book->language = $request->language;

        $book->overview = $request->overview;

        $book->edition = $request->edition;

        $book->pages = $request->pages;

        $book->dimensions = $request->dimensions;

        $book->meta_name = $request->meta_name;

        $book->url_slug = $request->url_slug;

        $book->meta_description = $request->meta_description;

        $book->meta_keyword = $request->meta_keyword;

        $book->image = $imageName2;

        $book->sku = $request->sku_numer;

        $book->hsn_code = $request->hsn_code;

        $book->synopsis = $request->synopsis;

        $book->original_price = $request->original_price;

        $book->selling_price = $request->selling_price;

        $book->discount = $request->discount;

        $book->gst_charge = $request->gst_charge;

        $book->listed_by = $request->listed_by;


        /*
        |--------------------------------------------------------------------------
        | MULTIPLE BOOK IMAGES
        |--------------------------------------------------------------------------
        */

        if (!empty($arr)) {

            $book->multi_image = json_encode($arr);

        } else {

            $book->multi_image =
                $request->old_multiple_image;
        }


        /*
        |--------------------------------------------------------------------------
        | QC APPROVAL
        |--------------------------------------------------------------------------
        |
        | QC approve ஆனதும் ALWAYS ACTIVE
        |
        */

        $book->status = 1;


        /*
        |--------------------------------------------------------------------------
        | SAVE BOOK
        |--------------------------------------------------------------------------
        */

        $book->save();


        /*
        |--------------------------------------------------------------------------
        | DELETE OLD VARIANTS
        |--------------------------------------------------------------------------
        */

        BookVarient::where(
            'book_id',
            $book->id
        )->forceDelete();


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW VARIANTS
        |--------------------------------------------------------------------------
        */

        if ($request->has('addmore')) {

            foreach ($request->addmore as $admm) {

                /*
                | Skip completely empty row
                */

                if (
                    empty($admm['price']) &&
                    empty($admm['stock']) &&
                    empty($admm['condition'])
                ) {
                    continue;
                }


                $gallery = new BookVarient;

                $gallery->book_id =
                    $book->id;

                $gallery->bookconditions =
                    $admm['condition'] ?? null;


                /*
                |--------------------------------------------------------------------------
                | VARIANT IMAGES
                |--------------------------------------------------------------------------
                */

                $multiple_image = [];

                if (
                    isset($admm['images']) &&
                    !empty($admm['images'])
                ) {

                    foreach ($admm['images'] as $key => $value) {

                        if (!$value) {
                            continue;
                        }

                        $imageName1 =
                            time() .
                            '_' .
                            ($admm['condition'] ?? 'book') .
                            '_' .
                            $key .
                            '.' .
                            $value->getClientOriginalExtension();

                        $value->move(
                            public_path('images'),
                            $imageName1
                        );

                        $multiple_image[] =
                            $imageName1;
                    }

                    if (!empty($multiple_image)) {

                        $gallery->images =
                            json_encode($multiple_image);
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | OLD VARIANT IMAGES
                |--------------------------------------------------------------------------
                */

                elseif (
                    isset($admm['hidden']) &&
                    !empty($admm['hidden'])
                ) {

                    $gallery->images =
                        $admm['hidden'];
                }


                /*
                |--------------------------------------------------------------------------
                | VARIANT DETAILS
                |--------------------------------------------------------------------------
                */

                $gallery->price =
                    $admm['price'] ?? 0;

                $gallery->stock =
                    $admm['stock'] ?? 0;

                $gallery->book_weight =
                    $admm['book_weight'] ?? 0;

                $gallery->sku_number =
                    $admm['sku_number'] ?? null;


                $gallery->save();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | COMMIT
        |--------------------------------------------------------------------------
        */

        DB::commit();


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('books.all')
            ->with([
                'message' =>
                    'Book QC approved successfully. Book is now Active.',

                'alert-type' =>
                    'success'
            ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        \Log::error('Book QC Approval Error', [
            'book_id' => $request->id,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'message' =>
                    'Unable to approve QC. Please try again.',

                'alert-type' =>
                    'error'
            ]);
    }
}

public function ApproveQcSelected(Request $request)
{
    try {

        DB::beginTransaction();

        $selectAll = $request->boolean('select_all');

        /*
        |--------------------------------------------------------------------------
        | SELECT ALL
        |--------------------------------------------------------------------------
        */

        if ($selectAll) {

            $query = Books::query()
                ->where('status', 2);

            /*
            |--------------------------------------------------------------------------
            | SEARCH FILTER
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = trim($request->search);

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'name',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'book_id',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'isbn',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'isbn13',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'author',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'publisher',
                        'LIKE',
                        "%{$search}%"
                    );

                });
            }

            /*
            |--------------------------------------------------------------------------
            | APPROVE ALL MATCHING QC BOOKS
            |--------------------------------------------------------------------------
            */

            $count = $query->update([
                'status' => 1,
                'updated_at' => now(),
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | SELECTED CHECKBOXES
        |--------------------------------------------------------------------------
        */

        else {

            $ids = collect(
                $request->input('ids', [])
            )
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values();

            if ($ids->isEmpty()) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Please select at least one QC Pending book.'
                ], 422);
            }

            $count = Books::whereIn('id', $ids)
                ->where('status', 2)
                ->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);
        }


        DB::commit();


        return response()->json([
            'status' => true,
            'message' =>
                $count . ' book(s) QC approved successfully.'
        ]);


    } catch (\Throwable $e) {

        DB::rollBack();

        Log::error('Bulk QC Approval Error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Unable to approve selected books.'
        ], 500);
    }
}

private function getNextUdbSkuNumber()
{
    $usedNumbers = collect();

    /*
    |--------------------------------------------------------------------------
    | BOOK SKUS
    |--------------------------------------------------------------------------
    */

    Books::query()
        ->whereNotNull('sku')
        ->where('sku', '!=', '')
        ->pluck('sku')
        ->each(function ($sku) use ($usedNumbers) {

            if (
                preg_match(
                    '/^UDB-(\d+)$/i',
                    trim($sku),
                    $match
                )
            ) {

                $usedNumbers->push(
                    (int) $match[1]
                );
            }
        });


    /*
    |--------------------------------------------------------------------------
    | VARIANT SKUS
    |--------------------------------------------------------------------------
    */

    BookVarient::query()
        ->whereNotNull('sku_number')
        ->where('sku_number', '!=', '')
        ->pluck('sku_number')
        ->each(function ($sku) use ($usedNumbers) {

            if (
                preg_match(
                    '/^UDB-(\d+)$/i',
                    trim($sku),
                    $match
                )
            ) {

                $usedNumbers->push(
                    (int) $match[1]
                );
            }
        });


    /*
    |--------------------------------------------------------------------------
    | REMOVE DUPLICATES
    |--------------------------------------------------------------------------
    */

    $usedNumbers = $usedNumbers
        ->unique()
        ->values();


    /*
    |--------------------------------------------------------------------------
    | START NUMBER
    |--------------------------------------------------------------------------
    */

    $nextNumber = 100000001;


    /*
    |--------------------------------------------------------------------------
    | FIND NEXT UNUSED NUMBER
    |--------------------------------------------------------------------------
    */

    while (
        $usedNumbers->contains($nextNumber)
    ) {

        $nextNumber++;
    }


    return $nextNumber;
}


/**
 * Generate UDB SKU.
 */
private function makeUdbSku($number)
{
    return 'UDB-' .
        str_pad(
            $number,
            9,
            '0',
            STR_PAD_LEFT
        );
}

public function CheckIsbn(Request $request)
{
    $isbn = trim($request->isbn13);

    if (!$isbn) {
        return response()->json([
            'exists' => false
        ]);
    }

    $exists = Book::where('isbn13', $isbn)->exists();

    return response()->json([
        'exists' => $exists
    ]);
}
public function bulkImagesUpload(Request $request)
{
    try {
    
        if (!$request->hasFile('images')) {
            return response()->json([
                'status' => false,
                'message' => 'No images received by server.'
            ], 422);
        }

        $files = $request->file('images', []);
        $relativePaths = $request->input('relative_paths', []);

       
        $variantImagePath = public_path('images');

        if (!File::exists($variantImagePath)) {
            File::makeDirectory($variantImagePath, 0755, true);
        }

        
        $uploaded = 0;
        $skipped = 0;
        $matchedSkus = [];
        $unmatchedSkus = [];
        $errors = [];
        foreach ($files as $index => $image) {
            try {
                $relativePath = $relativePaths[$index] ?? '';

                if (!$relativePath) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'reason' => 'Relative path missing.'
                    ];
                    continue;
                }

                // Normalize Path
                $relativePath = str_replace('\\', '/', $relativePath);

                // Remove Empty Parts
                $parts = array_values(array_filter(explode('/', $relativePath)));

                $sku = null;
                foreach ($parts as $part) {
                    $folderName = strtoupper(trim($part));
                    if (preg_match('/^UDB-\d+$/i', $folderName)) {
                        $sku = $folderName;
                        break;
                    }
                }

                if (!$sku) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'path' => $relativePath,
                        'reason' => 'No valid UDB SKU folder found.'
                    ];
                    continue;
                }

             
                $variant = BookVarient::where('sku_number', $sku)->first();

                if (!$variant) {
                    $skipped++;
                    if (!in_array($sku, $unmatchedSkus)) {
                        $unmatchedSkus[] = $sku;
                    }
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'path' => $relativePath,
                        'sku' => $sku,
                        'reason' => 'SKU not found in BookVarient.'
                    ];
                    continue;
                }

               
                if (!$image->isValid()) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'sku' => $sku,
                        'reason' => 'Invalid image file.'
                    ];
                    continue;
                }
                
                $multipleImage = [];
                if (!empty($variant->images)) {
                    $decoded = json_decode($variant->images, true);
                    if (is_array($decoded)) {
                        $multipleImage = $decoded;
                    }
                }

                $incomingHash = md5_file($image->getRealPath());
                $isDuplicate = false;

                foreach ($multipleImage as $existingImageName) {
                    $existingFilePath = $variantImagePath . '/' . $existingImageName;

                    if (File::exists($existingFilePath)) {
                        // 1. Check if same file content already exists
                        if (md5_file($existingFilePath) === $incomingHash) {
                            $isDuplicate = true;
                            break;
                        }
                    }
                }

                if ($isDuplicate) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'sku' => $sku,
                        'reason' => 'Duplicate image skipped (Already exists for this SKU).'
                    ];
                    continue;
                }

                $extension = strtolower($image->getClientOriginalExtension());
                $imageName = now()->format('YmdHis') . '_' . $variant->book_id . '_bulk_' . $index . '_' . uniqid() . '.' . $extension;

                // Move file to public/images
                $image->move($variantImagePath, $imageName);

                // Append new image name & save to database
                $multipleImage[] = $imageName;
                $variant->images = json_encode(array_values($multipleImage));
                $variant->save();

                $uploaded++;

                if (!in_array($sku, $matchedSkus)) {
                    $matchedSkus[] = $sku;
                }

            } catch (\Throwable $e) {
                $skipped++;
                $errors[] = [
                    'file' => $image->getClientOriginalName(),
                    'path' => $relativePaths[$index] ?? '',
                    'reason' => $e->getMessage()
                ];

                Log::error('Bulk Book Image Error', [
                    'file' => $image->getClientOriginalName(),
                    'path' => $relativePaths[$index] ?? '',
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => $uploaded . ' image(s) uploaded successfully. ' . $skipped . ' skipped.',
            'uploaded' => $uploaded,
            'skipped' => $skipped,
            'matched_skus' => $matchedSkus,
            'unmatched_skus' => $unmatchedSkus,
            'errors' => $errors,
        ]);

    } catch (\Throwable $e) {
        Log::error('Bulk Book Image Upload Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
public function singleBookBulkImagesUpload(Request $request)
{
    try {
        if (!$request->hasFile('images')) {
            return response()->json([
                'status' => false,
                'message' => 'No images provided for upload.'
            ], 422);
        }

        $files = $request->file('images', []);
        $relativePaths = $request->input('relative_paths', []);
        $bookId = $request->input('book_id'); // Selected Book Primary Key

        if (!$bookId) {
            return response()->json([
                'status' => false,
                'message' => 'Target Book reference missing.'
            ], 422);
        }

        // Fetch Book and its Variants
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'status' => false,
                'message' => 'Book record not found.'
            ], 404);
        }

        $variants = BookVarient::where('book_id', $bookId)->get();

        // Custom Admin Upload Path matching URL (public/upload/admin_images/books/)
        $adminUploadPath = public_path('upload/admin_images/books');
        if (!File::exists($adminUploadPath)) {
            File::makeDirectory($adminUploadPath, 0755, true);
        }

        // Default Variant images directory
        $variantImagePath = public_path('images');
        if (!File::exists($variantImagePath)) {
            File::makeDirectory($variantImagePath, 0755, true);
        }

        $uploaded = 0;
        $skipped = 0;
        $errors = [];
        $thumbnailUpdated = false;

        foreach ($files as $index => $image) {
            try {
                if (!$image->isValid()) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'reason' => 'Invalid file stream.'
                    ];
                    continue;
                }

                $relativePath = str_replace('\\', '/', $relativePaths[$index] ?? '');
                $parts = array_values(array_filter(explode('/', $relativePath)));

                // Root folder image check: folder depth <= 2 (e.g., "book/image.jpg" or "image.jpg")
                $isLooseRootImage = (count($parts) <= 2);

                if ($isLooseRootImage) {
                    // STORE AS MAIN BOOK IMAGE THUMBNAIL
                    $extension = strtolower($image->getClientOriginalExtension());
                    
                    // Matches target filename structure e.g., Screenshot (959)-20260828173315.png
                    $rawOriginalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $thumbnailName = $rawOriginalName . '-' . now()->format('YmdHis') . '.' . $extension;

                    // Delete existing old book image if present
                    if (!empty($book->image)) {
                        $oldImagePath = $adminUploadPath . '/' . basename($book->image);
                        if (File::exists($oldImagePath)) {
                            File::delete($oldImagePath);
                        }
                    }

                    // Move file directly to upload/admin_images/books
                    $image->move($adminUploadPath, $thumbnailName);

                    // Update path string in DB
                    $book->image =  $thumbnailName;
                    $book->save();

                    $thumbnailUpdated = true;
                    $uploaded++;
                    continue;
                }

                // SUB-FOLDER IMAGES (VARIANT MAPPING)
                $targetVariant = null;

                // Match inner sub-folder with SKU Number
                foreach ($parts as $part) {
                    $partClean = trim($part);
                    $targetVariant = $variants->first(function ($v) use ($partClean) {
                        return strtolower($v->sku_number) === strtolower($partClean);
                    });
                    if ($targetVariant) break;
                }

                // Fallback: If only 1 variant exists for this book
                if (!$targetVariant && $variants->count() === 1) {
                    $targetVariant = $variants->first();
                }

                if (!$targetVariant) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'reason' => 'Folder/SKU mismatch for variant.'
                    ];
                    continue;
                }

                // Decode existing variant images JSON
                $multipleImage = [];
                if (!empty($targetVariant->images)) {
                    $decoded = json_decode($targetVariant->images, true);
                    if (is_array($decoded)) {
                        $multipleImage = $decoded;
                    }
                }

                // Duplicate check using MD5
                $incomingHash = md5_file($image->getRealPath());
                $isDuplicate = false;

                foreach ($multipleImage as $existingImageName) {
                    $existingFilePath = $variantImagePath . '/' . $existingImageName;
                    if (File::exists($existingFilePath) && md5_file($existingFilePath) === $incomingHash) {
                        $isDuplicate = true;
                        break;
                    }
                }

                if ($isDuplicate) {
                    $skipped++;
                    $errors[] = [
                        'file' => $image->getClientOriginalName(),
                        'reason' => 'Duplicate image skipped.'
                    ];
                    continue;
                }

                // Save Variant Image
                $extension = strtolower($image->getClientOriginalExtension());
                $imageName = now()->format('YmdHis') . '_b' . $bookId . '_var_' . $index . '_' . uniqid() . '.' . $extension;

                $image->move($variantImagePath, $imageName);

                $multipleImage[] = $imageName;
                $targetVariant->images = json_encode(array_values($multipleImage));
                $targetVariant->save();

                $uploaded++;

            } catch (\Throwable $e) {
                $skipped++;
                $errors[] = [
                    'file' => $image->getClientOriginalName(),
                    'reason' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Upload processed successfully.',
            'uploaded' => $uploaded,
            'skipped' => $skipped,
            'thumbnail_updated' => $thumbnailUpdated,
            'errors' => $errors
        ]);

    } catch (\Throwable $e) {
        Log::error('Single Book Bulk Upload Error', [
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}



}



