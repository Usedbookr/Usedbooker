<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Search;
use App\Models\Subscripe;
use App\Models\Admin;
use Excel;
use App\Exports\KeyWordExports;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
     public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully', 
            'alert-type' => 'success'
        );

        return redirect('/admin/login')->with($notification);
    } // End Method 


    public function Profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    }// End Method


    public function EditProfile(){

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    }// End Method 

    public function StoreProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
           $file = $request->file('profile_image');

           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['profile_image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully', 
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);

    }// End Method


    public function ChangePassword(){

        return view('admin.admin_change_password');

    }// End Method


    public function UpdatePassword(Request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password Updated Successfully');
            return redirect()->back();
        } else{
            session()->flash('message','Old password is not match');
            return redirect()->back();
        }

    }// End Method


    

    public function admin_setting()
    {
        $admin_details = Admin::where('id', 1)->first();
        return view('admin.admin_setting',compact('admin_details'));

    }

    public function SettingUpdate(Request $request, $id)
    {
        // dd($request->all());

        $admin_update                           = Admin::find($id);
        $admin_update->address_1                = $request->address_1;
        $admin_update->address_2                = $request->address_2;
        $admin_update->city                     = $request->city;
        $admin_update->state                    = $request->state;
        $admin_update->country                  = $request->country;
        $admin_update->zip_code                 = $request->zip_code;
        $admin_update->gst_number               = $request->gst_number;
        $admin_update->phone                    = $request->phone;
        $admin_update->email                    = $request->email;
        $admin_update->facebook                 = $request->facebook;
        $admin_update->twitter                  = $request->twitter;
        $admin_update->instagram                = $request->instagram;
        $admin_update->pinterest                = $request->pinterest;
        $admin_update->cod_charge               = $request->cod_charge;
        $admin_update->min_weight               = $request->min_weight;
        $admin_update->weight_amount            = $request->weight_amount;
        $admin_update->referral_receiver_amount = $request->referral_receiver_amount;
        $admin_update->referral_sender_amount   = $request->referral_sender_amount;
        $admin_update->meta_name                = $request->meta_name;
        $admin_update->meta_description         = $request->meta_description;
        $admin_update->meta_keyword             = $request->meta_keyword;
        if ($admin_update->save()) {
            $notification = array(
                'message' => 'Setting Update successfully', 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        $notification = array(
            'message' => 'Something Wrong', 
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function subscribe_user()
    {
        $search_data = Subscripe::get();
        return view('admin.subscribe_user',compact('search_data'));

    }

    public function search()
    {
        $search_data = Search::latest()->paginate(100);
        // dd($search_data);
        return view('admin.search',compact('search_data'));

    } 

    public function SearchDownload()
    {
        return Excel::download(new KeyWordExports(), 'KeyWords.xlsx');
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    public function apiLogs(Request $request)
    {
        $query = ApiLog::query();

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('module', 'LIKE', "%{$search}%")
                    ->orWhere('service', 'LIKE', "%{$search}%")
                    ->orWhere('request_type', 'LIKE', "%{$search}%")
                    ->orWhere('endpoint', 'LIKE', "%{$search}%")
                    ->orWhere('ip_address', 'LIKE', "%{$search}%")
                    ->orWhere('request_url', 'LIKE', "%{$search}%")
                    ->orWhere('reference_type', 'LIKE', "%{$search}%")
                    ->orWhere('reference_id', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('error_message', 'LIKE', "%{$search}%");

            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Module filter
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // All logs - latest first
        $apiLogs = $query
            ->orderBy('id', 'DESC')
            ->paginate(25)
            ->withQueryString();

        // Modules
        $modules = ApiLog::whereNotNull('module')
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        return view(
            'backend.errorlog.all',
            compact('apiLogs', 'modules')
        );
    }
    public function apiLogDetails($id)
    {
        $apiLog = ApiLog::findOrFail($id);

        return view(
            'backend.errorlog.details',
            compact('apiLog')
        );
    }
}