<?php

namespace App\Http\Controllers\BookCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookCondition;
use Auth;
use Illuminate\Support\Carbon;

class BookConditionController extends Controller
{
       public function All(){
        $conditions = BookCondition::latest()->get();
        return view('backend.book_conditions.all',compact('conditions'));
    } // End Method 


    public function Add(){
     return view('backend.book_conditions.add');
    } // End Method 


    public function Store(Request $request){

        BookCondition::insert([
            'name' => $request->name,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Condition Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('book_conditions.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = BookCondition::findOrFail($id);
        return view('backend.book_conditions.edit',compact('edit'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        BookCondition::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('book_conditions.all')->with($notification);

    } // End Method 


    public function Delete($id){

        BookCondition::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 
}
