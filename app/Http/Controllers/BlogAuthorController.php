<?php

namespace App\Http\Controllers;

use App\Models\BlogAuthor;
use Illuminate\Http\Request;

class BlogAuthorController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function All()
    {
        $ratings = BlogAuthor::latest()->paginate(100);
        return view('backend.blog.author.all',compact('ratings'));
    } // End Method 


    public function Add()
    {
        return view('backend.blog.author.add');
    } // End Method 

    public function Edit($id)
    {
        $ratingreview =BlogAuthor::where('id',$id)->first();
        return view('backend.blog.author.edit',compact('ratingreview'));
    } // End Method 
    
    public function Store(Request $request)
    {
        if($request->id)
        {
            $book               = BlogAuthor::find($request->id);
        }
        else
        {
            $book               = new BlogAuthor();
        }
        
        $book->name             = $request->input('name');
        $book->author_slug      = $request->input('author_slug');
        $book->status           = $request->input('status');
        $book->save();
        
        if ($request->id) {
            $notification = array(
                'message' => 'Blog Author Created Successfully', 
                'alert-type' => 'success'
            );
        }
        else
        {
            $notification = array(
                'message' => 'Blog Author Updated Successfully', 
                'alert-type' => 'success'
            );
        }
        return redirect()->route('blog.author.all')->with($notification);
    }
    
    public function Delete($id)
    {
        BlogAuthor::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
