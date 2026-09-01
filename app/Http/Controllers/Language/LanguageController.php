<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Auth;
use Illuminate\Support\Carbon;

class LanguageController extends Controller
{
    public function All(){
        $languages = Language::latest()->get();
        return view('backend.language.all',compact('languages'));
    } // End Method 
    
    
    public function ApiAll(){
        $languages = Language::latest()->get();
        return response([
            'success' => true,
            'languages' => $languages
        ]);
    } // End Method 

    public function Add(){
     return view('backend.language.add');
    } // End Method 


    public function Store(Request $request){

        Language::insert([
            'name' => $request->name,
            'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

        $notification = array(
            'message' => 'Condition Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('languages.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = Language::findOrFail($id);
        return view('backend.language.edit',compact('edit'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        Language::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('languages.all')->with($notification);

    } // End Method 


    public function Delete($id){

        Language::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 
}
