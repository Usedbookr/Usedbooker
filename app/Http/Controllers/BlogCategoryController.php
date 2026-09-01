<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function All()
    {
        $ratings = BlogCategory::latest()->paginate(100);
        return view('backend.blog.category.all',compact('ratings'));
    } // End Method 


    public function Add()
    {
        return view('backend.blog.category.add');
    } // End Method 

    public function Edit($id)
    {
        $ratingreview =BlogCategory::where('id',$id)->first();
        return view('backend.blog.category.edit',compact('ratingreview'));
    } // End Method 
    
    public function Store(Request $request)
    {
        if($request->id)
        {
            $book               = BlogCategory::find($request->id);
        }
        else
        {
            $book               = new BlogCategory();
        }
        
        $book->name             = $request->input('name');
        $book->category_slug    = $request->input('category_slug');
        $book->status           = $request->input('status');
        $book->save();
        
        if ($request->id) {
            $notification = array(
                'message' => 'Blog Category Created Successfully', 
                'alert-type' => 'success'
            );
        }
        else
        {
            $notification = array(
                'message' => 'Blog Category Updated Successfully', 
                'alert-type' => 'success'
            );
        }
        return redirect()->route('blog.category.all')->with($notification);
    }
    
    public function Delete($id)
    {
        BlogCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
