<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Auth;
use Illuminate\Support\Carbon;

class CountryController extends Controller
{
    public function All(){
        $countries = Country::latest()->get();
        return view('backend.countries.all',compact('countries'));
    } // End Method 


    
    Public function ApiAll(){
        $countries = Country::where('status',1)->get();
        return response([
            'success' => true,
            'countries' => $countries
        ]);
        //return view('backend.category.all',compact('categories'));
    }


    public function Add(){
     return view('backend.countries.add');
    } // End Method 


    public function Store(Request $request){

        Country::insert([
            'name' => $request->name,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Country Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('countries.all')->with($notification);

    } // End Method 


    public function Edit($id){

        $edit = Country::findOrFail($id);
        return view('backend.countries.edit',compact('edit'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        Country::findOrFail($id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('countries.all')->with($notification);

    } // End Method 


    public function Delete($id){

        Country::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 
}
