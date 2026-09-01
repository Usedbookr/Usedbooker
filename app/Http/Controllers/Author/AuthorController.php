<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Auth;
use Illuminate\Support\Carbon;

class AuthorController extends Controller
{
    public function All(){
        $authors = User::where('user_type', 'user')->latest()->get();
        return view('backend.authors.all',compact('authors'));
    } // End Method 


    public function Add(){

        return view('backend.authors.add');
       } // End Method 


       public function Store(Request $request){

        Author::insert([
            'author' => $request->name,
           'status' =>$request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Author Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('users.all')->with($notification);

    } // End Method 



    public function Edit($id){

        $edit = User::findOrFail($id);
        // dd($edit);
        return view('backend.authors.edit',compact('edit'));

    } // End Method 
    
    public function details($id){

        $edit = User::findOrFail($id);
        $user_address = Address::where('user_id', $id)->latest()->get();
        return view('backend.authors.view',compact('edit', 'user_address'));

    } // End Method
    
    public function admin_edit_address($id)
    {
        // dd($id);
        $user_address = Address::where('id', $id)->first();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }

        $data['user_address'] = $user_address;
        $data['success'] = "success";

        return $data;
    }
    
    public function AddressDelete($id)
    {
        // dd($id);
        
        $user_address = Address::find($id);
        if($user_address->delete())
        {
            $notification = array(
                'message' => 'Address Delete successfully!', 
                'alert-type' => 'success'
            );
            
            return redirect()->back()->with($notification);
        }
        
        $notification = array(
            'message' => 'Address Delete successfully!', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function storeAddress(Request $request)
    {
        // dd($request->all());

        if ($request->default) {
            $set_address = Address::where('user_id', $request->user_id)->get();
            if ($set_address) {
                foreach ($set_address as $key => $value) {
                    
                    $address                = Address::findOrFail($value->id);
                    $address->is_default = "";
                    $address->save();
                    
                }
            }
        }
        

        if ($request->address_id) {
            $address                = Address::findOrFail($request->address_id);
        }
        else {
            $address                = new Address();
        }
        $address->user_id       = $request->user_id;
        $address->first_name    = $request->f_name;
        $address->last_name     = $request->l_name;
        $address->phone         = $request->phone;
        $address->email         = $request->email;
        $address->house_no      = $request->house_no;
        $address->street        = $request->street;
        $address->city          = $request->city;
        $address->state         = $request->state;
        $address->country       = $request->country;
        $address->zipcode       = $request->zipcode;
        $address->is_default    = $request->default;
        $address->save();
        // dd($address);
        if ($address) {
            
            $notification = array(
                'message' => 'Addres Edited successfully!', 
                'alert-type' => 'success'
            );
        
            return redirect()->back()->with($notification);
        }
        else{
            
            $notification = array(
                'message' => 'New Addres Saved successfully!', 
                'alert-type' => 'success'
            );
            
            return redirect()->back()->with($notification);
        }

    }

    public function Update(Request $request, $id){


        User::findOrFail($id)->update([
            'author' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('users.all')->with($notification);

    } // End Method 



    public function Delete($id){

        User::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 





}
