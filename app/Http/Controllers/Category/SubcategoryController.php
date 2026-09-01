<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use File;
use Illuminate\Support\Carbon;


class SubcategoryController extends Controller
{
    public function All(){
        $categories = Category::Where('level',2)->latest()->get();
        return view('backend.subcategory.all',compact('categories'));
    } // End Method 


    
    Public function ApiAll(){
        $categories = Category::Where('level',2)->Where('status',1)->get();
        if($categories->isNotEmpty()){
            foreach($categories as $catlists){
                $catlists->images = asset($catlists->images);
            }
        }
        return response([
            'success' => true,
            'categories' => $categories
        ]);
        //return view('backend.category.all',compact('categories'));
    }
    
    Public function ApiSubcategory(Request $request, $id){
        $categories = Category::Where('level',2)->Where('parent_id',$id)->Where('status',1)->get();
        if($categories->isNotEmpty()){
            foreach($categories as $catlists){
                $catlists->images = asset($catlists->images);
            }
        }
        return response([
            'success' => true,
            'categories' => $categories
        ]);
        //return view('backend.category.all',compact('categories'));
    }

    public function Add(){
        $categories = Category::Where('level',1)->Where('status',1)->get();
        return view('backend.subcategory.add',compact('categories'));
    } // End Method 


    public function Store(Request $request){

        $imageName = '';
        if($request->hasFile('userfile')){
            $imageName = time().'.'.$request->userfile->extension(); 
            $request->userfile->move(public_path('upload/admin_images/category'), $imageName); 
        }
        Category::insert([
            'name' => $request->name,
            'status' =>$request->status,
            'parent_id' =>$request->category,
            'best_seller' =>$request->section_id,
            'before_content' =>$request->before_content,
            'url_slug' =>$request->url_slug,
            'level' =>2,
            'images' => 'public/upload/admin_images/category/'.$imageName,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'meta_name' => $request->meta_name,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,

        ]);

         $notification = array(
            'message' => 'Sub-Category Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('subcategories.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = Category::findOrFail($id);
        $categories = Category::Where('level',1)->Where('status',1)->get();
        return view('backend.subcategory.edit',compact('edit','categories'));

    } // End Method 

    public function Update(Request $request){
    
        $id = $request->id;
        if($request->hasFile('userfile'))
        {
            $image_path = Category::where('id', $id)->first();
            $filePath = $image_path->images;
                                       
            if(File::exists($filePath))
            {
                File::delete($filePath);
            }
            else
            {
                // dd("hlo");
            }

            $imageName = time().'.'.$request->userfile->extension(); 
            $request->userfile->move(public_path('upload/admin_images/category'), $imageName); 
            Category::findOrFail($id)->update([
                'images' => 'public/upload/admin_images/category/'.$imageName,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(), 
    
            ]);
        }
        Category::findOrFail($id)->update([
            'parent_id' =>$request->category,
            'name' => $request->name,
            'status' => $request->status,
            'best_seller' =>$request->section_id,
            'before_content' =>$request->before_content,
            'url_slug' =>$request->url_slug,
            'level' =>2,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 
            'meta_name' => $request->meta_name,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('subcategories.all')->with($notification);

    } // End Method 


    public function Delete($id)
    {
        $image_path = Category::where('id', $id)->first();
        $filePath = $image_path->images;
                                   
        if(File::exists($filePath))
        {
            File::delete($filePath);
        }
        else
        {
            // dd("hlo");
        }

        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method
    

    public function FetchBook()
    {
        try{
            // $url = 'https://api2.isbndb.com/book/935010587X';  
            // $restKey = '50363_9a77755a173b1d79066197d0ce1bf427';  
            
            // $headers = array(  
            //   "Content-Type: application/json",  
            //   "Authorization: " . $restKey  
            // ); 
            
            // $author = rawurlencode('Disha Experts');
            // $url = "https://api2.isbndb.com/author/{$author}";  
            // $restKey = '50363_9a77755a173b1d79066197d0ce1bf427';  

            $url = "https://api2.isbndb.com/books/isbn";  
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
            //dd($jsonResponse);
            
            return response([
                'success' => true,
                'response' => $jsonResponse
            ]);
            
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



    public function FetchAuthors()
    {
        try{
            // $url = 'https://api2.isbndb.com/book/935010587X';  
            // $restKey = '50363_9a77755a173b1d79066197d0ce1bf427';  
            
            // $headers = array(  
            //   "Content-Type: application/json",  
            //   "Authorization: " . $restKey  
            // ); 
            
            $author = rawurlencode('Disha Experts');
            $url = "https://api2.isbndb.com/author/{$author}";  
            $restKey = env('REST_KEY');  

            // $url = "https://api2.isbndb.com/books/isbn";  
            // $restKey = '50363_9a77755a173b1d79066197d0ce1bf427';  
            
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
            
            return response([
                'success' => true,
                'response' => $jsonResponse
            ]);
            
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


    
}
