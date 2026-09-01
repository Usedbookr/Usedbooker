<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogAuthor;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function All()
    {
        $ratings = Blog::latest()->paginate(100);
        return view('backend.blog.all',compact('ratings'));
    } // End Method 


    public function Add()
    {
        $blog_author = BlogAuthor::latest()->get();
        $blog_category = BlogCategory::latest()->get();

        return view('backend.blog.add', compact('blog_category', 'blog_author'));
    } // End Method 

    public function Edit($id)
    {
        $blog_author = BlogAuthor::latest()->get();
        $blog_category = BlogCategory::latest()->get();

        $ratingreview =Blog::where('id',$id)->first();
        return view('backend.blog.edit',compact('ratingreview', 'blog_category', 'blog_author'));
    } // End Method 
    
    public function Store(Request $request)
    {
        // dd($request->all());

        $imgae_file = $request->blog_image;
        $imageName2 = "";

        if ($imgae_file) {
            $var1 = date_create();
            $time1 = date_format($var1, 'YmdHis');
            $file_name = $imgae_file->getClientOriginalName();
            $imageName2 = $time1.'.'. $imgae_file->getClientOriginalExtension();
            $imgae_file->move(public_path('upload/admin_images/blog'), $imageName2);
        }
        else if(isset($request->old_blog_image) && $request->old_blog_image)
        {
            $imageName2 = $request->old_blog_image;
        }

        if($request->blog_id)
        {
            $book               = Blog::find($request->blog_id);
        }
        else
        {
            $book               = new Blog();
        }
        
        $book->author_id        = $request->input('author_id');
        $book->category_id      = $request->input('category_id');
        $book->name             = $request->input('name');
        $book->slug             = $request->input('author_slug');
        $book->blog_image       = $imageName2;
        $book->description      = $request->input('description');
        $book->meta_title       = $request->input('meta_name');
        $book->meta_description = $request->input('meta_description');
        $book->meta_keyword     = $request->input('meta_keyword');
        $book->status           = $request->input('status');
        $book->save();
        
        if ($request->id) {
            $notification = array(
                'message' => 'Blog Created Successfully', 
                'alert-type' => 'success'
            );
        }
        else
        {
            $notification = array(
                'message' => 'Blog Updated Successfully', 
                'alert-type' => 'success'
            );
        }
        return redirect()->route('blog.all')->with($notification);
    }
    
    public function Delete($id)
    {
        Blog::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function AllComments()
    {
        $ratings = BlogComment::latest()->get();
        return view('backend.blog.comments.all',compact('ratings'));
    }
    
    public function CommentEdit($id)
    {
        $ratingreview =BlogComment::where('id',$id)->first();
        return view('backend.blog.comments.edit',compact('ratingreview'));
    }
    
    public function CommentUpdate(Request $request)
    {
        // dd($request->all());

    
        // dd($imageName2);
        if($request->id)
        {
            $book               = BlogComment::find($request->id);
        }
        else
        {
            $book               = new BlogComment();
        }
        
        $book->comments        = $request->input('comments');
        $book->name            = $request->input('name');
        $book->email           = $request->input('email');
        $book->phone           = $request->input('phone');
        $book->status          = $request->input('status');
        $book->save();
        
        if ($request->id) {
            $notification = array(
                'message' => 'Blog Comment Created Successfully', 
                'alert-type' => 'success'
            );
        }
        else
        {
            $notification = array(
                'message' => 'Blog Comment Updated Successfully', 
                'alert-type' => 'success'
            );
        }
        return redirect()->route('blog.comments.all')->with($notification);
    }
    
    public function CommentDelete($id)
    {
        BlogComment::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Blog Comment Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
