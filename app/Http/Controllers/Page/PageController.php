<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Auth;
use Illuminate\Support\Carbon;


class PageController extends Controller
{
    public function All(){
        $pages = Page::latest()->get();
        return view('backend.page.all',compact('pages'));
    }


    public function Add()
    {
        return view('backend.page.add');
    }


    public function Store(Request $request)
    {
        Page::insert([
            'name' => $request->name,
            'details' => $request->details,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 
        ]);

        $notification = array(
            'message' => 'Page Inserted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('pages.all')->with($notification);
    }

    public function Edit($id)
    {
        $edit = Page::findOrFail($id);
        if ($id == 4) {
            return view('backend.page.edit-faq',compact('edit'));
        }
        return view('backend.page.edit',compact('edit'));
    }

    public function Update(Request $request)
    {
        $id = $request->id;
        // dd($request->all());
        $store_dynamic_data = [];
        if ($id == 4) {
            foreach ($request->addmore as $key => $value) {
                $store_dynamic_data[$key] = [
                    "title"          => $value['title'],
                    "content"        => $value['content'],
                ];
            }
            Page::findOrFail($id)->update([
                'name' => $request->name,
                'details' => json_encode($store_dynamic_data),
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(), 
                'meta_name' => $request->meta_name,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);
        }
        else
        {
            Page::findOrFail($id)->update([
                'name' => $request->name,
                'details' => $request->details,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(), 
                'meta_name' => $request->meta_name,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);
        }
        
         $notification = array(
            'message' => ' Updated Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('pages.all')->with($notification);
    }

    public function Delete($id)
    {
        Page::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    

    
}
