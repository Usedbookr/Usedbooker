<?php

namespace App\Http\Controllers\Binding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Binding;
use Auth;
use Illuminate\Support\Carbon;

class BindingController extends Controller
{
    public function All(){
        $bindings = Binding::latest()->get();
        return view('backend.binding.all',compact('bindings'));
    } // End Method 

    public function Add(){
     return view('backend.binding.add');
    } // End Method 


    public function Store(Request $request){

        Binding::insert([
            'name' => $request->name,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Binding Type Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('bindings.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = Binding::findOrFail($id);
        return view('backend.binding.edit',compact('edit'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        Binding::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('bindings.all')->with($notification);

    } // End Method 


    public function Delete($id){

        Binding::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

}
