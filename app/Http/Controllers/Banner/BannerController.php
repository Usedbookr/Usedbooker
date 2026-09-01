<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Auth;
use File;
use Illuminate\Support\Carbon;


class BannerController extends Controller
{
    public function All(){
        $banners = Banner::latest()->get();
        return view('backend.banner.all',compact('banners'));
    } // End Method 


    
    Public function ApiAll(){
        $banners = Banner::Where('status',1)->get();
        if($banners->isNotEmpty()){
            foreach($banners as $banner){
                $banner->images = asset($banner->images);
            }
        }
        return response([
            'success' => true,
            'banners' => $banners
        ]);
        //return view('backend.category.all',compact('categories'));
    }


    public function Add(){
     return view('backend.banner.add');
    } // End Method 


    public function Store(Request $request){
        
        // dd($request->all());
        
        $imageName = '';
        if($request->hasFile('userfile')){
            $imageName = time().'.'.$request->userfile->extension(); 
            $request->userfile->move(public_path('upload/admin_images/banner'), $imageName); 
        }
        $bcount = Banner::Where('btype',$request->btype)->count();
        
        if($request->btype == 'T'){
            if($bcount >= 1){
                $notification = array(
                    'message' => 'Top Side Banner uploaded only 1', 
                    'alert-type' => 'error'
                );
                return redirect()->route('banners.all')->with($notification);    
            }
            
        }
        elseif($request->btype =='B')
        {
            if($bcount >= 1)
            {
                $notification = array(
                    'message' => 'Bottom Banner uploaded only 1', 
                    'alert-type' => 'error'
                );
                return redirect()->route('banners.all')->with($notification); 
            }
        }
        
        Banner::insert([
            'btype' => $request->btype,
            'hreflink' => $request->hreflink,
            'name' => $request->name,
            'status' =>1,
            'images' => 'public/upload/admin_images/banner/'.$imageName,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

        $notification = array(
            'message' => 'Banner Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('banners.all')->with($notification);

    } // End Method 

    public function Delete($id)
    {

        $image_path = Banner::where('id', $id)->first();
        $filePath = $image_path->images;
                                   
        if(File::exists($filePath))
        {
            File::delete($filePath);
        }
        else
        {
            // dd("hlo");
        }

        Banner::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
    

    
}
