<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use Auth;
use Illuminate\Support\Carbon;

class CityController extends Controller
{
    public function All(){
        $cities = City::latest()->get();
        return view('backend.cities.all',compact('cities'));
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
     $countries = Country::where('status','1')->get();
     return view('backend.cities.add',compact('countries'));
    } // End Method 


    public function Store(Request $request){

        City::insert([
            'name' => $request->name,
            'country_id' => $request->country,
            'state_id' => $request->state,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'City Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('cities.all')->with($notification);

    } // End Method 


    public function Edit($id){
        $countries = Country::where('status','1')->get();
        $edit = City::findOrFail($id);
        $states = State::where('status',1)->get();
        return view('backend.cities.edit',compact('edit','countries','states'));

    } // End Method 

    public function Update(Request $request){

        $id = $request->id;

        City::findOrFail($id)->update([
            'name' => $request->name,
            'country_id' => $request->country,
            'state_id' => $request->state,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('cities.all')->with($notification);

    } // End Method 


    public function Delete($id){

        City::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 


    
    public function FetchStates(Request $request){
        $data['states'] = State::where("country_id", $request->country_id)
        ->get(["name", "id"]);
    
    return response()->json($data);
    }


}
