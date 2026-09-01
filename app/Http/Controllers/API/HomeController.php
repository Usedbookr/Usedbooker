<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\Binding;
use App\Models\Category;
use App\Models\BookVarient;
use App\Models\BookCondition;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Order;


class HomeController extends Controller
{
    public function ApiCatSubAll(){
        $category = Category::where('status',1)->Where('parent_id',0)->get();
        if($category->isNotEmpty())
        {
            foreach($category as $categ)
            {
                $categ->images = asset($categ->images);
                $categ->subcategories = Category::where('status',1)->Where('parent_id',$categ->id)->get();
                if($categ->subcategories->isNotEmpty())
                {
                    foreach($categ->subcategories as $subcateg)
                    {
                        $subcateg->images = asset($subcateg->images);
                        $subcateg->childcategories = Category::where('status',1)->Where('parent_id',$subcateg->id)->get();
                        if($subcateg->childcategories->isNotEmpty())
                        {
                            foreach($subcateg->childcategories as $childcateg)
                            {
                                $childcateg->images = asset($childcateg->images);
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['categories'=>$category,'success'=>true]); 
    }
    
    public function FetchAuthor(){
        $authors=Author::where('status',1)->limit(10)->get();
        return response()->json(['authors'=>$authors,'success'=>true]); 
    }

    public function Books(){
        $book_conditions = BookCondition::where('status',1)->get();
        $books = Book::where('status',1)->with('categories:id,name','binding_type:id,name','book_condition:id,name')->limit(10)->get();
        return response()->json(['book_conditions'=>$book_conditions,'books'=>$books,'success'=>true]); 
    }

    public function aboutus(){
        $page = Page::where('id',1)->get();
        return response()->json(['page'=>$page,'success'=>true]); 
    }
    public function termscondition(){
        $page = Page::where('id',3)->get();
        return response()->json(['page'=>$page,'success'=>true]); 
    }
    public function privacypolicy(){
        $page = Page::where('id',2)->get();
        return response()->json(['page'=>$page,'success'=>true]); 
    }
    public function faqs(){
        $page = Page::where('id',4)->get();
        return response()->json(['page'=>$page,'success'=>true]); 
    }

    public function Newarrival()
    {
        $books = Book::Where('status',1)->whereRaw('FIND_IN_SET("N",section_id)')->latest()->get();
        if($books->isNotEmpty())
        {
            foreach($books as $book){
                $book->author = Author::Where('id',$book->author_id)->get(['author']);
                $book->varient = BookVarient::Where('book_id',$book->id)->get(['bindings','bookconditions','price']);
                $book->category_id = Category::Where('id',$book->category_id)->get(['name']);
                $book->subcategory_id = Category::Where('id',$book->subcategory_id)->get(['name']);
                $book->childcategory_id = Category::Where('id',$book->childcategory_id)->get(['name']);
            }
        }
        return response()->json(['books'=>$books,'success'=>true]); 
    }

    public function Bestseller()
    {
        $books = Book::Where('status',1)->whereRaw('FIND_IN_SET("B",section_id)')->latest()->get();
        if($books->isNotEmpty()){
            foreach($books as $book){
                $book->category_id = Category::Where('id',$book->category_id)->get(['name']);
                $book->subcategory_id = Category::Where('id',$book->subcategory_id)->get(['name']);
                $book->childcategory_id = Category::Where('id',$book->childcategory_id)->get(['name']);
                $book->author = Author::Where('id',$book->author_id)->get(['author']);
                $book->varient = BookVarient::Where('book_id',$book->id)->get(['bindings','bookconditions','price']);
            }
        }
        return response()->json(['books'=>$books,'success'=>true]); 
    }
    
    public function pgredirect(Request $request)
    {
        //print_r($request->all());die;
        $allresp = $request->all();
	    $status = $allresp['code'];
	    if($status=='PAYMENT_SUCCESS')
	    {
    	    $sales_id = substr($allresp['transactionId'],4);
    	    $ref_id = $allresp['providerReferenceId'];
    	    $amount = $allresp['amount'];
    	    
    	    $updatesale = New Payment;
    		$updatesale->order_id = $sales_id;
    		$updatesale->amount = $amount/100;
    		$updatesale->reference_id = $ref_id;
    		$updatesale->status = $status;
            $updatesale->resp = json_encode($allresp);
    		$updatesale->save();
    		
    		$updatesale = Order::find($sales_id);
    		$updatesale->payment_status = 'Paid';
    		$updatesale->save();
    		return redirect()->away('https://usedbookr.com/demo1/paymentinvoice/'.$sales_id);
	    }
	    else {
	        return redirect()->away('https://usedbookr.com/demo1/');
	    }
    }
}
