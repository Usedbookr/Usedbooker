<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\Ratingreview;

class RatingreviewController extends Controller
{
    public function All(){
        $ratings = Ratingreview::latest()->get();
        return view('backend.rating.all',compact('ratings'));
    } // End Method 


    public function Edit(Request $request, $id)
    {
        $ratingreview =Ratingreview::where('id',$id)->first();
        return view('backend.rating.edit',compact('ratingreview'));
    } // End Method 
    
    public function Update(Request $request)
    {
        $book = Ratingreview::find($request->input('id'));
        $book->rating = $request->input('rating');
        $book->review = $request->input('review');
        $book->status = $request->input('status');
        $book->save();
        
        $notification = array(
            'message' => 'Ratingreview Updated Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('ratingreview.all')->with($notification);
    }
    
    public function Delete($id)
    {
        Ratingreview::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method
    
       
}



