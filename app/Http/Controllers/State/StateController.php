<?php

namespace App\Http\Controllers\State;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;

use Auth;
use Illuminate\Support\Carbon;

class StateController extends Controller
{
    public function All(){
        $states = State::latest()->get();
        return view('backend.states.all',compact('states'));
    } // End Method 


    
    Public function ApiAll(){
        $states = State::where('status',1)->get();
        return response([
            'success' => true,
            'states' => $states
        ]);
        //return view('backend.category.all',compact('categories'));
    }


    public function Add(){
        $countries = Country::where('status',1)->get();
     return view('backend.states.add',compact('countries'));
    } // End Method 


    public function Store(Request $request){

        State::insert([
            'name' => $request->name,
           'status' =>$request->status,
           'country_id' =>$request->country,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'State Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('states.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = State::findOrFail($id);
        $countries = Country::where('status',1)->get();
       
        return view('backend.states.edit',compact('edit','countries'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        State::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'country_id' =>$request->country,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('states.all')->with($notification);

    } // End Method 


    public function Delete($id){

        State::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 
}
